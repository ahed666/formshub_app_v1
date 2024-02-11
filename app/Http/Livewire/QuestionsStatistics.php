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
use App\Models\ToDO;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use mikehaertl\wkhtmlto\Pdf;
use GuzzleHttp\Client;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
class QuestionsStatistics extends Component
{
    public $formquestions;
    public $count=0;
    public $form_id;
    public $form;
    public $language;
     protected  $allresponses;
     public $questions;
     protected $responsesdates;
     protected $typeofdate;
     public $currentQuestion;
     public $questionIndex=0;
     public $startDateOfResponse;
     public $endDateOfResponse;
     public $questionsData=[];
     public $responses;
     public $main_lang='{
        "en":{ "id": 1,"code":"en", "name": "English","trans":"en"},
        "ar":{ "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        "ur":{ "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        "tl":{ "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    }';
    public $languages;
    public $formlanguages;
    public $main_languages;
    protected $listeners=[


        'getQuestionData'=>'getQuestionData',
        'createpdf'=>'createpdf',
        'getAllQuestions'=>'allQuestions',
        "refreshdataallquestions"=>"refreshdata",

    ];
    public function refreshdata(){
        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages=$this->getLocalesOfForm($this->form_id);

        $this->language=$this->getLanguageView($this->formlanguages,app()->getLocale());
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();

        if(count($this->responses)>0){
         foreach ($this->responses as $key => $response) {
             $this->responsesdates[$key]=$response->date;
         }

         $this->startDateOfResponse=min($this->responsesdates);
         $this->endDateOfResponse=max($this->responsesdates);
        //  $this->initResponses($startDateOfResponse,$endDateOfResponse);

           $this->getQuestionData( $this->form);
          $this->currentQuestion=$this->formquestions[$this->questionIndex];
       }
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->allowexport=$this->current_subscribe->export;
    }

    public function mount(){
        $url=url()->current();
        $forminfo = explode('/', $url);
        $this->form_id=$forminfo[5];
        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages=$this->getLocalesOfForm($this->form_id);

        $this->language=$this->getLanguageView($this->formlanguages,app()->getLocale());
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();

        if(count($this->responses)>0){
         foreach ($this->responses as $key => $response) {
             $this->responsesdates[$key]=$response->date;
         }

         $this->startDateOfResponse=min($this->responsesdates);
         $this->endDateOfResponse=max($this->responsesdates);
        //  $this->initResponses($startDateOfResponse,$endDateOfResponse);

           $this->questionIndex=0;
          $this->currentQuestion=$this->formquestions[$this->questionIndex];
       }
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->allowexport=$this->current_subscribe->export;


    }
    // get language view
    public function getLanguageView($locales,$lang){
        foreach ($locales as $key => $local) {
           if($local['code']==$lang)
            return $local['code'];
        }
        return $locales[0]['code'];
    }
    // when change language display
    public function updatedlanguage($value){

        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();

        if(count($this->responses)>0){
         foreach ($this->responses as $key => $response) {
             $this->responsesdates[$key]=$response->date;
         }

         $startDateOfResponse=min($this->responsesdates);
         $endDateOfResponse=max($this->responsesdates);
        }
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->initialQuestion($this->formquestions[$this->questionIndex],$this->startDateOfResponse,$this->endDateOfResponse);

    }
    public function getQuestionData($id){

        $this->form_id=$id;

        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        
        if(count($this->formquestions)>0)
        $this->initialQuestion($this->formquestions[$this->questionIndex],$this->startDateOfResponse,$this->endDateOfResponse);


    }
    public function allQuestions(){

        $this->initResponses($this->startDateOfResponse,$this->endDateOfResponse);
        $this->dispatchBrowserEvent('export',['questions'=>$this->questions,'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
        $data= collect($this->questionsData)->keyBy('question_id')->pluck('question_data', 'question_id')->toArray();
        $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);



    }


     //initializations responses
    public function initResponses($start,$end){
         // languages
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages = $this->getLocalesOfForm($this->form_id);


        $this->questions=[];
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)
        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        foreach ($this->formquestions as $key => $question) {

                 $collect=$this->getDataOfQuestion($question,$this->language,$start,$end);

                    array_push($this->questions,$collect);

        }
        //    initial responses
           $this->allresponses=[];
           $responses=Responses::whereform_id($this->form_id)
            ->orderBy('id')
           ->get();

            foreach ($responses as $key => $response)
            {

                $questions1=ResponsedQuestions::where('response_id','=',$response->id)

                ->join('question_translations','question_translations.question_id','=','responsed_questions.question_id')
                ->leftJoin('answer_translations',function($join)use($response){
                $join->on('answer_translations.answer_id','=','responsed_questions.answer_id')
                ->where('answer_translations.answer_local', '=',$this->language);})
                ->join('questions','questions.id','=','responsed_questions.question_id')
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->where('question_translations.question_local','=',$this->language)
                ->select('responsed_questions.*','question_translations.question_details','type_of_questions.question_type','answer_translations.answer_details as answer')->get();

                $questions2=ResponsedCustomersInfo::where('response_id','=',$response->id)
                ->join('question_translations','question_translations.question_id','=','responsed_customers_info.question_id')
                ->join('questions','questions.id','=','responsed_customers_info.question_id')
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->where('question_translations.question_local','=',$this->language)
                ->select('responsed_customers_info.*','type_of_questions.question_type','question_translations.question_details')->get();
                $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));

                // $response->reviewed_at =date_format($response->reviewed_at, 'Y-m-d');
                // $response->reviewed_at=Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('d/m/Y h:i');

                $collect=collect(
                    ["id"=>$response->id,
                    "id_view"=>$response->id_view,
                    "todo"=>(bool)$response->todo,
                    "form_id"=>$response->form_id,
                    "score"=>$response->score,
                    "device_id"=>$response->device_id,
                    "lang"=>$this->language,
                    "reviewed_at"=>Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i'),
                    "questions"=>$questions,

                    ]
                );
                // if($response->id==1492)
                // dd($collect);
                array_push($this->allresponses,$collect);
            }



        //    count($this->allDates)<31?$this->typeofdate="day":(count($this->allDates)>31&&count($this->allDates)<366?$this->typeofdate="month":$this->typeofdate="year");
    }
    //  get data of question
    public function getDataOfQuestion($question,$lang,$start,$end){
        $currentTimezone=Auth::user()->timezone;

        // if question type is text

        $end = strtotime($end.' +1 day');
        $end = date('Y-m-d',$end);
        if($question->question_type=="short_text_question"||$question->question_type=="long_text_question"||$question->question_type=="date_question"
        ||$question->question_type=="email"||$question->question_type=="number"||$question->question_type=="drawing")
        {
            $responses=Responses::whereform_id($this->form_id)
            ->whereBetween('reviewed_at', [DATE($start),DATE($end)])
            ->orderBy('reviewed_at','desc')
            ->get();
            $data=[];

            foreach ($responses as $key => $response) {
               $answer=ResponsedCustomersInfo::whereresponse_id($response->id)->wherequestion_id($question->id)->first();

               $answer_collect=collect([
                "response_id"=>$response->id,
                "id_view"=>$response->id_view,
                "answer_details"=>$answer!=null?$answer->answer:null,
                "type_skip"=>$answer!=null?$answer->type_skip:null,
                "date"=>Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i'),

                ]);
                array_push($data,$answer_collect);
            }

            $collect=collect([
                "id"=>$question->id,
                "question_details"=>$question->question_details,
                "type"=>$question->question_type,
                "type_text"=>$question->question_type_details,
                "created_at"=>$question->created_at,
                "data"=>$data,
            ]);

        }
        else
        {
            $answers=Answers::wherequestion_id($question->id)->join('answer_translations','answer_translations.answer_id','=','answers.id')
            ->where('answer_translations.answer_local','=',$lang)->select('answers.*','answer_translations.answer_details')->get();

            $data=Responses::where('responses.form_id','=',$this->form_id)
                ->whereBetween('responses.reviewed_at', [DATE($start),DATE($end)])
                ->leftJoin('responsed_questions','responsed_questions.response_id','=','responses.id')
                ->where('responsed_questions.question_id','=',$question->id)
                ->select('responses.id as responses_id','responses.id_view as id_view','responses.*','responsed_questions.*')->get();

            //     foreach ($data as $key => $value) {
            //     $data[$key]->reviewed_at = Carbon::parse($data[$key]->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i:s');
            // }

            $collect=collect([
            "id"=>$question->id,
            "question_details"=>$question->question_details,
            "type"=>$question->question_type,
            "type_text"=>$question->question_type_details,
            "created_at"=>$question->created_at,
            "answers"=>$answers,
            // "labels"=>$labels,
            "data"=>$data,
            ]);
        }
        return $collect;
    }
     // return array of dates between tow dates
     public function getBetweenDates($startDate, $endDate) {
        $rangArray = [];

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }

        return $rangArray;
    }
    // to convert array of dates to months names
    public function getMonths($dates,$lang){
        $months=[];
        foreach ($dates as $key => $date) {

            $day=Carbon::parse($date);
            $month=$day->locale($lang)->shortMonthName;
            $year=$day->year;
            $label=strval($year).'_'.$month;
            in_array($label,$months)==false?array_push($months,$label):"";
        }
        return $months;

    }
    // to convert array of dates to years names
    public function getYears($dates){
        $years=[];
        foreach ($dates as $key => $date) {
            $day=Carbon::parse($date);
            $year=$day->year;
            in_array($year,$years)==false?array_push($years,$year):"";
        }
        return $years;

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

    // inital Question
    public function initialQuestion($question,$s_date,$e_date){




        if($question->question_type=="short_text_question"||$question->question_type=="long_text_question"||$question->question_type=="date_question"
        ||$question->question_type=="email"||$question->question_type=="number"||$question->question_type=="drawing")
        {

            $responses=Responses::where('responses.form_id',$this->form_id)
            // ->whereBetween('responses.reviewed_at', [DATE($s_date),DATE($e_date)])
             ->whereDate('responses.reviewed_at','<=',DATE($e_date))
            ->whereDate('responses.reviewed_at','>=', DATE($s_date))
            ->orderBy('responses.reviewed_at','desc')
            ->get();
         
            $data=[];
            $answers=[];

            foreach ($responses as $key => $response) {

               $answer=ResponsedCustomersInfo::whereresponse_id($response->id)->wherequestion_id($question->id)->first();

               $answer_collect=collect([
                "response_id"=>$response->id,
                "id_view"=>$response->id_view,
                "answer_details"=>$answer!=null?$answer->answer:null,
                "type_skip"=>$answer!=null?$answer->type_skip:null,
                "date"=>Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i'),

                ]);
                array_push($data,$answer_collect);
            }
            $collect=collect([
                "id"=>$question->id,
                "question_details"=>$question->question_details,
                "question_type"=>$question->question_type,
                "type_text"=>$question->question_type_details,
                "created_at"=>$question->created_at,
                "data"=>$data,
            ]);
        
            $newQuestionDataPair = ['question_id' =>$question->id, 'question_data' => $collect];
            $this->questionsData[]=$newQuestionDataPair;
            $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$collect,'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=>$s_date,'end'=>$e_date]);


        }
        else
        {
            $answers=Answers::wherequestion_id($question->id)->join('answer_translations','answer_translations.answer_id','=','answers.id')
            ->where('answer_translations.answer_local','=',$this->language)->select('answers.*','answer_translations.answer_details')->get();
             
             if(DATE($s_date)==DATE($e_date))
             {   $data= Responses::where('responses.form_id','=',$this->form_id)
                ->leftJoin('responsed_questions','responsed_questions.response_id','=','responses.id')
                ->where('responsed_questions.question_id','=',$question->id)
                ->select('responses.id as responses_id','responses.id_view as id_view','responses.*','responsed_questions.*')->get();
                 
             }
            else
            {   
               
                $data= Responses::where('responses.form_id','=',$this->form_id)
                 ->whereDate('responses.reviewed_at','<=',DATE($e_date))
            ->whereDate('responses.reviewed_at','>=', DATE($s_date))
                ->leftJoin('responsed_questions','responsed_questions.response_id','=','responses.id')
                ->where('responsed_questions.question_id','=',$question->id)
                ->select('responses.id as responses_id','responses.id_view as id_view','responses.*','responsed_questions.*')->get();
                
            }

            //     foreach ($data as $key => $value) {
            //     $data[$key]->reviewed_at = Carbon::parse($data[$key]->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i:s');
            // }
         
            $collect=collect([
            "id"=>$question->id,
            "question_details"=>$question->question_details,
            "type"=>$question->question_type,
            "type_text"=>$question->question_type_details,
            "created_at"=>$question->created_at,
            "answers"=>$answers,
            "data"=>$data,
            ]);

            // collect($this->questionsData)->keyBy('question_id')->pluck('question_data', 'question_id')->toArray();
            $newQuestionDataPair = ['question_id' =>$question->id, 'question_data' => $collect];

                 
            $this->questionsData[]=$newQuestionDataPair;
            $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$collect,'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=>$s_date,'end'=>$e_date]);

        }
    }

    // next question
    public function nextQuestion(){
        $data= collect($this->questionsData)->keyBy('question_id')->pluck('question_data', 'question_id')->toArray();

        // reach to maximum index (last item or question)
        if($this->questionIndex+1==count($this->formquestions)){

            $this->currentQuestion=$this->formquestions[$this->questionIndex];

            $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
            return;
        }
         // check if question data in array(loaded previous)
         $questionId = $this->formquestions[$this->questionIndex+1]->id;

         if(isset($data[$questionId])){

             $this->questionIndex+=1;
             $this->currentQuestion=$this->formquestions[$this->questionIndex];

             $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
             return;
         }
        else{
        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages=$this->getLocalesOfForm($this->form_id);

        $this->language=$this->getLanguageView($this->formlanguages,app()->getLocale());
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        foreach ($this->responses as $key => $response) {$this->responsesdates[$key]=$response->date;}
        // $this->responsesdates= collect($this->responses)->keyBy('id')->pluck('date')->toArray();

        $this->startDateOfResponse=min($this->responsesdates);
        $this->endDateOfResponse=max($this->responsesdates);
       //  $this->initResponses($startDateOfResponse,$endDateOfResponse);


          $this->questionIndex+=1;
         $this->currentQuestion=$this->formquestions[$this->questionIndex];
        $this->initialQuestion($this->currentQuestion,$this->startDateOfResponse,$this->endDateOfResponse);
        }
    }
    // current question
    public function currentQuestion($idx){
        $data= collect($this->questionsData)->keyBy('question_id')->pluck('question_data', 'question_id')->toArray();


         // check if question data in array(loaded previous)
         $questionId = $this->formquestions[$idx]->id;

         if(isset($data[$questionId])){

             $this->questionIndex=$idx;
             $this->currentQuestion=$this->formquestions[$this->questionIndex];

             $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
             return;
         }
        else{
        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages=$this->getLocalesOfForm($this->form_id);

        $this->language=$this->getLanguageView($this->formlanguages,app()->getLocale());
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        foreach ($this->responses as $key => $response) {$this->responsesdates[$key]=$response->date;}
        // $this->responsesdates= collect($this->responses)->keyBy('id')->pluck('date')->toArray();

        $this->startDateOfResponse=min($this->responsesdates);
        $this->endDateOfResponse=max($this->responsesdates);
       //  $this->initResponses($startDateOfResponse,$endDateOfResponse);


       $this->questionIndex=$idx;
         $this->currentQuestion=$this->formquestions[$this->questionIndex];
        $this->initialQuestion($this->currentQuestion,$this->startDateOfResponse,$this->endDateOfResponse);
    }}
     // back question
     public function backQuestion(){
                // reach to minimum index (last item or question)
                $data= collect($this->questionsData)->keyBy('question_id')->pluck('question_data', 'question_id')->toArray();

        if($this->questionIndex==0){

            $this->currentQuestion=$this->formquestions[$this->questionIndex];

            $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
            return;
        }

        // check if question data in array(loaded previous)

        $questionId = $this->formquestions[$this->questionIndex-1]->id;

        if(isset($data[$questionId])){

            $this->questionIndex-=1;
            $this->currentQuestion=$this->formquestions[$this->questionIndex];

            $this->dispatchBrowserEvent('SetQuestionsData',['questionsData'=>$data[$this->formquestions[$this->questionIndex]->id],'form'=>$this->form,'language'=>$this->language,'responses'=>$this->responses,'languages'=>$this->main_languages,'start'=> $this->startDateOfResponse,'end'=>$this->endDateOfResponse]);
            return;
        }
        else{

        $this->responses=Responses::whereform_id($this->form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();
        $this->main_languages=json_decode($this->main_lang, true);
        $this->formlanguages=$this->getLocalesOfForm($this->form_id);

        $this->language=$this->getLanguageView($this->formlanguages,app()->getLocale());
        $this->form=Form::whereid($this->form_id)->first()->toArray();
        $this->formquestions=Questions::where('questions.form_id','=',$this->form_id)

        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->language)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','type_of_questions.question_type_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        foreach ($this->responses as $key => $response) {
            $this->responsesdates[$key]=$response->date;
        }

        $this->startDateOfResponse=min($this->responsesdates);
        $this->endDateOfResponse=max($this->responsesdates);

       //  $this->initResponses($startDateOfResponse,$endDateOfResponse);


          $this->questionIndex-=1;
         $this->currentQuestion=$this->formquestions[$this->questionIndex];
        $this->initialQuestion($this->currentQuestion,$this->startDateOfResponse,$this->endDateOfResponse);
        }
     }
    public function render()
    {
        return view('livewire.questions-statistics',['formquestions'=>$this->formquestions]);
    }
}
