<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use Config;
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale'))
        {
          Session::put('locale',Config::get('app.locale'));
       }
       if(Session::get('locale'))
       App::setLocale(Session::get('locale'));
       else
        { $locale = $request->cookie('locale');
    App::setLocale($locale);}
       return $next($request);
    }
}
