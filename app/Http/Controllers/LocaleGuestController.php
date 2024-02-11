<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;
class LocaleGuestController extends Controller
{
    public function setLocaleGuest($locale)
    {



            Cookie::queue('locale', $locale, 60*24*365);
            return redirect()->back();






    }
}
