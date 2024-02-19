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
use App\Models\StandbykiosksMedia;

use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;

class AddDevice extends Component
{

    public $validcode=false;
    public $isavilable=false;
    public $deviceCode;
    public $showmessage=false;
    public $kiosks;
    public $currentNameDevice;
    // public $currentInService=true;
    public $currentIdDevice;
    public $currentFormId="";
    public $forms;
    public $message_text=null;
    public $locked;
    public $isSubmitting;
    // public $formNullMessage="";
    // validation rules
    protected $rules=[
        'deviceCode' => 'required|min:7|max:7',
        'currentNameDevice'=>'required|max:25',
    ];
    // error messages
    protected $messages=[
        'deviceCode.required' => 'the device code cannot be empty.',
        'deviceCode.min' => 'length of code must be 7 digits',
        'deviceCode.max' => 'length of code must be 7 digits',
        'currentNameDevice.required' => 'the device name cannot be empty.',
        'currentNameDevice.max' => 'device name must be less of or equal 25 characters ',
    ];
      // subscriptions settings
      public $validAccount;
      public $current_subscribe;
      public $accountStatus;
      public $valid;
      public $defultImage="images/default_images/default_standbyimage.gif";


      // end subscriptions
    public function mount()
    {
        $this->forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();
        $this->kiosks=Kiosk::leftjoin('forms','forms.id','=','devices.form_id')
        ->leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.account_id',Auth::user()->current_account_id)->select('devices.*','device_codes.device_code as device_code','forms.form_title as form_title')->get();
        // subscribe
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);




        $forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();



        if(count($this->kiosks)<$this->current_subscribe->num_kiosks)
            $this->valid=true;
        else
        {
            $this->valid=false;
            $this->error=trans('main.num_kiosks_'.$this->current_subscribe->type);
        }
    }


     // validation device code
     //  in device code table or not
        // in device code table=> check if link to user or not
            // if link =>the device is in use alredy
            //if not=>check if ready or bot
                    // if ready=>device is avilable and ready to add
                    // if not ready => this device has been addedd to an account before to add agian please reset the device from the device settings
        // not in device code => this device is not avilable
    public function checkdevicecode(){

         $this->resetErrorBag();
         $this->resetdevicecode();
         $this->validateOnly('deviceCode');
         $this->validcode=true;

         $device_code=DeviceCode::wheredevice_code($this->deviceCode)->first();

         //in device code or not
         if($device_code!=null)//in device code
         {
            //check if link to user or not
             $kiosk=Kiosk::wheredevice_code_id($device_code->id)->first();
             if($kiosk==null)//if not link
             {    //check if ready or not
                   if($device_code->ready_connect==true)//if ready
                   {
                        $this->message_text=trans('main.devicereadyconnect_message');
                        $this->isavilable=true;
                   }
                   else // if not ready
                   {
                    $this->message_text=trans('main.devicenotready');
                    $this->isavilable=false;

                   }
             }
            else // if link
            {
                $this->message_text=trans('main.deviceinuse');
                $this->isavilable=false;
            }

         }
         else // not in device code
         {
            $this->message_text=trans('main.devicenotavilable');
            $this->isavilable=false;
         }

         $this->showmessage=true;

    }

    //   reset device code
    public function resetdevicecode()
    {
        $this->isavilable=false;
        $this->validcode=false;
    $this->showmessage=false;
    $this->message_text=null;
    }
     // reset value
     public function resetvalues()
     {
        $this->message_text=null;
        $this->isavilable=false;
        $this->validcode=false;
        $this->showmessage=false;
        $this->currentNameDevice=null;
        $this->deviceCode=null;
        // $this->currentInService=true;
        $this->currentIdDevice=null;
        $this->currentFormId=null;
        $this->mount();

     }
     //  add device
    public function adddevice()
    {
    // check if there is another form submitted now
    if ($this->isSubmitting) {
        return;
    }
    // validation all feilds
    $this->validateOnly('currentNameDevice');
    // set form submitted now
    $this->isSubmitting = true;

    // check num of kiosks
    $kiosks=Kiosk::whereaccount_id(Auth::user()->current_account_id)->get();
    // if reached max num of forms
    $this->current_subscribe=SubscribePlan::join("type_of_subscriptions","type_of_subscriptions.id","=","subscriptions_plans.type_of_subscription_id")
    ->where("subscriptions_plans.account_id",Auth::user()->current_account_id)->select('subscriptions_plans.*','type_of_subscriptions.num_responses',
    'type_of_subscriptions.num_questions','type_of_subscriptions.num_kiosks','type_of_subscriptions.num_forms','type_of_subscriptions.todo',
    'type_of_subscriptions.export','type_of_subscriptions.custom_form','type_of_subscriptions.account_members',
    'type_of_subscriptions.professional_dashboard_statistics','type_of_subscriptions.pro_questions','type_of_subscriptions.form_terms'
    ,'type_of_subscriptions.id as plan_id','type_of_subscriptions.subscription_type as type')
    ->first();

    // if reached to max =>return false
    if(count($kiosks)>=$this->current_subscribe->num_kiosks){
        $this->isSubmitting = false;
        return redirect()->route('kiosks')->with('error_message','You have reached the maximum limit allowed.');
    }

    // else =>add kiosk
    else{
    $this->currentIdDevice=DeviceCode::wheredevice_code($this->deviceCode)->first()->id;
    $device=new Kiosk();
    $device->device_name=$this->currentNameDevice;
    // $device->in_service=(bool)$this->currentInService;
    $device->device_code_id=$this->currentIdDevice;
    $device->account_id=Auth::user()->current_account_id;
    $device->user_id=Auth::user()->id;
    $device->form_id= $this->currentFormId==""?null:$this->currentFormId;
    $device->url=url("/devices/{$this->deviceCode}/{$this->currentIdDevice}");


    $device->save();

    $standbyMedia=new StandbykiosksMedia();
    $standbyMedia->path_file=$this->defultImage;
    $standbyMedia->type="image";

    $standbyMedia->save();
    $device->standbymedia_id=$standbyMedia->id;
    $device->save();
    $this->resetvalues();
    $this->isSubmitting = false;
    $this->emit('deviceaddsuccess');
    }


    }
    public function render()
    {
        return view('livewire.add-device');
    }
}
