<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Mail\AccountInvitation;

test('account members can be invited to account', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalAccount()->create());

    $response = $this->post('/accounts/'.$user->currentAccount->id.'/members', [
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    Mail::assertSent(AccountInvitation::class);

    expect($user->currentAccount->fresh()->accountInvitations)->toHaveCount(1);
})->skip(function () {
    return ! Features::sendsAccountInvitations();
}, 'Account invitations not enabled.');

test('account member invitations can be cancelled', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalAccount()->create());

    $invitation = $user->currentAccount->accountInvitations()->create([
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    $response = $this->delete('/account-invitations/'.$invitation->id);

    expect($user->currentAccount->fresh()->accountInvitations)->toHaveCount(0);
})->skip(function () {
    return ! Features::sendsAccountInvitations();
}, 'Account invitations not enabled.');
