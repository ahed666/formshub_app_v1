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
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateAccountName');

        $account->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
