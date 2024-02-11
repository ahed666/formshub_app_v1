<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesAccounts;
use Laravel\Jetstream\Contracts\DeletesUsers;
use App\Notifications\DeleteAccount;
class DeleteUser implements DeletesUsers
{
    /**
     * The account deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesAccounts
     */
    protected $deletesAccounts;

    /**
     * Create a new action instance.
     */
    public function __construct(DeletesAccounts $deletesAccounts)
    {
        $this->deletesAccounts = $deletesAccounts;
    }

    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    { 
        DB::transaction(function () use ($user) {

            $this->deleteAccounts($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();

        });
    }

    /**
     * Delete the accounts and account associations attached to the user.
     */
    protected function deleteAccounts(User $user): void
    {
        $user->accounts()->detach();

        $user->ownedAccounts->each(function (Account $account) {
            $this->deletesAccounts->delete($account);
        });
    }
}
