<?php

namespace App\Http\Livewire;

use Livewire\Component;
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

use Pawlox\VideoThumbnail\Facade\VideoThumbnail;
use FFMpeg\Coordinate\TimeCode;
class Kiosks extends Component
{

    public $kiosks;
    public $validcode=false;
    public $isavilable=false;
    public $deviceCode;
    public $showmessage=false;
    public $ifedit=false;
    public $device_delete_id;
    public $currentNameDevice;
    public $currentFormName=null;
    // public $currentInService;
    public $currentIdDevice;
    public $currentFormId;
    public $forms;
    public $test;

    public $edit=false;
    public $edited_kiosk_name;
    public $edited_form_id;
    public $idEditing;
     public $error;
     public $ifadd;
      // subscriptions settings
      public $validAccount;
      public $current_subscribe;
      public $accountStatus;

      public $valid;
      public $permissions;

      public $modal;
      public $errors_permission='
      {
          "Free":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
          "Basic":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
          "Premium":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
          "Professional":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
          "Ultimate":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."}
      }
      ';
      // end subscriptions
    protected $listeners=[
    //    to refresh after add device
    'deviceaddsuccess'=>'deviceaddsuccess',
    // to confirm delete question
    'deleteDeviceConfirmed'=>'deletedevice',
    "unlink"=>"unlinkForm",
    'refreshafterupdated'=>'sendrefresh',

    ];
    // validation rules
    protected $rules=[
        'edited_kiosk_name' => 'required|max:25',
    ];
    // error messages
    protected $messages=[
        'edited_kiosk_name.required' => 'This is required.',
        'edited_kiosk_name.max' => 'Device name must be less of or equal 25 characters ',
    ];


    // save kiosk after edit it info
    public function setEditInfo($id,$kiosk_name,$form_id){


       $this->idEditing=$id;
       $this->edit=true;
       $this->edited_kiosk_name=$kiosk_name;
       $this->edited_form_id=$form_id;
       $this->mount();

    }

    public function saveChanges(){
        $this->validateOnly('edited_kiosk_name');

        // try {
           $kiosk=Kiosk::findOrFail($this->idEditing);
           $kiosk->device_name=$this->edited_kiosk_name;
           $current_Kiosk;



           if($kiosk->form_id!=$this->edited_form_id)
            {
                // without form
                if($this->edited_form_id=="")
                {
                    $kiosk->form_id=null;
                    $kiosk->sign_kiosk=false;
                }
                // // sign pdf
                // elseif($this->edited_form_id=="sign")
                // {
                //     $kiosk->form_id=null;
                //     $kiosk->sign_kiosk=true;
                // }
                // form
                else
                {
                    $kiosk->sign_kiosk=false;
                    $kiosk->form_id=$this->edited_form_id;
                }
                $kiosk->save();

                //send refresh event to kiosk
                $this->sendrefresh($kiosk->id);
            }

            else
            {
                if($this->edited_form_id=="")
                {
                    $kiosk->form_id=null;
                    $kiosk->sign_kiosk=false;
                }

                else
                {
                    $kiosk->sign_kiosk=false;
                    $kiosk->form_id=$this->edited_form_id;
                }

                $kiosk->save();
            }

        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        $this->mount();
        $this->idEditing=null;
        $this->edit=false;
    }


    public function sendrefresh($id)
    {

        try {


        $kiosk=kiosk::where('devices.id','=',$id)
        ->leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->select('devices.*','device_codes.device_code as device_code')
        ->first();

        RefreshKiosk::dispatch($kiosk);
        // event(new DeviceRefresh($kiosk->url,$kiosk->id));
         $this->mount();
         $this->emit('refreshTriggered', $kiosk->device_code);
        } catch (\Throwable $th) {

            $this->mount();
        }
    }
    public function mount()
    {
        $this->kiosks=Kiosk::leftjoin('forms','forms.id','=','devices.form_id')
        ->leftJoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->leftJoin('devices_models','devices_models.id','=','device_codes.device_model_id')
        ->where('devices.account_id',Auth::user()->current_account_id)->select('devices.*','device_codes.device_code as device_code','devices_models.device_model','forms.form_title as form_title','forms.id as form_id')->get();



        // subscribe
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);


       $this->forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();
       //    $this->permissions= json_decode($this->plans_permission, true);
       $errors= json_decode($this->errors_permission, true);


       if(count($this->kiosks)<$this->current_subscribe->num_kiosks)
          $this->valid=true;
       else
       {
        $this->valid=false;
        $this->error=$errors[$this->current_subscribe->type]["num_kiosks"];
       }

    }
     //   delete kiosk confirmation
     public function delete($id)
     {   try
        {
            $this->device_delete_id=$id;
            $kiosk=Kiosk::whereid($this->device_delete_id)->first();

            if($kiosk->form_id!=null){
                $this->dispatchBrowserEvent('show-modal-haveform');
            }
            else{
                $this->dispatchBrowserEvent('show-device-delete-confirmation');
            }
            $this->mount();
        }
        catch (\Throwable $th)
        {
            $this->mount();
        }




     }
    //  delete device
    public function deletedevice()
    {
        try {
            $kiosk=Kiosk::whereid($this->device_delete_id)->first();
            $standbyMedia=StandbykiosksMedia::whereid($kiosk->standbymedia_id)->first();
            if (str_contains($standbyMedia->path_file, 'storage/images/upload/standby') || str_contains($standbyMedia->path_file, 'storage/videos/standby'))
            File::delete(public_path($standbyMedia->path_file));
            $standbyMedia->delete();
            $kiosk->delete();



        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->mount();
    }
    // unlink device
    public function unlinkForm(){
        $kiosk=Kiosk::whereid($this->device_delete_id)->first();
        $kiosk->form_id=null;$kiosk->save();
        RefreshKiosk::dispatch($kiosk);

    }
    // after add sucessfuly
    public function deviceaddsuccess()
    {
        $this->mount();
       $this->dispatchBrowserEvent('close_modal_add_device');

    }
    // if the process is edit
    public function edit($id)
    {    $this->resetvalues();
        $this->ifedit=true;

        $currentdevice=Kiosk::leftjoin('forms','forms.id','=','devices.form_id')
        ->where('devices.account_id',Auth::user()->current_account_id)->where('devices.id',$id)->select('devices.*','forms.form_title as form_title')->first();

        $this->currentIdDevice=$id;
        $this->currentNameDevice=$currentdevice->device_name;
        $this->currentFormName=$currentdevice->form_title;
        $this->currentFormId=$currentdevice->form_id;
        $this->forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();
        // $this->currentInService=$currentdevice->in_service;
        $this->mount();
    }

    //  public function updated($properatyName)
    //  {
    //     if($properatyName="currentFormId"){
    //         if($this->currentFormId=="")
    //     {
    //         $this->currentInService=false;
    //     }
    //     }
    //     $this->mount();
    //  }
     public function resetvalues()
     {
        $this->isavilable=false;
         $this->validcode=false;
         $this->ifadd=false;
         $this->ifedit=false;
         $this->showmessage=false;
         $this->currentIdDevice=null;
        $this->currentNameDevice=null;
        $this->currentFormName=null;
        $this->currentFormId=null;
        // $this->currentInService=false;
        $this->mount();


     }
    //  add device
    public function editdevice()
    {

         $this->validateOnly('currentNameDevice');
         $device=Kiosk::whereid($this->currentIdDevice)->first();
         $device->device_name=$this->currentNameDevice;

         if($this->currentFormId!="")
         { $device->form_id= $this->currentFormId;}
         else
         { $device->form_id= null;}


        //  $device->in_service=$this->currentInService;
         $device->save();

         $this->resetvalues();
         $this->mount();



    }
    public function render()
    {
        return view('livewire.kiosks');
    }
}
