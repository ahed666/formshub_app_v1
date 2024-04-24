<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\AccountUser;
use App\Models\AccountInvitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Account $account): bool
    {
        return $user->belongsToAccount($account);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Account $account): bool
    {  $role=$user->accountRole($account);
        if($role->key=="admin"||$user->ownsAccount($account))
        return true;
        else
        return false;

    }

    /**
     * Determine whether the user can add account members.
     */
    public function addAccountMember(User $user, Account $account): bool
    {

        return $user->ownsAccount($account);
    }

    public function userCanBuyResponses( Account $account): bool
    {
        $plan=SubscribePlan::where('subscriptions_plans.account_id','=',$account->id)->join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
        ->first();
        if($plan->type_of_subscription_id==1)
        return false;
       return true;

    }

    public function checkAddValidPlan( Account $account):bool
    {
        $plan=SubscribePlan::where('subscriptions_plans.account_id','=',$account->id)->join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
         ->first();

        if($plan->subscription_type=="Free")
         return false;
        return true;
    }
    // max num of Invitations
    public function checkMaxInvitations(User $user, Account $account):string
    {
        $numofusers=SubscribePlan::getCurrentSubscription($account->id)->account_members;
        $invitation=accountInvitation::whereaccount_id($account->id)->get();
        $members=Accountuser::whereaccount_id($account->id)->get();
        if((count($invitation)+count($members))<$numofusers)
         return true;
        return false;
    }
    public function checkAddValidDate(User $user, Account $account):bool
    {

        $plan=SubscribePlan::where('subscriptions_plans.account_id','=',$account->id)->join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
         ->first();


        if(Carbon::parse($plan->expired_at)->isPast())
          return false;

        return true;
    }


    /**
     * Determine whether the user can update account member permissions.
     */
    public function updateAccountMember(User $user, Account $account): bool
    {
        return $user->ownsAccount($account);
    }

    /**
     * Determine whether the user can remove account members.
     */
    public function removeAccountMember(User $user, Account $account): bool
    {
        return $user->ownsAccount($account);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Account $account): bool
    {
        return $user->ownsAccount($account);
    }
}
