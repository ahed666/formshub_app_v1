<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeOrder;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Carbon\Carbon;
use App\Models\TypeSubscribe;
use App\Models\SubscribePlan;
use App\Models\Invoice;
use App\Models\Account;
use App\Models\ResponseCategory;
use App\Models\User;
use App\Notifications\InvoiceNotification;
class PaymentController extends Controller
{


  public function create($order_id){



    return view('payment.create',['order_id'=>$order_id]);
  }

  public function createStripePaymentIntent($order_id){
    $order=SubscribeOrder::whereid($order_id)->first();

    $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

    $paymentIntent = $stripe->paymentIntents->create([
    'amount' => $order->total*100,
    'currency' => 'aed',
    'automatic_payment_methods' => ['enabled' => true],
    'description'=>'( AC-'.Auth::user()->current_account_id.' )-'.$order->description,

    ]);


    return [
        'clientSecret' => $paymentIntent->client_secret,


    ];
  }

  public function confirm(Request $request,$order_id){
    $order=SubscribeOrder::whereid($order_id)->first();

   $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
   $paymentIntent= $stripe->paymentIntents->retrieve($request->query('payment_intent'), []);
//    if payment proccess successed
//1 update subscription 2 create invoice
   if($paymentIntent->status=="succeeded")
    {

      $this->updateSubscription($order);
      $message=$this->createInvoice($order);
      return redirect('/subscriptions')->with('message', $message);
    }
    //else or if not successed
    else
    {
        $request->session()->flash('danger', $token['error']);
    }
  }

  private function updateSubscription($order){
    if($order->action=="buyresponses")
    {
        $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
        $plan->num_of_responses=$plan->num_of_responses+ResponseCategory::whereid($order->cate_responses)->first()->num;
        $plan->save();
    }
    else
    {
        $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
        if(!$plan)
        {
            $plan=new SubscribePlan();
            $plan->account_id=Auth::user()->current_account_id;
            $plan->type_of_subscription_id=$order->subscription_id;
            $plan->num_of_responses=ResponseCategory::whereid($order->cate_responses)->first()->num;
            $plan->start_date=$plan->type_of_subscription_id==$$order->subscription_id?Carbon::parse( $plan->expired_at):Carbon::now();
            $plan->expired_at=$plan->type_of_subscription_id==$order->subscription_id?Carbon::parse( $plan->expired_at)->addyear()->subDay():Carbon::now()->addyear()->subDay();
            $plan->valid=true;
            $plan->active=true;
            $plan->response_cat_id=$order->cate_responses;
            $plan->save();
        }
        else
        {


            $plan->start_date=$plan->type_of_subscription_id==$order->subscription_id?Carbon::parse($plan->expired_at):Carbon::now();
            $plan->expired_at=$plan->type_of_subscription_id==$order->subscription_id?Carbon::parse($plan->expired_at)->addyear()->subDay():Carbon::now()->addyear()->subDay();

            $plan->type_of_subscription_id=$order->subscription_id;

            $plan->valid=true;
            $plan->active=true;
            $plan->response_cat_id=$order->cate_responses;
            $plan->num_of_responses=ResponseCategory::whereid($order->cate_responses)->first()->num;

            $plan->save();
        }
    }
  }
  private function createInvoice($order){





    $invoice=new Invoice();
    $account=Account::whereid(Auth::user()->current_account_id)->first();
    $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
    $invoice->invoice_description=$order->description;
    $invoice->plan_id=$plan->type_of_subscription_id;
    $invoice->price_ex_tax=$order->price;
    $invoice->tax=5;
    $invoice->price_in_tax=$order->total;
    $invoice->account_id=$order->account_id;
    $invoice->business_name=$account->business_name;
    $invoice->account_name=User::whereid($account->user_id)->first()->name;
    $invoice->location=$account->country." - ".$account->city;
    $invoice->trn=$account->tax_number;
    $invoice->invoice_date=Carbon::now();
    $invoice->status="Paid";
    $invoice->save();

    $invoice->invoice_no=$invoice->id;
    $invoice->save();
    $user = User::find($account->user_id);
    // send notify as invoice to user
    try {
        if($user->email_sub_payment_subscriptions)
    {$user->notify(new InvoiceNotification($invoice->id));
    sleep(1);}
    } catch (\Throwable $th) {
        //throw $th;
    }

    if($order->action=="buyresponses")
   {
    return  trans('main.paymentsuccess_buyresponses');}
    else
   return trans('main.paymentsuccess_newplan');
}

}
