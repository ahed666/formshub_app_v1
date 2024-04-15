<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\InvoiceNotification;

class SubscriptionController extends Controller
{


    private $stripe;
    public function __construct()
    {

        //$this->stripe = new StripeClient('sk_test_51MMzItDnxZnJCLLG9hBf1oYzQBx0EiN8pUx3xjeGa1xgZHpkaYIMTX8bi0EG8mDs0AR2D22oqR0hNF7NujkbJq7K00aRSBbwMR');
         $this->stripe =new StripeClient('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');
        //  env('STRIPE_SECRET');
    }

    public function index()
    {
        return view('accounts.subscriptions');
    }

    public function payment(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'cardNumber' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvv' => 'required'
        ]);

        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->errors()->first());

            return back();
        }

        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            $request->session()->flash('danger', $token['error']);
            // return response()->redirectTo('/');
            return back();
        }
        if (empty($token['id'])) {
            $request->session()->flash('danger', trans('main.paymentfail'));
            // return response()->redirectTo('/');
            return back();
        }

        if($request->input('action')=="buyresponses")$desc="Buy Responses";else $desc="Buy new Plan";

        $total=(int)(($request->input('price')+($request->input('price')*(5/100)))*100);
        try {

        $charge = $this->createCharge($token['id'],$total,$desc);

        if (!empty($charge)&&!$charge['error'] && $charge['status'] == 'succeeded')
        {
            $request->session()->flash('success', 'Payment completed.');
            // buy responses
            if($request->input('action')=="buyresponses")
            {
                $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
                $plan->num_of_responses=$plan->num_of_responses+ResponseCategory::whereid($request->input('cateresponses'))->first()->num;
                $plan->save();

                // add invoice
                $desc="Forms hub ".ResponseCategory::whereid($request->input('cateresponses'))->first()->num." additional responses. valid (from: ".Carbon::now()->format('Y-m-d')." , to: ".Carbon::parse($plan->expired_at)->format('Y-m-d').")";
                $message=$this->createInvoice($desc,$plan->type_of_subscription_id,$request->input('price'),$total,$request->input('action'));

            }
            // select plan
            else
            {
                //    add plan
                $plan=SubscribePlan::whereaccount_id(Auth::user()->current_account_id)->first();
                if(!$plan)
                {
                    $plan=new SubscribePlan();
                    $plan->account_id=Auth::user()->current_account_id;
                    $plan->type_of_subscription_id=$request->input('type');
                    $plan->num_of_responses=ResponseCategory::whereid($request->input('cateresponses'))->first()->num;
                    $plan->start_date=$plan->type_of_subscription_id==$request->input('type')?Carbon::parse( $plan->expired_at):Carbon::now();
                    $plan->expired_at=$plan->type_of_subscription_id==$request->input('type')?Carbon::parse( $plan->expired_at)->addyear()->subDay():Carbon::now()->addyear()->subDay();
                    $plan->valid=true;
                    $plan->active=true;
                    $plan->response_cat_id=$request->input('cateresponses');
                    $plan->save();
                }
                else
                {


                    $plan->start_date=$plan->type_of_subscription_id==$request->input('type')?Carbon::parse($plan->expired_at):Carbon::now();
                    $plan->expired_at=$plan->type_of_subscription_id==$request->input('type')?Carbon::parse($plan->expired_at)->addyear()->subDay():Carbon::now()->addyear()->subDay();

                    $plan->type_of_subscription_id=$request->input('type');

                    $plan->valid=true;
                    $plan->active=true;
                    $plan->response_cat_id=$request->input('cateresponses');
                    // $plan->num_of_responses=Carbon::parse( $plan->expired_at)->isPast()?$request->input('numofresponses'):$request->input('numofresponses')+$plan->num_of_responses;
                    $plan->num_of_responses=ResponseCategory::whereid($request->input('cateresponses'))->first()->num;

                    $plan->save();
                }
                // add invoice
                $desc="Forms hub premium one year subscription with".ResponseCategory::whereid($request->input('cateresponses'))->first()->num." Responses. Valid (from: ".Carbon::parse($plan->start_date)->format('Y-m-d')." , to: ".Carbon::parse($plan->expired_at)->format('Y-m-d').")";
                $message=$this->createInvoice($desc,$request->input('type'),$request->input('price'),$total,$request->input('action'));

            }

        }
        else
        {
            $request->session()->flash('danger', trans('main.paymentfail'));
            return back();
        }
        return redirect('/subscriptions')->with('message', $message);
           //code...
        } catch (\Throwable $th) {
            $request->session()->flash('danger', trans('main.paymentfail'));
            return back();
        }
    }

    // create invoice after chare succeffuly
    private function createInvoice($desc,$planid,$price,$total,$type){
        $invoice=new Invoice();
        $account=Account::whereid(Auth::user()->current_account_id)->first();
        $invoice->invoice_description=$desc;
        $invoice->plan_id=$planid;
        $invoice->price_ex_tax=$price;
        $invoice->tax=5;
        $invoice->price_in_tax=$total;
        $invoice->account_id=Auth::user()->current_account_id;
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
        if($type=="buyresponses")
        return  trans('main.paymentsuccess_buyresponses');
        else
       return trans('main.paymentsuccess_newplan');
    }

    //create tocken
    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    //create new charge
    private function createCharge($tokenId,$amount,$desc)
    {

        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount,
                'currency' => 'aed',
                'source' => $tokenId,
                'description' => $desc
            ]);
        } catch (Exception $e) {

            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }

}
