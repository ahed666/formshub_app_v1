<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesAccounts;
use Laravel\Jetstream\Events\AddingAccount;
use Laravel\Jetstream\Jetstream;

class CreateAccount implements CreatesAccounts
{
    /**
     * Validate and create a new account for the given user.
     *
     * @param  array<string, string>  $input
     */
    public function create(User $user, array $input): Account
    {
        Gate::forUser($user)->authorize('create', Jetstream::newAccountModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createAccount');

        AddingAccount::dispatch($user);

        $user->switchAccoun($account = $user->ownedAccounts()->create([
            'name' => $input['name'],
            'personal_account' => false,
        ]));

        return $account;
    }
}
