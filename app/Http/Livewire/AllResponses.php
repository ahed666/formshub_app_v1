<?php

namespace App\Http\Livewire;

use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use Livewire\Component;
use App\Models\Responses;
use App\Models\Kiosk;
use App\Models\ResponsedQuestions;
use App\Models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use Illuminate\Support\Facades\File;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\ToDo;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Pagination\Paginator;
class AllResponses extends Component
{
    public $totalresponses;
    public $status;
    public $responsesdevices;
    public $current_form_id;
    public $current_form;
    public $responsesdates;
    public $numofresponses;
    public $numofresponsesfordevices;
    public $devices;
    public $startdate;
    public $enddate;
    public $mindate;
    public $maxdate;
    public $exportLang;
    public $averagescore;
    public $formquestions;
    public $formquestionsNum;
    public $questions;
    public $formlanguages;
    public $filtersquestion=[];
    public $allresponses=[];
    public $form;
    public $path;
    public $allowexport;
    public $subscribe;
    public $main_languages;
    public $startDateOfResponse='2023-01-01';
    public $endDateOfResponse='2023-01-01';

    public $main_lang='{
        "en":{ "id": 1,"code":"en", "name": "English","trans":"en"},
        "ar":{ "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        "ur":{ "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        "tl":{ "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    }';

    public $true_todo='
    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
     <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <path d="M12.37 8.87988H17.62" stroke="#d65151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.38 8.87988L7.13 9.62988L9.38 7.37988" stroke="#d65151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.37 15.8799H17.62" stroke="#d65151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.38 15.8799L7.13 16.6299L9.38 14.3799" stroke="#d65151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#d65151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
    </svg>';
    public $false_todo='
    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                              <g id="SVGRepo_iconCarrier"> <path d="M12.37 8.87988H17.62" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/> <path d="M6.38 8.87988L7.13 9.62988L9.38 7.37988" stroke="#000000" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.37 15.8799H17.62" stroke="#000000" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.38 15.8799L7.13 16.6299L9.38 14.3799" stroke="#000000"
                                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                           </svg>';


    public $languages;
    public $count=0;

    protected $listeners=[

        "todoaddsuccess"=>"todoaddsuccess",
        "removeTodoConfirmed"=>"removeTodoConfirmed",
        "refreshdataallresponses"=>"refreshdataallresponses",
        "getexportdata"=>"getExportData",

    ];


    // when change language display
    public function updatedlanguage($value){

        $this->responsesdata();
        $this->dispatchBrowserEvent('refreshall');

    }
    public function refreshdataallresponses(){
        $this->allresponses = Responses::where('form_id', $this->current_form_id)
        ->orderBy('reviewed_at', 'desc')
        ->get();

        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->currentAccount->id);
        $this->allowexport=$this->subscribe->export;

        $this->dispatchBrowserEvent('refreshall');

    }

    public function todoaddsuccess()
    {



        $this->dispatchBrowserEvent('close_modal_add_todo');
        $this->responsesdata();
        $this->dispatchBrowserEvent('refreshdata');

           // $this->mount();

    }
    // function to remove todo
    public function removeTodoConfirmed($id){

          $res=Responses::whereid($id)->first();
          $res->todo=false;
          $res->save();
          ToDo::whereresponse_id($id)->delete();
          $this->allresponses = Responses::where('form_id', $this->current_form_id)
          ->orderBy('reviewed_at', 'desc')
          ->get();
          $this->responsesdata();

          $this->dispatchBrowserEvent('refreshdata',['id'=>$id]);
    }
    public function mount(){

        $url=url()->current();
        $forminfo = explode('/', $url);
        $this->current_form_id=$forminfo[5];

        $this->allresponses = Responses::where('form_id', $this->current_form_id)
        ->orderBy('reviewed_at', 'desc')
        ->get();

        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->main_languages=json_decode($this->main_lang, true);


       if(count($this->allresponses)==0){}
       else{
        $this->responsesdata();

        }

        $this->subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->currentAccount->id);
        $this->allowexport=$this->subscribe->export;



    }
     // get locales of form
     public function getLocalesOfForm($id)
     {
         $locales = FormTrnslations::
             where('form_id', '=', $id)->
             select('form_translations.form_local As local')->get();
         $locales = json_decode($locales, true);
         $formlocales = [];
         foreach ($locales as $i => $local) {foreach ($this->main_languages as $main) {
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

    // all reseponses with questions and answers
    public function responsesdata(){
          // languages
          $this->main_languages=json_decode($this->main_lang, true);
          $this->formlanguages = $this->getLocalesOfForm($this->current_form_id);

        // $this->allresponses=Responses::whereform_id($this->current_form_id)->orderBy('reviewed_at','desc')->withCount(['questions', 'customersInfo'] )->get();
        $this->formquestionsNum=count(Questions::where('questions.form_id','=',$this->current_form_id)
        ->select('questions.*')->orderBy('questions.question_order')->get());



    }
     public function getExportData($language)
    {    $this->exportLang=$language;
        $responses=Responses::whereform_id($this->current_form_id)->get();
        $score=Responses::whereform_id($this->current_form_id)->average('score');
        $allresponses=[];

        foreach ($responses as $key => $response)
        {
            $questions1=ResponsedQuestions::where('response_id','=',$response->id)

            ->join('question_translations','question_translations.question_id','=','responsed_questions.question_id')
            ->leftJoin('answer_translations',function($join)use($response){
                $join->on('answer_translations.answer_id','=','responsed_questions.answer_id')
                ->where('answer_translations.answer_local', '=',$this->exportLang);})
            ->join('questions','questions.id','=','responsed_questions.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$this->exportLang)
            ->select('responsed_questions.*','question_translations.question_details','type_of_questions.question_type','answer_translations.answer_details as answer')->get();

            $questions2=ResponsedCustomersInfo::where('response_id','=',$response->id)
            ->join('question_translations','question_translations.question_id','=','responsed_customers_info.question_id')
            ->join('questions','questions.id','=','responsed_customers_info.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$this->exportLang)
            ->select('responsed_customers_info.*','type_of_questions.question_type','question_translations.question_details')->get();
            $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
            $response->reviewed_at =date_create($response->reviewed_at);

            $response->reviewed_at =date_format($response->reviewed_at, 'Y-m-d H:I');


            $collect=collect(
                    ["id"=>$response->id,
                     "id_view"=>$response->id_view,
                     "todo"=>(bool)$response->todo,
                     "form_id"=>$response->form_id,
                     "score"=>$response->score,
                     "device_id"=>$response->device_id,
                     "lang"=>$response->response_language,
                     "reviewed_at"=>date($response->reviewed_at),
                     "questions"=>$questions,
                    ]
            );

            array_push($allresponses,$collect);
        }

        $this->questions=Questions::where('questions.form_id','=',$response->form_id)
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->exportLang)
                ->select('questions.*','type_of_questions.question_type','question_translations.question_details','question_translations.question_local')->orderBy('questions.question_order')->get()->toArray();

                $this->dispatchBrowserEvent('fetchingdata',['responses'=>$allresponses,'questions'=>$this->questions,'form'=>$this->current_form,'score'=>$score,'language'=>$this->exportLang,'languageName'=>$this->main_languages[$this->exportLang]['name']]);


    }
    public function render()
    {
        return view('livewire.all-responses');
    }
}

