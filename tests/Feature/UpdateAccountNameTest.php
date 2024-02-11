<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateAccountNameForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateAccountNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_names_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(UpdateAccountNameForm::class, ['account' => $user->currentAccount])
                    ->set(['state' => ['name' => 'Test Account']])
                    ->call('updateAccountName');

        $this->assertCount(1, $user->fresh()->ownedAccounts);
        $this->assertEquals('Test Account', $user->currentAccount->fresh()->name);
    }
}
