<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Mail\AccountInvitation;
use Tests\TestCase;

class InviteAccountMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_members_can_be_invited_to_account(): void
    {
        if (! Features::sendsAccountInvitations()) {
            $this->markTestSkipped('Account invitations not enabled.');

            return;
        }

        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalAccount()->create());

        $response = $this->post('/accounts/'.$user->currentAccount->id.'/members', [
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        Mail::assertSent(AccountInvitation::class);

        $this->assertCount(1, $user->currentAccount->fresh()->accountInvitations);
    }

    public function test_account_member_invitations_can_be_cancelled(): void
    {
        if (! Features::sendsAccountInvitations()) {
            $this->markTestSkipped('Account invitations not enabled.');

            return;
        }

        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalAccount()->create());

        $invitation = $user->currentAccount->accountInvitations()->create([
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        $response = $this->delete('/account-invitations/'.$invitation->id);

        $this->assertCount(0, $user->currentAccount->fresh()->accountInvitations);
    }
}
