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
use App\Models\Fact;
use App\Models\Account;
use App\Models\FormType;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Str;


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
    public $current_subscribe;
    public $valid;
    public $error;






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
            'form_type_id'=>['required','in:1'],


        ],
        [

            'form_title.min'=>'The :attribute must contain at least 5 characters ',
            'form_title.required'=>'The :attribute is empty ',
            'form_type_id.in' => 'This type not avilable now', // Custom error message for form_type_id validation

        ]
       );


    }
    // validate on submit on add
    public function validatedataonadd(){
        if($this->form_type_id==1)

        {$this->validate([

            'form_title'=>['required','min:5'],
            'form_type_id'=>['required','in:1'],
            'form_DefultLanguages'=>[ 'required']

        ],[

            'form_title.min'=>'the :attribute must contain at least 5 characters ',
            'form_title.required'=>'form title cannot be empty ',
            'form_type_id.required'=>'you should select type of form ',
            'form_DefultLanguages.required'=>'form defult language is required  ',
            'form_type_id.in' => 'This type not avilable now', // Custom error message for form_type_id validation

        ]
        );}
        else{$this->validate([

            'form_title'=>['required','min:5'],
            'form_type_id'=>['required','in:1'],


        ],[

            'form_title.min'=>'the :attribute must contain at least 5 characters ',
            'form_title.required'=>'form title cannot be empty ',
            'form_type_id.required'=>'you should select type of form ',
            'form_type_id.in' => 'This type not avilable now', // Custom error message for form_type_id validation

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



        // if there is form =>Edit form
        if($this->form_id!=null)

        {

            $this->validatedataonedit();
            $this->resetErrorBag();

            $form=Form::editForm($this->form_id,$this->form_title,$this->form_logo_temp,);

            try {

                return redirect()->route('editform', ['id' => $form->id])->with('success_message','your form has been edit successfuly');

            } catch (\Throwable $th) {
                return redirect()->route('editform', ['id' => $form->id])->with('error_message_editform','cannot edit form');

            }




        }
        // if there is not form =>add form
        else
        {
            try {
                $this->validatedataonadd();
                $this->resetErrorBag();
                $form=  Form::addForm($this->form_title,$this->form_type_id,$this->form_logo_temp,$this->form_DefultLanguages,$this->messages);


                // to increase count of responses +1  in facts
                Fact::increseFactCount('createdforms');
                $this->resetvalue();

                $this->isSubmitting = false;
                return redirect()->route('editform', ['id' => $form->id])->with('success_message','your form has been add successfuly');
            } catch (\Throwable $th) {
                return redirect()->route('forms')->with('error_message','your job has been falid');
            }


        }




    }

    // save image after crop it
    public function cropingimage(){
        $this->dispatchBrowserEvent('saving');



    }

    // save image after crop it
    public function saveimage($image){

        $this->form_logo_temp=$image;


    }
    public function render()
    {
        return view('livewire.addforms');
    }
}
