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
use Image;
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
    public $maxFileSize = 8000;
    public $validVideo = false;
    public $base64Video;
    public $numMediaItems;
    public $error;
    public $changeToDefult = false;

    public $type;
    public $path;
    // listeners
    protected $listeners=[

        'setEditMediaId'=>'setEditMediaId',


        ];
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
    // update temporary image for kiosk
    public function updatedcurrentFile()
    {
        $this->uploading = true;
        $this->change=true;
        //    try
        //    {

        // $this->dispatchBrowserEvent('image-updated-edit', ['image' => $this->image]);
        $mime = $this->currentFile->getMimeType();

        if (strstr($mime, "video/")) {

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


        } else if (strstr($mime, "image/")) {
            $this->path = $this->currentFile->temporaryUrl();
            $this->modal = true;
            $this->type = "image";
            $this->imagesrc = $this->path;
            $this->dispatchBrowserEvent('image-updated-edit');
            $this->duration = null;

        } else {
            $this->validVideo = false;
            $this->currentFile = null;
            $this->duration = null;
            $this->type = null;
            $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.errorinfile')]);
        }

        $this->uploading = false;

        //   }
        //    catch (\Throwable $th)
        //    {
        //     $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.errorupload')]);

        //    }
    }

    // after click save crop changes
    public function cropimage()
    {
        $this->dispatchBrowserEvent('save');

    }
    // save image as temp after crop it
    public function saveImageTemp($image)
    {
        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = Image::make($image_base64);

        $this->modal = false;
        $this->changeToDefult = true;

        $name = "StandByKioskImage_" . $this->idEditingImageId . Auth::user()->id . uniqid() . Carbon::now()->format('YmdHis') . ".jpg";
        $file = $folderPath . $name;
        if (str_contains($this->currentTempImagePath, 'storage/images/temp/')) {
            File::delete(public_path($this->currentTempImagePath));
        }
        $this->currentTempImagePath = "storage/images/temp/" . $name;
        $this->dispatchBrowserEvent('media-edited', ['type' =>'image', 'path' =>$this->currentTempImagePath ]);

        $image->save($file, 100);

    }
    // set defult stand by image
    public function setDefultStandByImage()
    {

        if (str_contains($this->currentTempImagePath, 'storage/images/temp/')) {
            File::delete(public_path($this->currentTempImagePath));
        }
        $this->currentTempImagePath = "images/default_images/default_standbyimage.gif";
        $this->changeToDefult = true;
        $this->type = "image";
        $this->change=true;
        $this->dispatchBrowserEvent('media-edited', ['type' =>'image', 'path' =>$this->currentTempImagePath ]);


    }
    // after close the modal of crop iimage
    public function closemodal()
    {
        $this->modal = false;

    }
    public function saveStandbyMediaKiosk()
    {

        $kiosk = Kiosk::findOrFail($this->idEditingImageId);
        $standbyMedia = StandbykiosksMedia::whereid($kiosk->standbymedia_id)->first();
        if (str_contains($standbyMedia->path_file, 'storage/videos/standby/') || str_contains($standbyMedia->path_file, 'storage/images/upload/standby/')) {
            File::delete(public_path($standbyMedia->path_file));
        }
        $standbyMedia->type = $this->type;

        if ($this->type == "video"&&$this->change==true) {

            $fileNameToStore = "standbyvideo_" . $kiosk->id . Auth::user()->id . Carbon::now()->format('YmdHis') . ".mp4";
            $path = $this->video->storeAs('storage/videos/standby', $fileNameToStore);

            $standbyMedia->path_file = $path;
            $standbyMedia->duration = $this->duration;
            $standbyMedia->save();

        } elseif($this->type == "image"&&$this->change==true) {
            //    save image

            $folderPath = 'storage/images/upload/standby';
            if (str_contains($this->currentTempImagePath, 'storage/images/temp/')) {

                $image_name = "standbyimage-" . $kiosk->id . Auth::user()->id . Carbon::now()->format('YmdHis');
                $name = $image_name . '.jpg';
                $file = $folderPath . $name;
                $old = public_path($this->currentTempImagePath);
                $new = $file;

                if (str_contains($standbyMedia->path_file, 'storage/images/upload/standby') && $this->changeToDefult == true) {
                    File::delete(public_path($standbyMedia->path_file));
                }

                File::move($old, $new);

            } else {

                $new = $this->currentTempImagePath;

            }
            $standbyMedia->path_file = $new;
            $standbyMedia->duration = $this->duration;
            $standbyMedia->save();

        }


        return redirect()->route('kiosks')->with(['updatedmessage'=>$kiosk->id]);


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
