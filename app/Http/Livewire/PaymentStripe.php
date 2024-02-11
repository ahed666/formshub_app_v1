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
class PaymentStripe extends Component
{  public $order;
    public $order_id;
    public $current_subscribe;

    public function mount($order_id){
       $this->order_id;
       $this->order=SubscribeOrder::whereid($order_id)->first();
       $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

       $this->desc=$this->getOrderDescription($this->order);
    }

    public function getOrderDescription($order){
        $desc="";

       if($order->action=="buyresponses")
        $desc = '<h1 class="mt-2">' . __('main.buy_responses', ['num' => number_format($order->num_responses, 0, '.', ',')]) . '</h1>' .
        '<h1 class="mt-2">' . __('main.valid', ['start' => Carbon::now()->format('d m Y'), 'end' => Carbon::parse($this->current_subscribe->expired_at)->subDays(1)->format('d m Y')]) . '</h1>';
        else
        {
             $desc1='<h1 class="mt-2">'. __('main.newplan',['num'=>number_format($order->num_responses, 0, '.', ',')]) .'</h1>';

            if($order->subscription_id==$this->current_subscribe->plan_id)
            $desc2= '<h1 class="mt-2">'. __('main.valid',['start'=>\Carbon\Carbon::parse($this->current_subscribe->expired_at)->format('d m Y'),'end'=>\Carbon\Carbon::parse($this->current_subscribe->expired_at)->format('d m Y')]) .'</h1>';

            else
            $desc2= '<h1 class="mt-2">'. __('main.valid',['start'=>\Carbon\Carbon::now()->format('d m Y'),'end'=>\Carbon\Carbon::now()->addyear()->subDays(1)->format('d m Y')]).'</h1>';
         $desc=$desc1.$desc2;
        }



    return  $desc;
    }
    public function render()
    {
        return view('livewire.payment-stripe');
    }
}
