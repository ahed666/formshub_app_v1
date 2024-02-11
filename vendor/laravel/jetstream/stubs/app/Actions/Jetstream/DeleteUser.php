<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;
use App\Notifications\DeleteAccount;
class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
        try {
            $user->notify(new DeleteAccount());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
