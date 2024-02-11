<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use Laravel\Jetstream\Contracts\DeletesAccounts;

class DeleteAccount implements DeletesAccounts
{
    /**
     * Delete the given account.
     */
    public function delete(Account $account): void
    {
        $account->purge();
    }
}
