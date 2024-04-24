<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\TypeSubscribe;
use App\Models\SubscribePlan;
use Carbon\Carbon;
use App\Models\Kiosk;
use App\Models\Form;
use App\Models\ResponseCategory;
use App\Models\Account;
use App\Models\SubscribeOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\AccountUser;
class Subscribe extends Component
{
    public $types;
    public $showCheckout=false;
    public $current_subscribe;
    public $choosenPlan;
    public $choosenPlanInfo;
    public $renew=false;
    public $action;
    public $responsesCategories;


    public $maxnumresponses;

    public $totalprice;

    public $validAddResponses;
    public $desc;

    public $step;

    public $subscriptions_upgrade='
    {
      "Free":["Basic","Premium","Professional","Ultimate"],
      "Basic":["Premium","Professional","Ultimate"],
      "Premium":["Professional","Ultimate"],
      "Professional":["Ultimate"],
      "Ultimate":[]
    }
    ';
    public $subscriptions_downgrade='
    {
      "Free":[],
      "Basic":[],
      "Premium":["Basic"],
      "Professional":["Basic","Premium"],
      "Ultimate":["Basic","Premium","Professional"]
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

    public function getListeners()
    {
            return [

                'nextStep'=>'nextStep',

            ];
    }
    public $subscriptionsUpgrade;
    public $subscriptionsDowngrade;

    public function mount()
    {

        $this->action="new plan";
        $this->step=1;


        $this->types=TypeSubscribe::all();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->responsesCategories=ResponseCategory::all();






    }
    public function refreshData(){
        $this->types=TypeSubscribe::all();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->responsesCategories=ResponseCategory::all();
    }




    // when select paln
    public function ChoosePlan($plan){

        $this->mount();

        $this->choosenPlan=$plan;
        $this->choosenPlanInfo=TypeSubscribe::whereid($plan)->first();
        $this->totalprice=$this->choosenPlanInfo->price;

            $desc1="Forms hub premium one-year subscription with ".env('NUM_OF_RESPONSES_PREMIUM', 10000)." free responses.";
            if($this->choosenPlan==$this->current_subscribe->plan_id)
            $desc2= " valid (from ".\Carbon\Carbon::parse($this->current_subscribe->expired_at)->format('Y-m-d')." to ".\Carbon\Carbon::parse($this->current_subscribe->expired_at)->addyear()->subDays(1)->format('Y-m-d').")";

            else
            $desc2= " valid (from ".\Carbon\Carbon::now()->format('Y-m-d')." to ".\Carbon\Carbon::now()->addyear()->subDays(1)->format('Y-m-d').")";



            $this->desc=$desc1.$desc2;

            $id=$this->createOrder();

            return redirect()->route('payment.create', ['id' => $id]);

    }




    //    create order
    public function createOrder(){

            $order=new SubscribeOrder();
            $order->account_id= Auth::user()->current_account_id;
            $order->description= $this->desc;
            $order->price=$this->totalprice;
            $order->subscription_id=$this->choosenPlan;
            $order->num_responses=env('NUM_OF_RESPONSES_PREMIUM', 10000);
            $order->tax=5;
            $order->total=(float)(($this->totalprice+($this->totalprice*(5/100))));
            $order->action=$this->action;
            $order->cate_responses=null;
            $order->save();

            return $order->id;
    }
   public function Back(){

     if($this->action!="buyresponses")
        $this->mount();

    $this->showCheckout=false;
   }

    public function render()
    {
        return view('livewire.subscribe');
    }
}
