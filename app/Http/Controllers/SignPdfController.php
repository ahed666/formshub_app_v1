<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribePlan;
use Illuminate\Support\Facades\Auth;
class SignPdfController extends Controller
{

      // signatures statistics
      public function signPdfIndex ()
      {


              return view('sign_pdf_index');

      }
      public function addSignPdf ()
      {
        $accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);
        $current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
              if($current_subscribe->signpdf==false||$accountStatus['status']=='Locked')
               return redirect()->route('signpdf.index');
              else
              return view('add_sign_pdf');

      }
}
