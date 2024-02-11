<?php

namespace App\Providers;

use App\Actions\Jetstream\AddAccountMember;
use App\Actions\Jetstream\CreateAccount;
use App\Actions\Jetstream\DeleteAccount;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteAccountMember;
use App\Actions\Jetstream\RemoveAccountMember;
use App\Actions\Jetstream\UpdateAccountName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createAccountsUsing(CreateAccount::class);
        Jetstream::updateAccountNamesUsing(UpdateAccountName::class);
        Jetstream::addAccountMembersUsing(AddAccountMember::class);
        Jetstream::inviteAccountMembersUsing(InviteAccountMember::class);
        Jetstream::removeAccountMembersUsing(RemoveAccountMember::class);
        Jetstream::deleteAccountsUsing(DeleteAccount::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description(trans('main.admindesc'));

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description(trans('main.editordesc'));
    }
}
