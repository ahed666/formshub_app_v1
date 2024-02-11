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
use App\Models\Kiosk;
use App\Models\ResponsedQuestions;
use App\Models\ResponsedCustomersInfo;
use App\Models\Responses;
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
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use mikehaertl\wkhtmlto\Pdf;
use GuzzleHttp\Client;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
class ToDoList extends Component
{
    public $account;
    public $current_subscribe;
    public $validAccount;
    public $accountStatus;
    public $todos=[];
    public $responses_data=[];
    public $todo_delete_id;
    public $allowAddToDoSubscribe;
    protected $listeners=[

        "todoeditsuccess"=>"todoeditsuccess",
        "todoaddsuccess"=>"todoaddsuccess",
        // to confirm delete todo
    'deleteTodoConfirmed'=>'deletetodo',


    ];
    public function todoeditsuccess(){
        $this->dispatchBrowserEvent('close_modal_edit_todo');

    }
    public function todoaddsuccess(){
        $this->dispatchBrowserEvent('close_modal_edit_todo');

    }
    // // delete todo confirmation
    //  public function deletetodoConfirmation($id)
    //  { dd($id);
    //      $this->todo_delete_id=$id;
    //      $this->mount(e);
    //      $this->dispatchBrowserEvent('show-todo-delete-confirmation');

    //  }
      //  delete todo
    public function deletetodo($id)
    {
        $todo=ToDo::whereid($id)->first();
        if($todo->response_id)
        {
            $response=Responses::findOrFail($todo->response_id);
            $response->todo=false;
            $response->save();
        }
        $todo->delete();
        $this->mount();
        $this->dispatchBrowserEvent('after_delete_todo');


    }
    public function mount(){
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
        $this->allowAddToDoSubscribe=$this->current_subscribe->todo;

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);
     $this->account = Jetstream::newAccountModel()->findOrFail(Auth::user()->current_account_id);
     $this->todos=ToDO::getToDos($this->account->id);
     foreach ($this->todos as $key => $todo) {
         $this->todos[$key]->formmated_created_at=Carbon::parse($this->todos[$key]->created_at)->setTimezone(Auth::user()->timezone)->format('d/m/Y h:i');
     }

     $this->initial_responses_data();




    }
    public function initial_responses_data(){
        if($this->todos!=null){
             foreach($this->todos as $todo){
                $formquestions=Questions::where('questions.form_id','=',$todo->form_id)
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->join('question_translations','question_translations.question_id','=','questions.id')
                ->where('question_translations.question_local','=',$todo->response_language)
                ->select('questions.*','type_of_questions.question_type','question_translations.question_details','question_translations.question_local')->orderBy('questions.question_order')->get()->toArray();
                $questions1=ResponsedQuestions::where('response_id','=',$todo->response_id)

                ->join('question_translations','question_translations.question_id','=','responsed_questions.question_id')
                ->leftJoin('answer_translations',function($join)use($todo){
                 $join->on('answer_translations.answer_id','=','responsed_questions.answer_id')
                 ->where('answer_translations.answer_local', '=',$todo->response_language);})
                 ->join('questions','questions.id','=','responsed_questions.question_id')
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->where('question_translations.question_local','=',$todo->response_language)
                ->select('responsed_questions.*','question_translations.question_details','type_of_questions.question_type','answer_translations.answer_details as answer')->get();

                $questions2=ResponsedCustomersInfo::where('response_id','=',$todo->response_id)
                ->join('question_translations','question_translations.question_id','=','responsed_customers_info.question_id')
                ->join('questions','questions.id','=','responsed_customers_info.question_id')
                ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
                ->where('question_translations.question_local','=',$todo->response_language)
                ->select('responsed_customers_info.*','type_of_questions.question_type','question_translations.question_details')->get();
                $data = array_merge(json_decode($questions1, true), json_decode($questions2, true));

                $collect = collect(
                    [ "id" => $todo->response_id,
                      "FormQuestions" => $formquestions,
                        "data"=>$data,
                        "language",$todo->response_language,
                    ]
                );

                array_push($this->responses_data, $collect);
             }
        }
        $this->todos=$this->todos->toArray();
    }
    public function render()
    {
        return view('livewire.to-do-list');
    }
}
