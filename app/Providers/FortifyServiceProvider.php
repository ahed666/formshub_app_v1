<?php

namespace App\Providers;
use App\Http\Controllers\AdminController;
// use Laravel\Fortify\Actions\AttemptToAuthenticate;
// use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use App\Actions\Fortify\AttemptToAuthenticate; // add new line
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable; // add new line
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when([AdminController::class,AttemptToAuthenticate::class,RedirectIfTwoFactorAuthenticatable::class])
        ->needs(StatefulGuard::class)
        ->give(function (){
            return Auth::guard('admin');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $key = 'login.'.$request->ip();
            $max = 5;   // attempts
            $decay = 180;    //seconds

            if (RateLimiter::tooManyAttempts($key, $max))
            {
                $seconds = RateLimiter::availableIn($key);

                return redirect()->back()
                    ->with('error',$seconds);
            }
            else {
                RateLimiter::hit($key, $decay);
            }
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        RateLimiter::for('verify-email', function (Request $request) {
            $key = 'verify-email.'.$request->ip();
            $max = 5;   // attempts
            $decay = 180;    //seconds

            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);
                return redirect()->back()
                ->with('error',$seconds);
            } else {
                RateLimiter::hit($key, $decay);
            }
        });
    }
}
