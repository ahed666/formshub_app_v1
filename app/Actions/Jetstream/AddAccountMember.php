<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsAccountMembers;
use Laravel\Jetstream\Events\AddingAccountMember;
use Laravel\Jetstream\Events\AccountMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddAccountMember implements AddsAccountMembers
{

    /**
     * Add a new account member to the given account.
     */
    public function add(User $user, Account $account, string $email, string $role = null): void
    {

        Gate::forUser($user)->authorize('addAccountMember', $account);

        $this->validate($account, $email, $role);



        $newAccountMember = Jetstream::findUserByEmailOrFail($email);

        AddingAccountMember::dispatch($account, $newAccountMember);

        $account->users()->attach(
            $newAccountMember, ['role' => $role]
        );

        AccountMemberAdded::dispatch($account, $newAccountMember);
    }

    /**
     * Validate the add member operation.
     */
    protected function validate(Account $account, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules(), [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnAccount($account, $email)
        )->validateWithBag('addAccountMember');
    }

    /**
     * Get the validation rules for adding a account member.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules(): array
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the account.
     */
    protected function ensureUserIsNotAlreadyOnAccount(Account $account, string $email): Closure
    {
        return function ($validator) use ($account, $email) {
            $validator->errors()->addIf(
                $account->hasUserWithEmail($email),
                'email',
                __('main.userbelongtoaccount')
            );
        };
    }
}
