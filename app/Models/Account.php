<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\AccountCreated;
use Laravel\Jetstream\Events\AccountDeleted;
use Laravel\Jetstream\Events\AccountUpdated;
use Laravel\Jetstream\Account as JetstreamAccount;
use App\Models\SubscribePlan;
use App\Models\DeletedAccount;
use App\Models\TypeSubscribe;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Account extends JetstreamAccount
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_account' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string<int, string>
     */
    protected $fillable = [
        'name',
        'personal_account',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => AccountCreated::class,
        'updated' => AccountUpdated::class,
        'deleted' => AccountDeleted::class,
    ];

    public static function accountsPlans(){
        //   return self::join('subscriptions_plans','subscriptions_plans.account_id','=','accounts.id')
        //    ->join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
        //    ->groupBy('subscriptions_plans.type_of_subscription_id')
        //    ->select('type_of_subscriptions.subscription_type as property', DB::raw('COUNT(subscriptions_plans.type_of_subscription_id) as count'))
        //    ->get();
        return self::join('subscriptions_plans', 'subscriptions_plans.account_id', '=', 'accounts.id')
        ->join('type_of_subscriptions', 'type_of_subscriptions.id', '=', 'subscriptions_plans.type_of_subscription_id')
        ->groupBy('type_of_subscriptions.id')
        ->select(
            'type_of_subscriptions.subscription_type as property',
            DB::raw('SUM(CASE WHEN subscriptions_plans.valid = 1 THEN 1 ELSE 0 END) as valid_count'),
            DB::raw('SUM(CASE WHEN subscriptions_plans.valid = 0 THEN 1 ELSE 0 END) as expired_count')
        )
        ->get();

    }
    public static function accountsStatus(){
        $activeQuery = self::select(
            DB::raw('"Active" AS property'),
            DB::raw('COUNT(*) as count')
        )
        ->where('active', '=', 1);

        $suspendedQuery = self::select(
            DB::raw('"Suspended" AS property'),
            DB::raw('COUNT(*) as count')
        )
        ->where('active', '=', 0);

        return $activeQuery->union($suspendedQuery)->groupBy('property')->get();

  }
    public static function accountsDates(){
       // Get the current date and time
        $currentDate = Carbon::now();

        // Get the start of the current month
        $startOfMonth = Carbon::now()->startOfMonth();

        // Retrieve accounts created today
        $accountsCreatedToday = self::whereDate('created_at', $currentDate->toDateString()) // Compare the date part
            ->count();

        // Retrieve accounts created this month
        $accountsCreatedThisMonth = self::whereMonth('created_at', $startOfMonth->month) // Compare the month
            ->whereYear('created_at', $startOfMonth->year) // Compare the year
            ->count();


        $resultArray = [
            'Today' => $accountsCreatedToday,
            'This Month' => $accountsCreatedThisMonth,
        ];
      return $resultArray;
    }
    public static function accountsRateData(){
        $accountsCounts = self::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the data in the format required for your chart library (e.g., Chart.js)
        $chartData = [
            'labels' => $accountsCounts->pluck('date')->toArray(),
            'data' => $accountsCounts->pluck('count')->toArray(),
        ];

        return $chartData;
    }
    public static function knowus_sources(){
        return self::select(
            DB::raw('CASE WHEN know_about_us IS NULL THEN "No answer" ELSE know_about_us END AS sourceType'),
            DB::raw('COUNT(*) as sourceCount')
        )
        ->groupBy('sourceType')
        ->get();
    }
    public static function accountsDeleted(){
        return count(DeletedAccount::all());
    }
    public static function accountInfo(){
        $accountsPlan=self::accountsPlans();
        $accountsStatus=self::accountsStatus();
        $accountsDeleted=self::accountsDeleted();

        $accountsDates=self::accountsDates();
        $accountCount=self::all()->count();
        $accountsRateData=self::accountsRateData();
        $knowus_sources=self::knowus_sources();

        // Create the array
        $accounts = [
            'accountsPlan' => $accountsPlan,
            'accountsStatus' => $accountsStatus,
            'accountsDeleted'=>$accountsDeleted,
            'accountsDates'=>$accountsDates,
            'accountsRateData'=>$accountsRateData,
            'accountCount'=>$accountCount,
            'knowus_sources'=>$knowus_sources,
        ];
        return $accounts;
    }
}
