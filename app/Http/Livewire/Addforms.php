<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\QuestionType;
use App\Models\Pictures;
use App\Models\Form;
use App\Models\FormMediaConfig;
use App\Models\FormTrnslations;
use App\Models\Logos;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;

use App\Models\Account;
use App\Models\FormType;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
class Addforms extends Component
{
    use WithFileUploads;
    // add form details
    public $form_logo;
    public $form_logo_temp;
    public $logosrc;
    public $logo;
    // public $form_BusinessName=null;
    public $form_title=null;
    public $form_DefultLanguages=[];
    public $modal=false;
    public $isadd=false;
    public $languages;
    public $messages;
    public $isdisable=true;
    public $form_id=null;
    public $validadd=false;
    public $custom=true;
    public $validAccount;
    public $subscribe;
    public $accountStatus;

    public $isSubmitting = false;

    public $step=1;
    public $form_type_id=1;
    public $form_types;






    protected $listeners = [

        'edit_form'=>'edit_form',
        'add_form'=>'add_form'

];
    // end add form details
    public function mount()
    {
        $this->form_logo="images/default_form_logo.png";
        $this->form_logo_temp="images/default_form_logo.png";
        $this->logo="images/default_form_logo.png";
        $this->modal=false;

      $this->CheckValidSubscribe();

    }

    public function CheckValidSubscribe(){
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);


        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);

        $forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();

        if($this->current_subscribe->custom_form==false)
            $this->custom=false;
        if(count($forms)<$this->current_subscribe->num_forms)
            $this->valid=true;
        else
        {
            $this->valid=false;
            $this->error=trans('main.num_forms_'.$this->current_subscribe->type);
        }
    }
    // to reset value after save
    public function resetvalue()
    {

        if(str_contains($this->form_logo_temp,'images/temp/'))
        {
                //  dd(public_path(str_replace('/', '\\', $this->form_logo) ));

            File::delete(public_path($this->form_logo_temp));
        }
        $this->form_logo="images/logo_1_transparent_dark.png";
        $this->form_logo_temp="images/logo_1_transparent_dark.png";
        $this->logo="images/logo_1_transparent_dark.png";
        $this->modal=false;
        $this->logosrc=null;
        // $this->form_BusinessName=null;
        $this->form_title=null;
        $this->form_id=null;
        $this->isadd=false;
        $this->form_type_id=1;
        $this->form_DefultLanguages=[];

    }
    // to edit form
    public function edit_form($name,$bname,$logo,$id)
    {
        $this->form_title=$name;
        // $this->form_BusinessName=$bname;
        $this->form_logo=$logo;
        $this->form_logo_temp=$logo;
        $this->logo=$logo;
        $this->form_id=$id;
        $this->CheckValidSubscribe();

    }
    // to add form
    public function add_form($languages,$messages)
    {
        $this->CheckValidSubscribe();

       $this->languages=$languages;
       $this->messages=$messages;

       $this->isadd=true;
       $this->form_types=FormType::whereenable(true)->get();

    }


    // public function selecttype($type){
    //  $this->form_type_id=$type;
    // }

    // realtime validate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[

            'form_title'=>['required','min:5'],


        ],
        [

            'form_title.min'=>'The :attribute must contain at least 5 characters ',
            'form_title.required'=>'The :attribute is empty ',

        ]
       );


    }
    // validate on submit on add
    public function validatedataonadd(){
        if($this->form_type_id==1)

        {$this->validate([

            'form_title'=>['required','min:5'],
            'form_type_id'=>['required'],
            'form_DefultLanguages'=>[ 'required']

        ],[

            'form_title.min'=>'the :attribute must contain at least 5 characters ',
            'form_title.required'=>'form title cannot be empty ',
            'form_type_id.required'=>'you should select type of form ',
            'form_DefultLanguages.required'=>'form defult language is required  ',
        ]
        );}
        else{$this->validate([

            'form_title'=>['required','min:5'],
            'form_type_id'=>['required'],


        ],[

            'form_title.min'=>'the :attribute must contain at least 5 characters ',
            'form_title.required'=>'form title cannot be empty ',
            'form_type_id.required'=>'you should select type of form ',

        ]
        );}

    }
    // validate on submit on edit
    public function validatedataonedit(){


        $this->validate([
            // 'form_BusinessName' =>['required','min:5'],
            'form_title'=>['required','min:5'],


        ],[

            'form_title.min'=>'The :attribute must contain at least 5 characters ',
            'form_title.required'=>'The :attribute is empty ',

        ]
        );
    }
    public function addform(){
        if ($this->isSubmitting) {
            return;
        }
        $this->isSubmitting = true;
        $folderPath ='storage/images/upload/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // if there is form =>Edit form
        if($this->form_id!=null)

        {
            $this->validatedataonedit();
            $this->resetErrorBag();
            $form=Form::findOrFail($this->form_id);

            $logo=Logos::findOrFail($form->logo_id);
              if($logo==null)
              {
                $logo=new Logos();
              }
              else{
                File::delete(public_path($logo->logo_url));
              }

            if(str_contains($this->form_logo_temp,'storage/images/temp/'))
            {
                $numofform=count(Form::whereaccount_id(Auth::user()->current_account_id)->get());
                $image_name="form-logo-".Auth::user()->id.Carbon::now()->format('YmdHis');
                $name=$image_name . '.jpg';
                $file = $folderPath .$name;

                $old=public_path($this->form_logo_temp);
                $new=$file;
                File::move($old , $new);
            }
                else
                $new=$this->form_logo;

            $logo->logo_url=$new;

            $logo->form_id=$this->form_id;
            $logo->logo_name="logo-".$this->form_title;
            $logo->save();
            $form->form_title=$this->form_title;
            // $form->business_name=$this->form_BusinessName;
            $form->user_id=Auth::user()->id;
            $form->account_id=Auth::user()->current_account_id;
            $form->logo_id=$logo->id;

            $form->save();

            $this->resetvalue();
            $this->isSubmitting = false;
            return redirect()->route('editform', ['id' => $form->id])->with('success_message','your form has been edit successfuly');

        }
        // if there is not form =>add form
        else
        {
            $forms=Form::whereaccount_id(Auth::user()->current_account_id)->get();
            // if reached max num of forms
            $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

            if(count($forms)>=$this->current_subscribe->num_forms){
                $this->isSubmitting = false;
               return redirect()->route('forms')->with('error_message','You have reached the maximum limit allowed.');
            }

            else
            {
                $numofform=count(Form::whereaccount_id(Auth::user()->current_account_id)->get());
                if($this->form_title==null)
                {$this->form_title="FormHub_form".$numofform;
                    while (Form::where('form_title', $this->form_title)->exists()) {
                        $uniqueCode = Str::random(10); // Generate a new code if it already exists
                        $this->form_title="FormPoint_form".$numofform.$uniqueCode;
                    }
                }

                $this->validatedataonadd();
                $this->resetErrorBag();
                $logo=new Logos();

                if(str_contains($this->form_logo_temp,'storage/images/temp/'))
                {

                    $image_name="form-logo-".Auth::user()->id.Carbon::now()->format('YmdHis');
                    $name=$image_name . '.jpg';
                    $file = $folderPath .$name;

                    $old=public_path($this->form_logo_temp);
                    $new=$file;
                    File::move($old , $new);
                }
                else
                    $new=$this->form_logo;





                $form=new Form();
                $form->form_title=$this->form_title;
                // $form->business_name=$this->form_BusinessName;
                $form->user_id=Auth::user()->id;
                $form->account_id=Auth::user()->current_account_id;

                $form->form_type_id=$this->form_type_id;
                $form->save();

                $logo->logo_url=$new;
                $logo->form_id=$form->id;
                $logo->logo_name="logo-".$this->form_title;
                $logo->save();

                $form=Form::whereid($form->id)->first();
                $form_title = preg_replace('/\s+/', '',$this->form_title);
                $form->url=url("/forms/{$form->account_id}/{$form->id}");

                $form->logo_id=$logo->id;
                $form->save();
                // add defult messages

                //if type is question and answer
                if($form->form_type_id==1){
                    foreach ($this->form_DefultLanguages as $key => $form_DefultLanguage)
                    {
                        foreach($this->messages as $message)
                        {
                            if($message['local']==$form_DefultLanguage)
                            {
                                $form_trans=new FormTrnslations();
                                $form_trans->form_start_header=$message['start_header'];
                                $form_trans->form_start_text=$message['start_text'];
                                $form_trans->form_end_header=$message['end_header'];
                                $form_trans->form_end_text=$message['end_text'];
                                $form_trans->terms=$message['terms'];
                                $form_trans->form_id=$form->id;
                                $form_trans->form_local=$form_DefultLanguage;
                                $form_trans->save();

                            }
                        }
                    }
                }
                // if another type
                else
                {
                   $formConfig=new  FormMediaConfig();
                   $formConfig->form_id=$form->id;
                   $formConfig->allow_touch=true;
                   $formConfig->allow_loop=true;

                   $formConfig->save();
                }
                $this->resetvalue();

                $this->isSubmitting = false;
                return redirect()->route('editform', ['id' => $form->id])->with('success_message','your Form has been add successfuly');

            }

        }



    }
    public function updatedlogo()
    {
        $this->modal=true;
        $this->logosrc=$this->logo->temporaryUrl();

        $this->dispatchBrowserEvent('form-image-updated', ['image' => $this->logo]);

    }
    // save image after crop it
    public function cropingimage(){
        $this->dispatchBrowserEvent('saving');



    }
    // to close the crop modal if user click close button or icon
    public function closemodal(){
        $this->form_logo="images/logo_1_transparent_dark.png";
        $this->form_logo_temp="images/logo_1_transparent_dark.png";
        $this->modal=false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave(){

        $this->modal=false;
    }
    // save image after crop it
    public function SavImage($image){
        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $name=uniqid() . '.jpg';
        $file = $folderPath .$name;
        $this->modal=false;
        // dd($this->answers[$this->stepimage]['image']);
        // if(str_contains($this->form_logo, '/storage/images/temp/')||str_contains($this->form_logo, '/storage/images/upload/'))
        //   {
        //     File::delete(public_path($this->form_logo));}
        $this->form_logo_temp="/storage/images/temp/".$name;
        file_put_contents($file, $image_base64);

    }
    public function render()
    {
        return view('livewire.addforms');
    }
}
