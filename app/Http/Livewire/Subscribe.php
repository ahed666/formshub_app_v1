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
    public $priceresponses=350;
    public $numresponses=30000;
    public $cateresponses=3;
    public $totalprice;
    public $maxnumresponses=150000;
    public $validAddResponses;
    public $desc;
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
    public $subscriptionsUpgrade;
    public $subscriptionsDowngrade;

    public function mount($action=null,$id=null)
    {

        $this->action=$action;

        $this->subscriptionsDowngrade=json_decode($this->subscriptions_downgrade,true);
        $this->subscriptionsUpgrade=json_decode($this->subscriptions_upgrade,true);
        // $this->planFeatures=json_decode($this->plans_permission,true);

        $this->types=TypeSubscribe::all();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->responsesCategories=ResponseCategory::all();
        $defaultResponsesCat=ResponseCategory::whereid($this->cateresponses)->first();
         $this->priceresponses=$defaultResponsesCat->price;
         $this->numresponses=$defaultResponsesCat->num;
         $this->maxnumresponses=$this->current_subscribe->num_responses;
         $this->validAddResponses=false;
        foreach ($this->responsesCategories as $cat)
        if($this->current_subscribe->num_of_responses+$cat->num<=$this->maxnumresponses)
       { $this->validAddResponses=true;
        $this->priceresponses=$this->cateresponses?ResponseCategory::whereid($cat->id)->first()->price:0;
        $this->numresponses=$this->cateresponses?ResponseCategory::whereid($cat->id)->first()->num:0;
        $this->cateresponses=$cat->id;
       }

    }
    public function updatedcateresponses(){
        if($this->action!="buyresponses")
        $this->mount();
        $this->validate(
            [
            'cateresponses' =>['required'],
           ],[
            'cateresponses.required'=>'You should select number of responses ',
           ]
        );
        $this->priceresponses=$this->cateresponses?ResponseCategory::whereid($this->cateresponses)->first()->price:0;
        $this->numresponses=$this->cateresponses?ResponseCategory::whereid($this->cateresponses)->first()->num:0;
    }
    //    buy responses
    public function buyresponses(){






        //   validation responses
        $this->validate(
            [
            'cateresponses' =>['required'],
           ],[
            'cateresponses.required'=>'You should select number of responses ',
           ]
        );
        $this->validAddResponses=false;
        foreach ($this->responsesCategories as $cat)
        if($this->current_subscribe->num_of_responses+$cat->num<=$this->maxnumresponses)
        $this->validAddResponses=true;


       if($this->validAddResponses)
       {

        $this->totalprice=$this->priceresponses;

        $this->desc="Forms hub ".ResponseCategory::whereid($this->cateresponses)->first()->num."
         additional responses. valid (from: ".Carbon::now()->format('Y-m-d')." , to: ".
         Carbon::parse($this->current_subscribe->expired_at)->format('Y-m-d').")";

        // $this->showCheckout=true;
        $id=$this->createOrder();

        return redirect()->route('payment.create', ['id' => $id]);

      }


    }
    // downgrade plan
    public function downgrade($palnid)
    {
        $this->mount();

        $validAccount=Carbon::parse($this->current_subscribe->expired_at)->isPast()?false:true;
        $this->choosenPlan=$palnid;
        $this->choosenPlanInfo=TypeSubscribe::whereid($palnid)->first();

        if(!$validAccount)
        {
           $kiosks=Kiosk::whereaccount_id(Auth::user()->current_Account_id)->get();
           $forms=Form::whereaccount_id(Auth::user()->current_Account_id)->get();
        //    unvalid with num of kiosks
           if(count($kiosks)>$this->choosenPlanInfo->num_kiosks)
           {
            $error="you have overflow number of kiosks";
            $this->dispatchBrowserEvent('show-downgrade-warning',['error'=>$error]);
           }
             //    unvalid with num of forms
           elseif(count($forms)>$this->choosenPlanInfo->num_forms)
           {
            $error="you have overflow number of forms";
            $this->dispatchBrowserEvent('show-downgrade-warning',['error'=>$error]);
           }
           // valid and downgrade
           else{

            $this->showCheckout=true;
           }

        }
        else
        {
            $error="not expired";
            $this->dispatchBrowserEvent('show-downgrade-warning',['error'=>$error]);
        }


    }
    // when select paln
    public function ChoosePlan($plan){

        $this->mount();
        //   validation responses
        $this->validate([


            'cateresponses' =>['required'],


        ],[


            'cateresponses.required'=>'You should select number of responses ',


        ]
            );
        $this->choosenPlan=$plan;
        $this->choosenPlanInfo=TypeSubscribe::whereid($plan)->first();
        $this->totalprice=($this->choosenPlanInfo->price)+$this->priceresponses;
        // $this->totalprice=$this->totalprice+($this->totalprice*0.05);
        // $this->showCheckout=true;
        $this->action="new plan";

        $desc1="Forms hub premium one year subscription with ".$this->numresponses;
        if($this->choosenPlan==$this->current_subscribe->plan_id)
         $desc2= "valid (from ".Carbon\Carbon::parse($this->current_subscribe->expired_at)->format('d m Y')." to ".\Carbon\Carbon::parse($current_subscribe->expired_at)->format('d m Y')." )";

        else
        $desc2= "valid (from ".\Carbon\Carbon::now()->format('d m Y')." to ".\Carbon\Carbon::now()->addyear()->subDays(1)->format('d m Y')." )";



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
        $order->num_responses=$this->numresponses;
        $order->tax=5;
        $order->total=(float)(($this->totalprice+($this->totalprice*(5/100))));
        $order->action=$this->action;
        $order->cate_responses=$this->cateresponses;
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
