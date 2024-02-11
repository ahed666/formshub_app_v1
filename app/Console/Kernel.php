<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Form;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\AccountUser;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PlanExpired;
use App\Notifications\FreePlanExpired;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function ()
        {
            $subscriptions=SubscribePlan::all();
            foreach($subscriptions as $subscribe)
            {

                if(Carbon::now()->isSameDay($subscribe->expired_at)){
                $user_id=Account::whereid($subscribe->account_id)->first()->user_id;

                if($user_id){
                $user = User::find($user_id);
                if($user->email_sub_payment_subscriptions){
                 $subscribe->type_of_subscription_id==1?$user->notify(new FreePlanExpired($user)):$user->notify(new PlanExpired($user));

                sleep(1);
                }
              }}
            }
        })->everyMinute();
        // ->dailyAt('16:50')->timezone('Asia/Dubai');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
