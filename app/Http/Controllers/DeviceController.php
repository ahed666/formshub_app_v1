<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kiosk;
use App\Jobs\RefreshKiosks;
use Illuminate\Support\Facades\Auth;
class DeviceController extends Controller
{


    public function unlink(){
        try {

        $kiosks=Kiosk::whereaccount_id(Auth::user()->current_account_id)->get();

        foreach ($kiosks as $key => $kiosk) {
             $kiosk->form_id=null;$kiosk->save();
        }
        RefreshKiosks::dispatch($kiosks->toArray());
        return redirect()->route('profile.edit')->with('message','success');


    } catch (\Throwable $th) {
        return redirect()->route('profile.edit')->with('message','error');


    }
    }
}
