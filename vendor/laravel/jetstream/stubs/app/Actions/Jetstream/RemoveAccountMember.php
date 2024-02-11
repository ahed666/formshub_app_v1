<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesAccountMembers;
use Laravel\Jetstream\Events\AccountMemberRemoved;

class RemoveAccountMember implements RemovesAccountMembers
{
    /**
     * Remove the Account member from the given Account.
     */
    public function remove(User $user, Account $account, User $accountMember): void
    {
        $this->authorize($user, $account, $accountMember);

        $this->ensureUserDoesNotOwnAccount($accountMember, $account);

        $account->removeUser($accountMember);

        AccountMemberRemoved::dispatch($account, $accountMember);
    }

    /**
     * Authorize that the user can remove the account member.
     */
    protected function authorize(User $user, Account $account, User $accountMember): void
    {
        if (! Gate::forUser($user)->check('removeAccountMember', $account) &&
            $user->id !== $accountMember->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the Account.
     */
    protected function ensureUserDoesNotOwnAccount(User $accountMember, Account $account): void
    {
        if ($accountMember->id === $account->owner->id) {
            throw ValidationException::withMessages([
                'account' => [__('You may not leave a account that you created.')],
            ])->errorBag('removeAccountMember');
        }
    }
}
