<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\DeviceCode;
use App\Models\kiosk;
use App\Models\FormTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\TypeSubscribe;
use App\Models\SubscribePlan;
use App\Models\Account;
use Carbon\Carbon;
use App\Models\Responses;
use App\Models\ToDo;
use App\Models\Action;
use App\Models\ActionAccount;
use App\Models\User;
use App\Models\SupportTicket;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class Dashboard extends Component
{   public $forms;
    public $kiosks;
    public $numResponses;
    public $numForms;
    public $numkiosks;
    public $permissions;
    public $errors;
    public $subscribe;
    public $current_subscribe;
    public $accountStatus;
    public $locked;
    public $Todos;
    public $tickets;
    public $numResponsesToday;
    public $responsesDataChart;
    public $current_account_id;
    public $currentAccount;
    public $responsesPerForms;
    public $responsesPerKiosk;

    public $errors_permission='
    {
        "Free":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Basic":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Premium":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Professional":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Ultimate":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."}
    }
    ';

    public $actionsRoutesInfo;
    public function mount()
    {

        $this->current_account_id=Auth::user()->current_account_id==null?
        Account::whereuser_id(Auth::user()->id)->first()->id:Auth::user()->current_account_id;
        $this->currentAccount=User::join('accounts','users.id','=','accounts.user_id')->where('accounts.id','=',$this->current_account_id)->where('accounts.personal_account','=','1')->select('users.name as account_name')->first();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription($this->current_account_id);

        $this->current_subscribe->numResponsesUsed=Responses::getResponsesSubscription($this->current_subscribe->start_date,$this->current_account_id);
        // responses
        $currentDateTime = Carbon::now();
        $pastDateTime =$this->current_subscribe->start_date;
        $this->numResponses=Responses::allResponses($this->current_account_id);
        $this->responsesPerForm=Responses::getResponsesPerForm($this->current_account_id);
        $this->responsesPerKiosk=Responses::getResponsesPerKiosk($this->current_account_id);
        //   todo
        $this->Todos=ToDo::todosByStatus($this->current_account_id);
        $this->tickets=SupportTicket::ticketsByStatus($this->current_account_id);
        // forms
        $this->forms= Form::select('forms.*',\DB::raw('COUNT(devices.id) as devices_count'), \DB::raw('COUNT(responses.id) as responses_count'),\DB::raw('COUNT(form_media.id) as media_count'))
        ->leftJoin('responses', 'forms.id', '=', 'responses.form_id')
        ->leftJoin('form_media','form_media.form_id','=','forms.id')
        ->leftJoin('devices','devices.form_id','=','forms.id')
        ->where('forms.account_id', $this->current_account_id)
        ->groupBy('forms.id')
        ->get();

        // kiosks
        $this->kiosks=Kiosk::leftjoin('forms','forms.id','=','devices.form_id')
        ->leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.account_id',$this->current_account_id)->select('devices.*','device_codes.device_code as device_code','forms.form_title as form_title')->get();
        //  subscribe


        // $this->permissions= json_decode($this->plans_permission, true);
        $this->errors= json_decode($this->errors_permission, true);


        $actionModel = new Action();
        $this->actions = $actionModel->getAllActionsWithDismissalStatus($this->current_account_id);

        $this->numResponsesToday=Responses::getResponsesCreatedToday($this->current_account_id);
        $this->numForms=count($this->forms);
        $this->numKiosks=count($this->kiosks);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus($this->current_account_id);


        // charts
        $this->responsesDataChart=Responses::responsesPerDates($this->current_account_id) ;

    }
    public function hideAction($id){

        $action=ActionAccount::where('action_id', $id)->where('account_id',$this->current_account_id)->first();

        if($action)
        ActionAccount::where('action_id', $id)->where('account_id',$this->current_account_id)->update(['dismiss' => true]);
        else{
            $actionAccount = new ActionAccount();
            $actionAccount->account_id =$this->current_account_id; // Replace with the actual account ID
            $actionAccount->action_id = $id;  // Replace with the actual action ID
            $actionAccount->dismiss = true; // Replace with the actual dismiss value

            $actionAccount->save();
        }
        $this->mount();
    }
    public function showActions(){

        ActionAccount::where('account_id', $this->current_account_id)->update(['dismiss' => false]);
        $this->mount();

    }
    // to update serivce of kiosk
    public function changekioskservice($id){
        $kiosk=Kiosk::whereid($id)->first();
        if($kiosk->in_service==true)
         $kiosk->in_service=false;
        else
        $kiosk->in_service=true;

        $kiosk->save();
        $this->mount();
        $this->dispatchBrowserEvent('contentdashChanged');

    }
    //  to get the count question of each form by id of form
    public function questions_count($id)
    {
        $count1 = questions::where('form_id', '=', $id)->whereNotIn('type_of_question_id', [8, 9])->get();
        $count2 = DB::table('questions')
            ->join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')
            ->where('questions.form_id', '=', $id)
            ->groupBy('custom_questions.custom_question_id')
            ->select('questions.*')
            ->get();
        $count = count($count1) + count($count2);

        return $count;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
