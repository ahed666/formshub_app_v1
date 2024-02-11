<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UnsubscribeController extends Controller
{


    public function create($type,$token,$userid){

     $token=$token.$userid;
    return view('unsubscribe',compact('type','token','userid'));


    }
    public function store($type,$token,$userid){

    
        try {
            $user=User::whereid($userid)->first();

            if($type=="payment_subscriptions")
            $user->email_sub_payment_subscriptions=false;
            elseif($type=="notifications")
            $user->email_sub_notification=false;
            elseif($type=="security")
            $user->email_sub_security=false;
            elseif($type=="offers_events")
            $user->email_sub_offers_events=false;

            $user->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'failed');
        }
        return redirect()->back()->with('success', 'success');



    }
}
