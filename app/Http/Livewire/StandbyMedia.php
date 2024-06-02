<?php

namespace App\Http\Livewire;

use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Form;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\FormTrnslations;
use App\Models\AnswersTranslation;
use App\Models\QuestionType;
use Storage;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
use App\Events\DeviceRefresh;
use Illuminate\Foundation\Events\Dispatchable;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\StandbykiosksMedia;
use Illuminate\Support\Facades\URL;
use App\Jobs\RefreshKiosk;
use App\Jobs\RefreshSignatueAccount;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Redirect;


use Owenoj\LaravelGetId3\GetId3;
use FFMpeg\FFMpeg;
use Livewire\Component;

class StandbyMedia extends Component
{
    use WithFileUploads;
    public $idEditingImage;
    public $modal;
    public $imagesrc;
    public $image;
    public $media;
    public $currentFile;
    public $change=false;
    public $uploading = false;

    public $currentTempImagePath;
    public $form_id;
    public $duration = 5;
    public $video;
    public $mediaId;
    public $maxVideoDuration = 180;
    public $maxFileSize = 10240;
    public $validVideo = false;
    public $base64Video;
    public $numMediaItems;
    public $error;
    public $changeToDefult = false;

    public $type;
    public $path;
    public $idEditingImageId;
    // listeners
    protected $listeners=[

        'setEditMediaId'=>'setEditMediaId',


        ];
        // function called from kiosk livewire to set what the id of kiosk that want edit (idEditingImageId)
    public function setEditMediaId($id)
    {
        $this->idEditingImageId = $id;
        $kiosk = Kiosk::whereid($this->idEditingImageId)->first();
        $currentStandbyMedia = StandbykiosksMedia::whereid($kiosk->standbymedia_id)->first();
        $this->path= $currentStandbyMedia->path_file;
        $this->type= $currentStandbyMedia->type;
        $this->duration= $currentStandbyMedia->duration;
        $this->uploading = false;
        $this->dispatchBrowserEvent('media-edited', ['type' =>$this->type, 'path' =>$this->path ]);


    }
    // on upload new file
    public function updatedcurrentFile(){
        $mime = $this->currentFile->getMimeType();
        if (strstr($mime, "video/"))
        {

            $this->type = "video";
            $this->video = $this->currentFile;

            $getID3 = new \getID3;
            $video_file = $getID3->analyze($this->currentFile->path());
            $this->duration = ceil($video_file['playtime_seconds']);

            if ($this->duration > $this->maxVideoDuration) {
                $this->dispatchBrowserEvent('error', ['title' => 'error', 'message' => trans('main.maxvideodurationwarning', ['duration' => $this->maxVideoDuration])]);
                $this->validVideo = false;
                $this->currentFile = null;
                $this->duration = null;
                $this->type = null;

            } elseif ($this->currentFile->getSize() > $this->maxFileSize * 1024) {

                $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.maxfilesizewarning', ['size' => $this->maxFileSize])]);
                $this->validVideo = false;
                $this->currentFile = null;
                $this->duration = null;
                $this->type = null;
            } else {

                $this->validVideo = true;

                $this->path = $this->currentFile->temporaryUrl();


            }

            $this->dispatchBrowserEvent('media-edited', ['type' => $this->type, 'path' =>$this->path ]);


        }
    }
     // this function called from forntend when user upload video and set  data of video
    // public function saveVideo($videoData,$duration)
    // {
    //     $this->uploading = true;
    //     $this->change=true;
    //     $this->path=$videoData;
    //     $this->type= "video";
    //     $this->uploading = false;

    //     $this->dispatchBrowserEvent('media-edited', ['type' =>'video', 'path' =>$this->path ]);


    // }


    // save image as temp after crop it
    public function saveImage($image,$index)
    {
        $this->path = $image;
        $this->type= "image";
        $this->dispatchBrowserEvent('media-edited', ['type' =>'image', 'path' =>$this->path ]);



    }
    // set defult stand by image
    public function setDefultStandByImage()
    {


        $this->path = "images/default_images/default_standbyimage.gif";
        $this->changeToDefult = true;
        $this->type = "image";
        $this->change=true;
        $this->dispatchBrowserEvent('media-edited', ['type' =>'image', 'path' =>$this->path ]);


    }

    // after close the modal of crop iimage
    public function closemodal()
    {
        $this->modal = false;

    }

    public function saveStandbyMediaKiosk()
    {


        try {


        $kiosk = Kiosk::findOrFail($this->idEditingImageId);
        $standbyMedia = StandbykiosksMedia::whereid($kiosk->standbymedia_id)->first();

        $standbyMedia->type = $this->type;
        // delete prev file
        if (str_contains($standbyMedia->path_file, 'standby_')) {
            File::delete(public_path($standbyMedia->path_file));
        }

        if ($this->type == "video"&&$this->video) {

            $fileNameToStore = "standby_" . $kiosk->id . ".mp4";
            $pathStore='storage/accounts/account-'.Auth::user()->current_account_id.'/kiosks/standby';
            if (!file_exists($pathStore)) {
                mkdir($pathStore, 0755, true);
            }

            $newUrl = $this->video->storeAs($pathStore, $fileNameToStore);

            $standbyMedia->path_file = $newUrl;
            $standbyMedia->duration = $this->duration;
            $standbyMedia->save();

        } elseif($this->type == "image") {
            //    save image


            if (str_contains($this->path, 'data:image')) {

                $fileNameToStore = "standby_" . $kiosk->id  . ".jpg";
                $pathStore='storage/accounts/account-'.Auth::user()->current_account_id.'/kiosks/standby/';
                $newUrl = $pathStore .$fileNameToStore;
                $image_parts = explode(";base64,", $this->path);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = Image::make($image_base64); // Use Intervention Image to handle the image
                $image->save($newUrl, 100);

            } else {

                $newUrl = $this->path;

            }
            $standbyMedia->path_file = $newUrl;
            $standbyMedia->duration = $this->duration;
            $standbyMedia->save();

        }


        return redirect()->route('kiosks')->with(['updatedmessage'=>$kiosk->id]);

        }
        catch (\Throwable $th) {
            
        }


    }
    public function resetValue()
    {
        if (str_contains($this->currentTempImagePath, 'storage/images/temp/')) {
            File::delete(public_path($this->currentTempImagePath));
        }
        $this->mount();
    }
    // t oclose crop modal if user click save
    public function closemodalwithsave()
    {

        $this->modal = false;
    }
    public function render()
    {
        return view('livewire.standby-media');
    }
}
