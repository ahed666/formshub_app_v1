<?php

namespace App\Actions\Jetstream;

use App\Models\Account;
use App\Models\User;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesAccountMembers;
use Laravel\Jetstream\Events\InvitingAccountMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\AccountInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteAccountMember implements InvitesAccountMembers
{
    /**
     * Invite a new account member to the given account.
     */
    public function invite(User $user, Account $account, string $email, string $role = null): void
    {
        Gate::forUser($user)->authorize('addAccountMember', $account);

        $this->validate($account, $email, $role);

        InvitingAccountMember::dispatch($account, $email, $role);

        $invitation = $account->accountInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);

        Mail::to($email)->send(new AccountInvitation($invitation));
    }

    /**
     * Validate the invite member operation.
     */
    protected function validate(Account $account, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules($account), [
            'email.unique' => __('main.useralreadyinvited'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnAccount($account, $email)
        )->validateWithBag('addAccountMember');
    }

    /**
     * Get the validation rules for inviting a account member.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules(Account $account): array
    {
        return array_filter([
            'email' => [
                'required', 'email',
                Rule::unique('account_invitations')->where(function (Builder $query) use ($account) {
                    $query->where('account_id', $account->id);
                }),
            ],
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
