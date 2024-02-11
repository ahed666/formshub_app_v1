<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesAccountNames;

class UpdateAccountName implements UpdatesAccountNames
{
    /**
     * Validate and update the given account's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, Account $account, array $input): void
    {

        Gate::forUser($user)->authorize('update', $account);
        
        Validator::make($input, [

            'business_name' => ['max:255'],
            'business_address' => ['max:255'],
            'billing_address' => ['max:255'],
            'tax_number' => ['max:255'],
            'city' => ['required'],
            'country' => ['required'],
        ])->validateWithBag('updateAccountName');

        $account->forceFill([

            'business_name'=>$input['business_name'],
            'business_address'=>$input['business_address'],
            'billing_address'=>$input['billing_address'],
            'tax_number'=>$input['tax_number'],
            'phone_number'=>$input['phone_number'],
            'city'=>$input['city'],
            'country'=>$input['country'],
        ])->save();

    }
}
