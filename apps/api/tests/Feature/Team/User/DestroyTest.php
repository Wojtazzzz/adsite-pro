<?php

declare(strict_types=1);

namespace tests\Feature\Teams\User;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_users_cannot_delete_team_members_as_unauthenticated(): void
    {
        $member = User::factory()->create();
        $team = Team::factory()->hasAttached($member)->create();

        $response = $this->deleteJson(route('api.teams.users.destroy', ['team' => $team, 'user' => $member]));
        $response->assertUnauthorized();
    }

    public function test_owners_can_delete_team_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('api.teams.users.destroy', ['team' => $team, 'user' => $member]));
        $response->assertNoContent();
    }

    public function test_owners_cannot_delete_foreign_team_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $team2 = Team::factory()->hasAttached($member)->create();

        $response = $this->actingAs($user)->deleteJson(route('api.teams.users.destroy', ['team' => $team2, 'user' => $member]));

        $response->assertForbidden();
    }

    public function test_members_cannot_delete_team_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($member)->deleteJson(route('api.teams.users.destroy', ['team' => $team, 'user' => $member]));
        $response->assertForbidden();
    }

    public function test_strangers_cannot_delete_team_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();
        $stranger = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($stranger)->deleteJson(route('api.teams.users.destroy', ['team' => $team, 'user' => $member]));
        $response->assertForbidden();
    }
}
