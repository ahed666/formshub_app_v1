<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Account;
use App\Models\SubscribePlan;
use App\Models\DeletedAccount;
use App\Models\SignFile;
use App\Models\Form;
use App\Models\Kiosk;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\File;
use App\Notifications\DeleteAccount;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->email_sub_notification=$request->has('email_sub_notification');
        $request->user()->email_sub_offers_events=$request->has('email_sub_offers_events');
        $request->user()->email_sub_security=$request->has('email_sub_security');
        $request->user()->email_sub_payment_subscriptions=$request->has('email_sub_payment_subscriptions');
        $request->user()->timezone= $request['timezone'];
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();
        //  add new record for delete account

        $account=Account::whereuser_id(Auth::user()->id)->first();

        $subscription=SubscribePlan::join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')->where('subscriptions_plans.account_id',Auth::user()->current_account_id)
        ->select('type_of_subscriptions.subscription_type','subscriptions_plans.created_at')->first();


        // delete all data of account in storage folder
        $directoryPath='storage/accounts/account-'.$account->id;
        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        }



        $deletedAccount=new DeletedAccount();
        $deletedAccount->account_id=$account->id;
        $deletedAccount->email=$user->email;
        $deletedAccount->account_created_at=$user->created_at;
        $deletedAccount->plan_type=$subscription->subscription_type;
        $deletedAccount->plan_created_at=$subscription->created_at;
        $deletedAccount->save();


        Auth::logout();

        $user->delete();
        try {
            $user->notify(new DeleteAccount());
        } catch (\Throwable $th) {
            //throw $th;
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
