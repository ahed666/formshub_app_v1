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
use App\models\ResponsedCustomersInfo;
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
class AddTodo extends Component
{
    public $response_id;
    public $account;
    public $priority;
    public $userid;
    public $task;
    public $status;
    public $edit=false;
    public $allowaddtodo;
    public $errorAllow;
    public $allowAddToDoSubscribe;
    public $current_subscribe;
    public $validAccount;
    public $locked;
    public $todo;
    public $todoInfo;
    public $account_owner;
    public $accountStatus;
    public $accountRole;
    protected $listeners = [


        'add_todo'=>'add_todo',
        'edit_todo'=>'edit_todo'

];
    // validate on submit on add
    public function validation(){


        $this->validate([
            'priority' =>['required'],
            'task'=>['required'],
            'userid'=>[ 'required'],
            // 'response_id'=>['unique:todos'],

        ],[

            'priority.required'=>'This is required',
            'userid.required'=>'This is required',
            'task.required'=>'This is required',
            'response_id.unique'=>'This Response is added to todo',
        ]
        );
    }
    // validation edit
    public function validationEdit(){


        $this->validate([
            'priority' =>['required'],
            'task'=>['required'],
            'userid'=>[ 'required'],


        ],[

            'priority.required'=>'This is required',
            'userid.required'=>'This is required',
            'task.required'=>'This is required',
        ]
        );
    }

    //  to set response id when click on to do buttons
    public function add_todo($id=null){

        $this->response_id=$id;
        $this->account = Jetstream::newAccountModel()->findOrFail(Auth::user()->currentAccount->id);
        $this->account_owner=User::whereid($this->account->user_id)->first();
        $this->setAllow_AddToDo();
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->allowAddToDoSubscribe=$this->current_subscribe->todo;

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);






    }
    public function edit_todo($id){

        $this->account = Jetstream::newAccountModel()->findOrFail(Auth::user()->currentAccount->id);
        $this->account_owner=User::whereid($this->account->user_id)->first();

        $this->edit=true;
        $this->allowaddtodo=true;
        $this->todo= ToDo::whereid($id)->first();
        $this->response_id= $this->todo->response_id;
        $this->task=$this->todo->task;
        $this->priority=$this->todo->priority;
        $this->status=$this->todo->status;
        $this->userid=$this->todo->user_id;
        $this->setAllow_AddToDo();
        $this->todoInfo=ToDo::where('todos.id','=',$id)
        ->leftJoin('responses','responses.id','=','todos.response_id')
        ->leftJoin('forms','forms.id','=','responses.form_id')
        ->select('todos.*','forms.form_title')->first();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);



        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);



        $this->allowAddToDoSubscribe=$this->current_subscribe->todo;
    }
    // set if user allow to add todo
    public function setAllow_AddToDo(){
        $accountuser=AccountUser::whereaccount_id($this->account->id)->whereuser_id(Auth::user()->id)->first();

        if($accountuser)
        {
            $this->accountRole=$accountuser->role;
            if( $this->edit==true)
            $this->allowaddtodo=true;
            else
            $accountuser->role=="admin"?$this->allowaddtodo=true:$this->allowaddtodo=false;
        }
        if($this->account->user_id==Auth::user()->id)
        {
            $this->allowaddtodo=true;
        }

    }
    // reset values after save and cancel
    public function resetvalue(){
       $this->task=null;
        $this->priority=null;
       $this->userid=null;
       $this->todo=null;
       $this->edit=false;
       $this->response_id=null;

    }
    public function save(){

        // if edit
        if($this->edit){

            $this->validationEdit();
            // $todo= ToDo::whereresponse_id($this->response_id)->first();
            $this->todo->task=$this->task;
            $this->todo->status=$this->status;
            $this->todo->priority=$this->priority;
            $this->todo->user_id=$this->userid;
            $this->todo->response_id=$this->response_id;
            $this->todo->access_account_id=$this->account->id;
            $this->todo->updated_at=Carbon::now();
            $this->todo->save();

            $this->resetvalue();
            $this->emit('todoeditsuccess');

        }
        // if add=> save =>create new todo object
        else{

            $this->validation();
            $todo=new ToDo();
            $todo->task=$this->task;
            $todo->status="Open";
            $todo->priority=$this->priority;
            $todo->user_id=$this->userid;
            $todo->response_id=$this->response_id;
            $todo->access_account_id=$this->account->id;
            $todo->save();
            if($this->response_id)
            {
                $res=Responses::whereid($this->response_id)->first();
                $res->todo=true;
                $res->save();
            }
            $this->resetvalue();
            $this->emit('todoaddsuccess');
        }

    }

    public function render()
    {
        return view('livewire.add-todo');
    }
}
