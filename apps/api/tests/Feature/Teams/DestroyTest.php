<?php

declare(strict_types=1);

namespace tests\Feature\Teams;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_users_cannot_delete_teams_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $response = $this->deleteJson(route('api.teams.delete', ['team' => $team]));
        $response->assertUnauthorized();
    }

    public function test_users_cannot_delete_teams_which_not_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('api.teams.delete', ['team' => 99]));
        $response->assertNotFound();
    }

    public function test_owners_can_delete_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount(Team::class, 1);

        $response = $this->actingAs($user)->deleteJson(route('api.teams.delete', ['team' => $team]));

        $response->assertNoContent();
        $this->assertDatabaseCount(Team::class, 0);
    }

    public function test_members_cannot_delete_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->hasAttached($user)->create();

        $this->assertDatabaseCount(Team::class, 1);

        $response = $this->actingAs($user)->deleteJson(route('api.teams.delete', ['team' => $team]));

        $response->assertForbidden();
        $this->assertDatabaseCount(Team::class, 1);
    }

    public function test_users_cannot_delete_foreign_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $this->assertDatabaseCount(Team::class, 1);

        $response = $this->actingAs($user)->deleteJson(route('api.teams.delete', ['team' => $team]));

        $response->assertForbidden();
        $this->assertDatabaseCount(Team::class, 1);
    }
}
