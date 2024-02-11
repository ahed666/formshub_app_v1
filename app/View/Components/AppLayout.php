<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        try{
           $accountActive=Auth::user()->current_account_id==null?Account::whereuser_id(Auth::user()->id)->first()->active:Account::whereid(Auth::user()->current_account_id)->first()->active;

        }
        catch(\Throwable $th){
           $accountActive=true; 
        }
        return view('layouts.app',compact('accountActive'));
    }
}
