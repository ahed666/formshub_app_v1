<?php

namespace App\Http\Livewire\Forms\Edit;

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
use Livewire\WithFileUploads;
class EditFormMedia extends Component
{  use WithFileUploads;
    public $current_form_id;
    public $media_delete_id;
    public $form_config;
    public $current_form;
    public $current_form_kiosks;
    public $currentFile;
    public $currentFilePath;
    //    to set the id of form that want user delete it

    // add form details
    public $form_logo;
    public $logosrc;
    public $logo;
    public $form_Name;
    public $modal = false;
    // end add form details

    //    edit question
    public $mediaediting;
    public $current_media;
    public $modalopen = false;


    //    form options

    public $service = false;
    public $allowTouch=false;
    public $allowLoop=false;

    // end of form options
    //subscribe
    public $validAccount;
    public $current_subscribe;
    public $accountStatus;

    //end of subscribe

    public $enableEditDuration=false;
    public $editDurationMediaId;

    public $editDurationMediaValue;

    public $mediaEditVolumeId;
    public $enableEditVolume;
    public $volume;



    protected $listeners = [
        // to update form every second
        'updatecurrentform' => 'update_formkiosks',
         //select form
         'selectform'=>'selectform',
        // to delete question
        'deleteMediaConfirmed' => 'deleteMedia',
        // to delete terms

        //  to refresh after edit message
        'messageeditsuccess' => 'messageeditsuccess',

        //    to refresh after edit form
        'formeditsuccess' => 'formeditsuccess',

        //  to refresh after edit question

        //  to refresh after add question

        'updateKiosks'=>'updateformonkiosks',

       'featchMedia'=>'featchMedia'


    ];
    public function editMediaMute($id){
        $mediaItemEdit=FormMedia::whereid($id)->first();
        $mediaItemEdit->mute=!$mediaItemEdit->mute;
        $mediaItemEdit->save();
        $this->mount($this->current_form_id);

        $this->dispatchBrowserEvent('contentChanged');
    }
    public function enableEditVolume($id,$volume){
        $this->enableEditVolume=true;
        $this->mediaEditVolumeId=$id;
        $this->volume=$volume;
    }

    public function editVolume(){

      $mediaItemEdit=FormMedia::whereid($this->mediaEditVolumeId)->first();
      $mediaItemEdit->volume=$this->volume;
      $mediaItemEdit->save();
      $this->enableEditVolume=false;
      $this->mediaEditVolumeId=null;
      $this->mount($this->current_form_id);

      $this->dispatchBrowserEvent('contentChanged');
    }

     public function enableEditDuration($id,$time){
        $this->enableEditDuration=true;
        $this->editDurationMediaId=$id;
        $this->editDurationMediaValue=$time;
     }
     public function editDuration(){
        $mediaItemEdit=FormMedia::whereid($this->editDurationMediaId)->first();


        $mediaItemEdit->duration=$this->editDurationMediaValue;
        $mediaItemEdit->save();
        $this->editDurationMediaValue=null;
        $this->editDurationMediaId=null;
        $this->enableEditDuration=false;
        $this->mount($this->current_form_id);

        $this->dispatchBrowserEvent('contentChanged');
     }
    public function deleteMediaConfirmation($id)
    {
        $this->media_delete_id = $id;
        $this->dispatchBrowserEvent('show-media-delete-confirmation');
        //    to re select the current form
        $this->mount($this->current_form_id);
    }

    public function mount($id)
    {

        // $url=url()->current();
        // $forminfo = explode('/', $url);
        $this->current_form_id=$id;

        // subscirbe info and settings
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);

        //end of subscribe info

        $this->current_form = Form::leftJoin('logos', 'logos.id', '=', 'forms.logo_id')
        ->where('forms.id','=',$this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();


        if ($this->current_form != null)
        {
            $this->current_form_id = $this->current_form->form_id;
            $this->form_config=FormMediaConfig::whereform_id( $this->current_form_id)->first();
            $this->current_media=FormMedia::whereform_id( $this->current_form_id)->orderBy('media_order')->get();
            $this->allowTouch = (bool) $this->form_config->allow_touch;
            $this->allowLoop = (bool) $this->form_config->allow_loop;
        }




        $this->current_form_kiosks=Kiosk::leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.form_id',$this->current_form_id)
        ->select('devices.*','device_codes.device_code as device_code')->get();










    }
    public function featchMedia(){
        $this->dispatchBrowserEvent('mediaFetched',['media'=>$this->current_media]);
        $this->mount($this->current_form_id);
    }
    // update value of allow touch for form
    public function updatedallowTouch(){
        $this->form_config=FormMediaConfig::whereform_id( $this->current_form_id)->first();
         $this->form_config->allow_touch= (bool)$this->allowTouch ;
        $this->form_config->save();
        $this->mount($this->current_form_id);
        $this->dispatchBrowserEvent('contentChanged');
    }
     // update value of allow loop for form
    public function updatedallowLoop(){
        $this->form_config=FormMediaConfig::whereform_id( $this->current_form_id)->first();
         $this->form_config->allow_loop= (bool)$this->allowLoop ;
        $this->form_config->save();
        $this->mount($this->current_form_id);
        $this->dispatchBrowserEvent('contentChanged');
    }
    // updateing form on all kiosks
    public function updateformonkiosks()
    {


        RefreshKiosks::dispatch($this->current_form_kiosks->toArray());
        $form=Form::whereid($this->current_form->id)->first();
        $form->updating=false;
        $form->save();
        $this->mount($this->current_form_id);

    }
     // set show or not of media
     public function setMediaShow($value,$id)
     {   $media=FormMedia::whereid($id)->first();

         $media->hide=!$value;
         $media->save();
         $this->mount($this->current_form_id);
         $this->dispatchBrowserEvent('contentChanged');


     }

    // sort media
    //   to update when user re order the questions list
    public function updateMediaOrder($allMedia)
    {

        foreach ($allMedia as $media) {
            $mediaItem = FormMedia::find($media['value']);
            $mediaItem->media_order = $media['order'];
            $mediaItem->update();
        }
      $this->mount($this->current_form_id);
      $this->dispatchBrowserEvent('contentChanged');


    }
    // delete Media
    public function deleteMedia(){
        $mediaItemDelete=FormMedia::whereid($this->media_delete_id)->first();
        File::delete(public_path($mediaItemDelete->path));

        $this->current_media=FormMedia::whereform_id($this->current_form_id)->orderBy('media_order')->get();

        foreach ($this->current_media as $media) {
            $mediaItem=FormMedia::whereid($media->id)->first();
            if ($mediaItem->media_order > $mediaItemDelete->media_order) {
                $mediaItem->media_order -= 1;
            }

            $mediaItem->save();
        }
        $mediaItemDelete->delete();
        $this->mount($this->current_form_id);

        $this->dispatchBrowserEvent('contentChanged');

    }

    public function render()
    {
        return view('livewire.forms.edit.edit-form-media');
    }
}
