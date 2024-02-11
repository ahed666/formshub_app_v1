<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_deleted(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->ownedTeams()->save($account = Account::factory()->make([
            'personal_account' => false,
        ]));

        $account->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'test-role']
        );

        $component = Livewire::test(DeleteTeamForm::class, ['account' => $account->fresh()])
                                ->call('deleteTeam');

        $this->assertNull($account->fresh());
        $this->assertCount(0, $otherUser->fresh()->accounts);
    }

    public function test_personal_teams_cant_be_deleted(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(DeleteTeamForm::class, ['account' => $user->currentTeam])
                                ->call('deleteTeam')
                                ->assertHasErrors(['account']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
