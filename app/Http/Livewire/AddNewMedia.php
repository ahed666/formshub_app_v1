<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FormMedia;
use App\Models\FormMediaConfig;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Kiosk;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\DeviceRefresh;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Carbon\Carbon;
use App\Jobs\RefreshKiosks;
use Image;
use Livewire\WithFileUploads;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;

use Pawlox\VideoThumbnail\Facade\VideoThumbnail;
use FFMpeg\Coordinate\TimeCode;
class AddNewMedia extends Component
{  use WithFileUploads;
    public $modal = false;
    public $media;
    public $currentFile;
    public $currentFilePath;
    public $uploading=false;
    public $currentMediaType;
    public $imagesrc;
    public $currentTempImagePath;
    public $form_id;
    public $duration=5;
    public $video;
    public $mediaId;
    public $edit=false;
    public $maxVideoDuration=180;
    public $maxFileSize=10240;
    public $validVideo=false;
    public $base64Video;
    public $current_subscribe;
    public $numMediaItems;
    public $valid;
    public $error;
    protected $listeners = [


            'addNewMedia'=>'addNewMedia',
            'editMedia'=>'editMedia'

    ];
    // for edit media
    public function editMedia($mediaId){
        $this->uploading=true;
        $this->mediaId=$mediaId;
        $this->media=FormMedia::whereid($this->mediaId)->first();
        $this->edit=true;
        if($this->media!=null)
        {
                $formAccount=Form::whereid($this->media->form_id)->first()->account_id;
                if($formAccount!=Auth::user()->current_account_id)
                    abort(403, 'Unauthorized action.');
                $this->currentFilePath=$this->media->path;
                $this->duration=$this->media->duration;
                $this->currentMediaType=$this->media->type;
                $this->validVideo=true;
        }
        $this->uploading=false;
    }
    public function mount($id){
        $this->form_id=$id;
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->numMediaItems=FormMedia::whereform_id($this->form_id)->count();

        if($this->numMediaItems<$this->current_subscribe->num_media_items)
            $this->valid=true;
        else
        {
            $this->valid=false;
            $this->error=trans('main.num_media_'.$this->current_subscribe->type);
        }

    }
    public function updatedcurrentFile(){
        $this->uploading=true;
           try
           {


            // $this->dispatchBrowserEvent('image-updated-edit', ['image' => $this->image]);
            $mime = $this->currentFile->getMimeType();

            if(strstr($mime, "video/")){

                $this->currentMediaType="video";
                $this->video=$this->currentFile;

                $getID3 = new \getID3;
                $video_file = $getID3->analyze($this->currentFile->path());
                $this->duration=ceil($video_file['playtime_seconds']);

                if($this->duration>$this->maxVideoDuration)
                {   $this->dispatchBrowserEvent('error',['title'=>'error' ,'message'=>trans('main.maxvideodurationwarning',['duration'=>$this->maxVideoDuration])]);
                    $this->validVideo=false;
                    $this->currentFile=null;
                    $this->duration=5;
                    $this->currentMediaType=null;
                }
                elseif($this->currentFile->getSize() > $this->maxFileSize * 1024)
                {
                    dd($this->currentFile->getSize());
                    $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.maxfilesizewarning',['size'=>$this->maxFileSize])]);
                    $this->validVideo = false;
                    $this->currentFile = null;
                    $this->duration =5;
                    $this->currentMediaType = null;
                }
                else
                { $this->validVideo=true;


                    $this->currentFilePath=$this->currentFile->temporaryUrl();
                }


            }
            else if(strstr($mime, "image/")){
                $this->currentFilePath=$this->currentFile->temporaryUrl();
                $this->modal=true;
                $this->currentMediaType="image";
                $this->imagesrc=$this->currentFilePath;
                $this->dispatchBrowserEvent('image-updated-edit');
                $this->duration=5;
            }
            else
            {
                $this->validVideo = false;
            $this->currentFile = null;
            $this->duration =5;
            $this->currentMediaType = null;
              $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.errorinfile')]);
            }


            $this->uploading=false;

          }
           catch (\Throwable $th)
           {
            $this->dispatchBrowserEvent('error', ['title' => 'Error', 'message' => trans('main.errorupload')]);

           }
    }
    // save image as temp after crop it
    public function saveImageTemp($image){
        $folderPath = public_path('storage/images/temp/media/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = Image::make($image_base64);

        $this->modal=false;
        $this->changeToDefult=true;

        $name="formMediaImage_".$this->form_id.Auth::user()->id.uniqid().Carbon::now()->format('YmdHis').".jpg";
        $file = $folderPath.$name;
        if(str_contains($this->currentTempImagePath, 'storage/images/temp/media/'))
        {
            File::delete(public_path($this->currentTempImagePath));
        }
        $this->currentTempImagePath="storage/images/temp/media/".$name;
        $this->currentFilePath=$this->currentTempImagePath;
        $this->dispatchBrowserEvent('changeImagePath',['path'=>$this->currentTempImagePath]);
        $image->save($file, 100);


    }
    public function resetvalues(){

        // delete temp files
        if($this->currentMediaType=="image"&&$this->currentTempImagePath!=null)
        File::delete(public_path($this->currentTempImagePath));
        elseif($this->currentMediaType=="video"&&$this->video!=null)
        File::delete($this->video->path());


        $this->validVideo=false;
        $this->currentFile=null;
        $this->edit=false;
        $this->duration=5;
        $this->currentMediaType=null;
        $this->currentFilePath=null;
    }
    public function closemodal(){
        $this->modal=false;
    }
    public function closemodalwithsave(){

        $this->modal=false;
    }
    // validation
    public function validateMedia(){

        if($this->currentMediaType=="video")
        $this->validate(['video' =>['required'],'duration' =>['required','numeric','min:1']],['currentFilePath.required'=>trans('main.filerequired'),'duration.required'=>trans('main.durationrequired'),'duration.min'=>trans('main.minduration')]);
        else
        $this->validate(['currentFilePath' =>['required'],'duration' =>['required','numeric','min:1']],[ 'currentFilePath.required'=>trans('main.filerequired'),'duration.required'=>trans('main.durationrequired'),'duration.min'=>trans('main.minduration')]);

    }

    public function saveFile(){
        // validate
       $this->validateMedia();
       $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

       try
       {



              //if reach to maximum num item media add
                if($this->numMediaItems==$this->current_subscribe->num_media_items)
                   return redirect()->route('editform', ['id' => $this->form_id])->with('error_message','cannnot be add');
                else
                {
                    // if add video
                    if($this->currentMediaType=="video")
                    {
                            $fileNameToStore = "Video_" . $this->form_id . Auth::user()->id . uniqid() . Carbon::now()->format('YmdHis') . ".mp4";

                            // Convert and save the video
                            $path = $this->video->storeAs('storage/videos',$fileNameToStore);
                    }
                    // if add image
                    else
                    {
                            $folderPath ='storage/images/upload/media/';
                            if(str_contains($this->currentTempImagePath, 'storage/images/temp/media/'))
                            {
                                $fileNameToStore="image-".$this->form_id.Auth::user()->id.Carbon::now()->format('YmdHis');
                                $name=$fileNameToStore . '.jpg';
                                $path = $folderPath .$name;
                                $old=public_path($this->currentTempImagePath);

                                File::move($old , $path);
                            }

                            else
                            {
                            $path=$this->currentTempImagePath;
                            }

                    }

                    // save media item
                    $formMedia=new FormMedia();
                    $formMedia->form_id=$this->form_id;
                    $formMedia->file_name=$fileNameToStore;
                    $formMedia->path=$path;
                    $formMedia->type=$this->currentMediaType;
                    $formMedia->duration=$this->duration;
                    $formMedia->media_order=count(FormMedia::whereform_id($this->form_id)->get())+1;
                    $formMedia->save();

                    if($this->currentMediaType=="video")
                    // Optionally, you can delete the temporary file
                    File::delete($this->video->path());
                }

            return redirect()->route('editform', ['id' => $this->form_id])->with('success_message','your question has been added successfuly');
        }
        catch (\Throwable $th) {
            return redirect()->route('editform', ['id' => $this->form_id])->with('error_message',trans('main.addnewmediafailed_text'));

        }

    }
    public function render()
    {
        return view('livewire.add-new-media');
    }
}
