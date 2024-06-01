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
{
    use WithFileUploads;
    public $modal = false;
    public $media;
    public $currentFile;
    public $base64StringVideo;
    public $currentFilePath;
    public $currentMediaType;
    public $imagesrc;
    public $currentTempImagePath;
    public $form_id;
    public $duration = 5;
    public $video;
    public $mediaId;
    public $edit = false;
    public $maxVideoDuration = 180;
    public $maxFileSize = 10;
    public $validVideo = false;
    public $base64Video;
    public $current_subscribe;
    public $numMediaItems;
    public $valid;
    public $error;
    protected $listeners = [


        'addNewMedia' => 'addNewMedia',
        'editMedia' => 'editMedia'

    ];
    // for edit media
    //now is disabled
    public function editMedia($mediaId)
    {

        $this->mediaId = $mediaId;
        $this->media = FormMedia::whereid($this->mediaId)->first();
        $this->edit = true;
        if ($this->media != null) {
            $formAccount = Form::whereid($this->media->form_id)->first()->account_id;
            if ($formAccount != Auth::user()->current_account_id)
                abort(403, 'Unauthorized action.');
            $this->currentFilePath = $this->media->path;
            $this->duration = $this->media->duration;
            $this->currentMediaType = $this->media->type;
            $this->validVideo = true;
        }

    }
    public function mount($id)
    {
        $this->form_id = $id;
        $this->current_subscribe = SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->numMediaItems = FormMedia::whereform_id($this->form_id)->count();

        if ($this->numMediaItems < $this->current_subscribe->num_media_items)
            $this->valid = true;
        else {
            $this->valid = false;
            $this->error = trans('main.num_media_' . $this->current_subscribe->type);
        }
    }
    // this function called from forntend when user upload video and set duration and data of video
    public function saveVideo($videoData,$duration)
    {
        $this->currentMediaType = "video";
        $this->duration = $duration;
        $this->validVideo = true;
        $this->currentFilePath = $videoData;

    }
    // this function called from forntend when user upload image and crop it
    public function saveImage($image, $index)
    {

        $this->currentFilePath = $image;
        $this->currentMediaType="image";

    }
    public function resetvalues()
    {



        $this->validVideo = false;
        $this->currentFile = null;
        $this->edit = false;
        $this->duration = 5;
        $this->currentMediaType = null;
        $this->currentFilePath = null;
    }
    public function closemodal()
    {
        $this->modal = false;
    }
    public function closemodalwithsave()
    {

        $this->modal = false;
    }
    // validation
    public function validateMedia()
    {

        if ($this->currentMediaType == "video")
            $this->validate([ 'duration' => ['required', 'numeric', 'min:1']],
        ['currentFilePath.required' => trans('main.filerequired'), 'duration.required' => trans('main.durationrequired'), 'duration.min' => trans('main.minduration')]);
        else
            $this->validate(['currentFilePath' => ['required'], 'duration' => ['required', 'numeric', 'min:1']],
        ['currentFilePath.required' => trans('main.filerequired'),
        'duration.required' => trans('main.durationrequired'), 'duration.min' => trans('main.minduration')]);
    }

    // save media item

    public function saveFile()
    {

        // validate
        $this->validateMedia();
        $this->current_subscribe = SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        try {



            //if reach to maximum num item media add
            if ($this->numMediaItems == $this->current_subscribe->num_media_items)
                return redirect()->route('editform', ['id' => $this->form_id])->with('error_message', 'cannnot be add');
            else
            {
                // save media item
                if($this->currentMediaType == "image")
                $mediaItem=FormMedia::saveMediaItem($this->currentFilePath ,$this->form_id,$this->currentMediaType, $this->duration);
                else
                $mediaItem=FormMedia::saveMediaItem( $this->currentFile ,$this->form_id,$this->currentMediaType, $this->duration);


            }

            return redirect()->route('editform', ['id' => $this->form_id])->with('success_message', 'your question has been added successfuly');
        } catch (\Throwable $th) {
            return redirect()->route('editform', ['id' => $this->form_id])->with('error_message', trans('main.addnewmediafailed_text'));
        }

    }
    public function render()
    {
        return view('livewire.add-new-media');
    }
}
