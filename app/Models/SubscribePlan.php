<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\canceledPlan;

class SubscribePlan extends Model
{
    use HasFactory;
    protected $table="subscriptions_plans";
    protected $casts = [
        'expired_at' => 'datetime', // Assuming 'expired_at' is a date or datetime column
    ];

    public static function getCurrentSubscription($account_id){
        return self::join("type_of_subscriptions","type_of_subscriptions.id","=","subscriptions_plans.type_of_subscription_id")
        ->where("subscriptions_plans.account_id",$account_id)->select('subscriptions_plans.*','type_of_subscriptions.num_responses',
        'type_of_subscriptions.num_questions','type_of_subscriptions.num_kiosks','type_of_subscriptions.num_forms','type_of_subscriptions.todo',
        'type_of_subscriptions.signpdf','type_of_subscriptions.num_media_items',
        'type_of_subscriptions.export','type_of_subscriptions.custom_form','type_of_subscriptions.account_members',
        'type_of_subscriptions.professional_dashboard_statistics','type_of_subscriptions.pro_questions','type_of_subscriptions.form_terms'
        ,'type_of_subscriptions.id as plan_id','type_of_subscriptions.subscription_type as type','type_of_subscriptions.order_plan',
        'type_of_subscriptions.multi_languages','type_of_subscriptions.locked_d_period','type_of_subscriptions.grace_period','type_of_subscriptions.grace_period','type_of_subscriptions.locked_period',
        DB::raw('CASE
            WHEN subscriptions_plans.expired_at >= CURDATE() AND subscriptions_plans.valid = 1 THEN "Valid"
            WHEN CURDATE()  <= DATE_ADD(subscriptions_plans.expired_at,INTERVAL type_of_subscriptions.grace_period MONTH) AND subscriptions_plans.valid = 1 THEN "Grace"
            WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) THEN "Locked"

        END AS subscription_status'),
        DB::raw('CASE
        WHEN subscriptions_plans.expired_at >= CURDATE() AND subscriptions_plans.valid = 1 THEN DATEDIFF( subscriptions_plans.expired_at,CURDATE())+1
        WHEN CURDATE() <= DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) AND subscriptions_plans.valid = 1 THEN DATEDIFF(DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH),CURDATE())+1
        WHEN CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) THEN
        GREATEST(DATEDIFF(
            DATE_ADD(
                DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH),
                 INTERVAL type_of_subscriptions.grace_period MONTH),
                 CURDATE() )+1
             ,0)

        END AS allowed_days')
        )
        ->where('subscriptions_plans.active','=',true)
        ->first();
    }
    public static function subscriptionsStatus(){
//             DB::raw('SUM((CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH)) AND (CURDATE() <= DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH)) THEN 1 ELSE 0 END) as locked'),

        return self::join('accounts', 'subscriptions_plans.account_id', '=', 'accounts.id')
        ->join('type_of_subscriptions', 'type_of_subscriptions.id', '=', 'subscriptions_plans.type_of_subscription_id')
        ->groupBy('type_of_subscriptions.id')
        ->select(
            'type_of_subscriptions.subscription_type as property',
            DB::raw('SUM(CASE WHEN subscriptions_plans.expired_at >= CURDATE() AND subscriptions_plans.valid = 1 THEN 1 ELSE 0 END) as valid'),
            DB::raw('SUM(CASE WHEN CURDATE()  <= DATE_ADD(subscriptions_plans.expired_at,INTERVAL type_of_subscriptions.grace_period MONTH) AND CURDATE()  > subscriptions_plans.expired_at AND subscriptions_plans.valid = 1 THEN 1 ELSE 0 END) as grace'),
            DB::raw('SUM(CASE WHEN CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) AND subscriptions_plans.valid = 0 THEN 1 ELSE 0 END) as locked'),

            )
        ->get();
    }
    public static function getCurrentAccountStatus($account_id){
         $subscriptionPlan=self::getCurrentSubscription($account_id);

         return [
            'status'=>$subscriptionPlan->subscription_status,
         ];

    }
    public static function subscriptionsCanceled(){
       return count(canceledPlan::all());
    }
    public static function subscriptionsCount(){
        return count(self::all());
     }
    public static function subscriptionInfo(){
        $subscriptionsStatus=self::subscriptionsStatus();

        $subscriptionsCanceled=self::subscriptionsCanceled();
        $subscriptionsCount=self::subscriptionsCount();
        // Create the array
        $subscriptions = [
            'subscriptionsStatus' => $subscriptionsStatus,
            'subscriptionssCanceled'=>$subscriptionsCanceled,
            'subscriptionsCount'=>$subscriptionsCount,

        ];
        return $subscriptions;

    }


}
