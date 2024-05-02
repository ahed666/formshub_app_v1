<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ResponseCategory;
use App\Models\SubscribePlan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SubscribeOrder;
class SelectResponsesForm extends Component
{
    public $responsesCategories;
    public $current_subscribe;
   public $choosenCategory;
    public $maxnumresponses;
    public $validAddResponses;
    public $checkout=false;
    public $desc;
    public $totalprice;
    public $action;
    public function getListeners()
    {
            return [

                'nextStep'=>'nextStep',

            ];
    }

    public function mount(){
       $this->choosenCategory=new ResponseCategory();
        $this->responsesCategories=ResponseCategory::all();
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
       $this->action="buyresponses";


       $this->maxnumresponses=$this->current_subscribe->num_responses;

        foreach ($this->responsesCategories as $cat)
        if($this->current_subscribe->num_of_responses+$cat->num<=$this->maxnumresponses)
        {
            $this->validAddResponses=true;



        }
    }
    public function nextStep($id){

       $this->choosenCategory= ResponseCategory::whereid($id)->first();


       $this->validAddResponses=false;
        foreach ($this->responsesCategories as $cat)
        if($this->current_subscribe->num_of_responses+$cat->num<=$this->maxnumresponses)
        $this->validAddResponses=true;

        if($this->validAddResponses)
        {

         $this->totalprice=$this->choosenCategory->price;

         $this->desc="Forms hub ".ResponseCategory::whereid($this->choosenCategory->id)->first()->num." additional responses. valid (from: ". Carbon::now()->format('Y-m-d') ." , to: ".Carbon::parse($this->current_subscribe->expired_at)->format('Y-m-d').")";

         $id=$this->createOrder();

         return redirect()->route('payment.create', ['id' => $id]);



       }


    }
    //    create order
public function createOrder(){

    $order=new SubscribeOrder();
    $order->account_id= Auth::user()->current_account_id;
    $order->description= $this->desc;
    $order->price=$this->totalprice;
    $order->subscription_id=null;
    $order->num_responses=$this->choosenCategory->num;
    $order->tax=5;
    $order->total=(float)(($this->totalprice+($this->totalprice*(5/100))));
    $order->action=$this->action;
    $order->cate_responses=$this->choosenCategory->id;

    $order->save();

    return $order->id;
}
    public function selectCategory($id){
        $this->choosenCategory->id=$id;
    }
    public function render()
    {
        return view('livewire.select-responses-form');
    }
}
