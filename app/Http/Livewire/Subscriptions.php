<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TypeSubscribe;
use App\Models\SubscribePlan;
use App\Models\User;
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
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\Responses;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\ToDo;
use App\Models\canceledPlan;
use App\Models\ResponseCategory;
use App\Models\AccountUser;
use App\Models\SignFile;
use App\Models\PdfFile;
use App\Notifications\CancelSubscription;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
class Subscriptions extends Component
{
    public $types;
    public $show=false;
    public $current_subscribe;
    public $planFeatures;
    public $num_kiosks=0;
    public $num_forms=0;
    public $num_responses=0;
    public $progressbarValue;
    public $locked;
    public $subscriptions_upgrade='
    {
      "Free":["Basic","Premium","Proffessional","Ultimate"],
      "Basic":["Premium","Proffessional","Ultimate"],
      "Premium":["Proffessional","Ultimate"],
      "Professional":["Ultimate"],
      "Ultimate":[]
    }
    ';

    public $errors_permission='
    {
        "Free":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Basic":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Premium":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Professional":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Ultimate":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."}
    }
    ';
    protected $listeners=[
        "canceled"=>"cancelnow",

       ];
    public $subscriptionsUpgrade;
    // if user want upgrade
    public function upgrade_confirm()
    {
        $this->show=true;
        $this->mount();
    }
    // if user want renew
    public function renewCheck($planid){
        if($this->account->user_id==Auth::user()->id)
        {
            $this->mount();
            $currentDate = Carbon::now();
            // $validallowdate=Carbon::parse($this->current_subscribe->expired_at)->addMonths(1);
            // Carbon::now()->lessThan($validallowdate)&&

            $crace=Carbon::now()->lte(Carbon::parse($this->current_subscribe->expired_at)->addMonths($this->current_subscribe->grace_period)->endOfDay())&&Carbon::now()->greaterThan($this->current_subscribe->expired_at);
            // if allow renew (expired and inside the range between expired and locked)

            if($this->current_subscribe->valid==false||$crace)
            {

                return redirect()->route('subscribe', ['type'=>'renew','id' => $planid]);
            }
            // if no allow renew
            else
            {
                $this->dispatchBrowserEvent('show-renew-warning');

            }

        }
        elseif($accountuser=AccountUser::whereaccount_id($this->account->id)->whereuser_id(Auth::user()->id)->first())
        {
            if($accountuser->role!="admin")
            {
                $this->mount();
                $this->dispatchBrowserEvent('show-role-warning');

            }
            else
            {
                $this->mount();
                $currentDate = Carbon::now();
                // $validallowdate=Carbon::parse($this->current_subscribe->expired_at)->addMonths(1);
                // Carbon::now()->lessThan($validallowdate)&&

                $crace=Carbon::now()->lessThan(Carbon::parse($this->current_subscribe->expired_at)->addMonths($this->current_subscribe->grace_period))&&Carbon::now()->greaterThan($this->current_subscribe->expired_at);
                // if allow renew (expired and inside the range between expired and locked)
                if($this->current_subscribe->valid==false||$crace)
                {

                    return redirect()->route('subscribe', ['type'=>'renew','id' => $planid]);
                }
                // if no allow renew
                else
                {
                    $this->dispatchBrowserEvent('show-renew-warning');

                }
            }


        }

    }
    public function mount()
    {
        $this->types=TypeSubscribe::all();
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);



        $this->num_kiosks=count(Kiosk::whereaccount_id(Auth::user()->current_account_id)->get());
        $this->num_forms=count(Form::whereaccount_id(Auth::user()->current_account_id)->get());
        $this->num_responses=$this->current_subscribe->num_of_responses;

        $this->subscriptionsUpgrade=json_decode($this->subscriptions_upgrade,true);
        // $this->planFeatures=json_decode($this->plans_permission,true);
        $diffrence=Carbon::now()->diffInDays(Carbon::parse($this->current_subscribe->start_date));

        $this->progressbarValue=round((100*$diffrence)/365);
        $this->progressbarValue=$this->progressbarValue>100?100:$this->progressbarValue;

        $validallowdate=Carbon::parse($this->current_subscribe->expired_at)->addMonths($this->current_subscribe->grace_period);
        $this->locked=Carbon::now()->greaterThan($validallowdate);
        $this->account = Jetstream::newAccountModel()->findOrFail(Auth::user()->currentAccount->id);

    }

    public function cancel()
    {
        if($this->account->user_id==Auth::user()->id)
        {
            $this->mount();
            $this->dispatchBrowserEvent('show-cancel-warning');

        }
        elseif($accountuser=AccountUser::whereaccount_id($this->account->id)->whereuser_id(Auth::user()->id)->first())
        {
            if($accountuser->role=="admin")
            {
                $this->mount();
                $this->dispatchBrowserEvent('show-cancel-warning');

            }
            else
            {
                $this->mount();
                $this->dispatchBrowserEvent('show-role-warning');

            }

        }



    }
    public function cancelnow(){

        try {
        $user=User::whereid(Auth::user()->id)->first();
        $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
        $canceledplan=new canceledPlan();
        $canceledplan->account_id=Auth::user()->current_account_id;
        $canceledplan->plan_type_id=$plan->type_of_subscription_id;
        $canceledplan->plan_created_at=$plan->created_at;
        $canceledplan->plan_expiry_date=$plan->expired_at;
        $canceledplan->user_email=Auth::user()->email;
        $canceledplan->responses_cat_id=$plan->response_cat_id;
        $canceledplan->num_responses=$plan->num_of_responses;
        $canceledplan->save();
        // delete responses
            // Responses::join('forms','forms.id','responses.form_id')->where('forms.account_id','=',Auth::user()->current_account_id)->delete();
        // delete forms and its responses
        Form::deleteFormsFiles(Auth::user()->current_account_id);
        // whereaccount_id(Auth::user()->current_account_id)->delete();
        // delete pdf file for this account

        // delete todo
        ToDo::whereaccess_account_id(Auth::user()->current_account_id)->delete();

        // delete users
        AccountUser::whereaccount_id(Auth::user()->current_account_id)->delete();


        //delete kiosks
        Kiosk::deleteFiles(Auth::user()->current_account_id);

        //  delete files
        SignFile::deleteFiles(Auth::user()->current_account_id);

        //set free subscribe

        $plan->type_of_subscription_id=1;
        $plan->num_of_responses=500;
        $plan->start_date=Carbon::now();
        $plan->expired_at=Carbon::now()->addMonths(3)->subDays(1);
        $plan->save();
        try {
            $user->notify(new CancelSubscription());
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->mount();
    } catch (\Throwable $th) {
       dd($th);
    }

    }
    public function render()
    {
        return view('livewire.subscriptions');
    }
}
