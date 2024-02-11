<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;

class ViewForm extends Component
{


    public $current_id;
    public $question_delete_id;
    public $language_delete_id;
    public $terms_form_delete_id;
    public $current_form;
    public $languages;
    public $current_form_kiosks;
    //    to set the id of Form that want user delete it
    public $form_delete_id;
    // add Form details
    public $form_logo;
    public $logosrc;
    public $logo;
    public $form_BusinessName;
    public $form_Name;
    public $modal = false;
    // end add form details
    public $formlanguages;
    public $main_languages;
    //    edit question
    public $questionediting;
    public $current_questions;
    public $modalopen = false;

    public $local = "en";
    //    form options
    public $formexpiry = false;
    public $formexpirydate = null;
    public $service = false;
    public $score=false;
    public $terms=false;

    // end of form options
    //subscribe
    public $validAccount;
    public $current_subscribe;
    public $accountStatus;
    //end of subscribe
    //    messages of form
    public $current_message;
    public $messages_defult =
        '[
        {"local":"en","start_header":"Hi there, your opinion matters!",
            "start_text":"Please select the language to begin",
            "end_header":"Thank you for your time","end_text":"We are glad to hear from you, Have a great day!",
            "terms":"Insert your terms and conditions here."},
       {"local":"ar",
        "start_header":"مرحبا بك، رأيك يهمنا!",
        "start_text":"الرجاء إختيار اللغة للبدء",
        "end_header":"شكراً على وقتك","end_text":"يسعدنا دائما السماع منك, يوما سعيداً!",
        "terms":"َضع الشروط والأحكام الخاصة بك هنا."},
       {"local":"tl","start_header":"Kumusta, ang iyong opinyon ay mahalaga!",
        "start_text":"Mangyaring piliin ang wika upang magsimula",
        "end_header":"Salamat sa iyong oras","end_text":"Natutuwa kaming makarinig mula sa iyo, Magkaroon ng magandang araw!",
        "terms":"Ipasok ang iyong mga tuntunin at kundisyon dito."},
       {"local":"ur","start_header":"ہیلو، آپ کی رائے اہم ہے!",
        "start_text":"براہ کرم شروع کرنے کے لیے زبان منتخب کریں۔",
        "end_header":"اپ کے وقت کا شکریہ","end_text":"ہمیں آپ سے سن کر خوشی ہوئی، آپ کا دن اچھا گزرے!",
        "terms":"اپنی شرائط و ضوابط یہاں داخل کریں۔"}
       ]';
    public $messages;
    // end messages of form
    public $lang =
        '[
           { "id": 1,"code":"en", "name": "English"},
           { "id": 2,"code":"ar" ,"name": "Arabic"},
           { "id": 3, "code":"ur","name": "Urdu"}
    ]';
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $questions;


    protected $listeners = [
        // to update form every second
        'updatecurrentform' => 'update_currentform',
         //select form
         'selectform'=>'selectform',
        // to delete question
        'deleteQuestionConfirmed' => 'deletequestion',
        // to delete terms
        'deleteTermsConfirmed' => 'deleteterms',
        // to delete language
        'deleteLanguageConfirmed' => 'deletelang',
        //  to refresh after edit message
        'messageeditsuccess' => 'messageeditsuccess',
        //  to refresh after edit terms
        'termseditsuccess' => 'termseditsuccess',
        //    to refresh after edit form
        'formeditsuccess' => 'formeditsuccess',

        //  to refresh after edit question
        'questioneditsuccess' => 'questioneditsuccess',
        //  to refresh after add question
        'questionaddsuccess' => 'questionaddsuccess',
        'updateKiosks'=>'updateformonkiosks',

        'hidetranslationalert'=>'hideTranslationAlert'


    ];
    function updatedservice(){
        dd($this->current_id);
    }

     // get locales of form
     public function getLocalesOfForm($id)
     {
         $locales = formTrnslations::
             where('form_id', '=', $id)->
             select('form_translations.form_local As local')->get();
         $locales = json_decode($locales, true);
         $formlocales = [];
         foreach ($locales as $i => $local) {
            foreach ($this->main_languages as $main) {
             if ($local['local'] == $main['code']) {
                 $collect = collect(
                     ["id" => $main['id'],
                         "code" => $local['local'],
                         "name" => $main['name'],
                         "trans" => $main['trans'],

                     ]
                 );

                 array_push($formlocales, $collect);
             }
         }

         }

         return $formlocales;

     }
     //    to get all questions by id of form
     public function getquestions($id)
     {

         //  custom questions
         $questions1 = Questions::
             where('Questions.form_id', '=', $id)->
             join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
             groupBy('custom_questions.custom_question_id')->
             join('custom_question_translations', 'custom_questions.custom_question_id', '=', 'custom_question_translations.custom_question_id')->
             join('type_of_questions', 'type_of_questions.id', '=', 'Questions.type_of_question_id')->
             where('custom_question_translations.question_local', '=', $this->local)
             ->select('Questions.*', 'custom_question_translations.question_details As details', 'custom_question_translations.question_local As local', 'type_of_questions.question_type_details as type')
             ->orderby('Questions.question_order')->get();

         //   another type of question
         $questions2 = Questions::join('question_translations', 'Questions.id', '=', 'question_translations.question_id')->
             join('type_of_questions', 'type_of_questions.id', '=', 'Questions.type_of_question_id')->
             whereNotIn('Questions.type_of_question_id', [8, 9])->
             select('Questions.*', 'question_translations.question_details As details', 'question_translations.question_local As local', 'type_of_questions.question_type_details as type')->
             where('Questions.form_id', '=', $id)->where('question_translations.question_local', '=', $this->local)->orderby('Questions.question_order')->get();
         $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
         usort($questions, function ($a, $b) {
             return $a['question_order'] - $b['question_order'];
         });

         return $questions;

     }
     public function mount(){
        $this->current_subscribe=SubscribePlan::getCurrentSubscription($this->form->account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);


        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')->where('forms.account_id', Auth::user()->current_account_id)->orderBy('forms.created_at', 'desc')
        ->where('forms.id','=',$this->current_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->get()[0];



        $this->messages = json_decode($this->messages_defult, true);
        $this->main_languages = json_decode($this->main_lang, true);
        $this->current_form_kiosks=Kiosk::leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.form_id',$this->current_id)
        ->select('devices.*','device_codes.device_code as device_code')->get();
        $this->formlanguages = $this->getLocalesOfForm($this->current_id);
        if ($this->formlanguages != null) {
            $this->local = $this->formlanguages[0]['code'];
        }
        $this->current_message = FormTrnslations::whereform_id($this->current_id)->whereform_local($this->local)->first();

        $this->current_questions = $this->getquestions($this->current_id);
     }
    public function render()
    {

        return view('livewire.view-form');
    }
}
