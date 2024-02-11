<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Pagination\Paginator;
use \PDF;
use Dompdf\Dompdf;
class ShowResponse extends Component
{
    public $current_response=[];
    public $questions=[];
    public $allresponses=[];
    public $main_languages;
    public $langView;
    public $formlanguages=[];
    public $main_lang='{
        "en":{ "id": 1,"code":"en", "name": "English","trans":"en"},
        "ar":{ "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        "ur":{ "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        "tl":{ "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    }';

    protected $listeners = [


        'showResponse'=>'show',
        'print'=>'print',
        'changestatus'=>'changeStatusView',
        'changelanguage'=>'changelanguage',


    ];
    public function show($id){
        $this->current_response=Responses::whereid($id)
        ->first();
        $this->main_languages=json_decode($this->main_lang, true);

        $this->formlanguages=$this->getLocalesOfForm($this->current_response->form_id);

        $this->langView=$this->getLanguageView($this->formlanguages,app()->getLocale());
        // $this->changeStatusView($id);

        $this->initialResponses();

     $this->dispatchBrowserEvent('show',['langView'=>$this->langView,'response'=> $this->current_response,'formlanguages'=>$this->formlanguages,'languages'=>$this->main_languages,'all'=>$this->allresponses,'questions'=>$this->questions]);
    }
    // initial responses info
    public function initialResponses(){
        $responses=Responses::whereform_id( $this->current_response->form_id)->get();

        foreach ($responses as $key => $response)
        {

            $questions1=ResponsedQuestions::where('response_id','=',$response->id)

            ->join('question_translations','question_translations.question_id','=','responsed_questions.question_id')
            ->leftJoin('answer_translations',function($join)use($response){
                $join->on('answer_translations.answer_id','=','responsed_questions.answer_id')
                ->where('answer_translations.answer_local', '=',$this->langView);})
                ->join('questions','questions.id','=','responsed_questions.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$this->langView)
            ->select('responsed_questions.*','question_translations.question_details','type_of_questions.question_type','answer_translations.answer_details as answer')->get();

            $questions2=ResponsedCustomersInfo::where('response_id','=',$response->id)
            ->join('question_translations','question_translations.question_id','=','responsed_customers_info.question_id')
            ->join('questions','questions.id','=','responsed_customers_info.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$this->langView)
            ->select('responsed_customers_info.*','type_of_questions.question_type','question_translations.question_details')->get();
            $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
            $response->reviewed_at =date_create($response->reviewed_at);
            $response->reviewed_at =date_format($response->reviewed_at, 'Y-m-d H:i');

            $collect=collect(
                    ["id"=>$response->id,
                    "id_view"=>$response->id_view,
                    "todo"=>(bool)$response->todo,
                    "form_id"=>$response->form_id,
                    "score"=>$response->score,
                    "device_id"=>$response->device_id,
                    "lang"=>$response->response_language,
                    "viewed"=>$response->viewed,
                    "complet_percent"=>$response->complet_percent,
                    "reviewed_at"=>date(Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') ),
                    "questions"=>$questions,

                    ]
                );
            array_push($this->allresponses,$collect);
        }

        $this->questions=Questions::where('questions.form_id','=',$response->form_id)
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->langView)
                ->select('questions.*','type_of_questions.question_type','question_translations.question_details','question_translations.question_local')->orderBy('questions.question_order')->get();
    }
    // get language view
    public function getLanguageView($locales,$lang){
        foreach ($locales as $key => $local) {
           if($local['code']==$lang)
            return $local['code'];
        }
        return $locales[0]['code'];
    }
    public function changelanguage($lang){
        $this->langView=$lang;
        $this->initialResponses();
        $this->dispatchBrowserEvent('languagechanged',['langView'=>$this->langView,'response'=> $this->current_response,'formlanguages'=>$this->formlanguages,'languages'=>$this->main_languages,'all'=>$this->allresponses,'questions'=>$this->questions]);


    }
    // change status of view of response
    public function changeStatusView($id){

  $response=Responses::whereid($id)->first();
     if($response->viewed==false){
        $response->viewed=true;
        $response->save();
     }
     foreach ($this->allresponses as $key => $res) if($res['id']==$response->id){$this->allresponses[$key]['viewed']=$response->viewed;break;}

     $this->questions=Questions::where('questions.form_id','=',$response->form_id)
     ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
     ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$this->langView)
     ->select('questions.*','type_of_questions.question_type','question_translations.question_details','question_translations.question_local')->orderBy('questions.question_order')->get();
     $this->dispatchBrowserEvent('changedstatus',['langView'=>$this->langView,'response'=> $this->current_response,'formlanguages'=>$this->formlanguages,'languages'=>$this->main_languages,'all'=>$this->allresponses,'questions'=>$this->questions]);
       
 
    }
    public function closemodal(){
        $this->emit('refreshdataallresponses');
    }
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
    // public function print($id,$response,$html){

    //        $lang=$this->langView;
    //        $questions=$this->questions;

    //     $html = view('pdf.response',compact('lang','response','questions','html'))->render(); // Assuming you have a blade view file named 'page'
    //     dd($html);
    //     // Generate the PDF file name
    //     $filename ='response-'.$id;

    //     // Generate the PDF using Laravel-Dompdf
    //     $pdf = PDF::loadHTML($html);
    //     $pdf->setPaper('A4', 'portrait');

    //     // Download the PDF file
    //     return response()->streamDownload(function () use($pdf) {
    //                 echo $pdf->download('document.pdf');
    //             },$filename.'.pdf');
    // }
    public function render()
    {
        return view('livewire.show-response');
    }
}
