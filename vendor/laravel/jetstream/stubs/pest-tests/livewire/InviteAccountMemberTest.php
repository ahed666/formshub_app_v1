<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\AccountMemberManager;
use Laravel\Jetstream\Mail\AccountInvitation;
use Livewire\Livewire;

test('account members can be invited to account', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalAccount()->create());

    $component = Livewire::test(AccountMemberManager::class, ['account' => $user->currentAccount])
                    ->set('addAccountMemberForm', [
                        'email' => 'test@example.com',
                        'role' => 'admin',
                    ])->call('addAccountMember');

    Mail::assertSent(AccountInvitation::class);

    expect($user->currentAccount->fresh()->accountInvitations)->toHaveCount(1);
})->skip(function () {
    return ! Features::sendsAccountInvitations();
}, 'Account invitations not enabled.');

test('account member invitations can be cancelled', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalAccount()->create());

    // Add the account member...
    $component = Livewire::test(AccountMemberManager::class, ['account' => $user->currentAccount])
                    ->set('addAccountMemberForm', [
                        'email' => 'test@example.com',
                        'role' => 'admin',
                    ])->call('addAccountMember');

    $invitationId = $user->currentAccount->fresh()->accountInvitations->first()->id;

    // Cancel the account invitation...
    $component->call('cancelAccountInvitation', $invitationId);

    expect($user->currentAccount->fresh()->accountInvitations)->toHaveCount(0);
})->skip(function () {
    return ! Features::sendsAccountInvitations();
}, 'Account invitations not enabled.');
