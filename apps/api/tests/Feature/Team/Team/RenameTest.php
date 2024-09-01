<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Team;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class RenameTest extends TestCase
{
    public function test_users_cannot_rename_teams_as_unauthenticated(): void
    {
        $team = Team::factory()->create([
            'name' => 'Team 1'
        ]);

        $response = $this->patchJson(route('api.teams.rename', ['team' => $team]), [
            'name' => 'Team 2'
        ]);

        $response->assertUnauthorized();

        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 1',
        ]);
    }

    public function test_users_cannot_rename_teams_which_not_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('api.teams.rename', ['team' => 99]), [
            'name' => 'Team 2'
        ]);

        $response->assertNotFound();
    }

    public function test_owners_can_rename_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'name' => 'Team 1',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->patchJson(route('api.teams.rename', ['team' => $team]), [
            'name' => 'Team 2'
        ]);

        $response->assertOk();
        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 2',
        ]);
    }

    public function test_members_cannot_rename_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->hasAttached($user)->create([
            'name' => 'Team 1',
        ]);

        $response = $this->actingAs($user)->patchJson(route('api.teams.rename', ['team' => $team]), [
            'name' => 'Team 2'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 1',
        ]);
    }

    public function test_users_cannot_rename_foreign_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'name' => 'Team 1',
        ]);

        $response = $this->actingAs($user)->patchJson(route('api.teams.rename', ['team' => $team]), [
            'name' => 'Team 2'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 1',
        ]);
    }

    public function test_owners_cannot_rename_foreign_teams(): void
    {
        $user = User::factory()->create();

        Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Team 1',
        ]);

        $team2 = Team::factory()->create([
            'name' => 'Team 2',
        ]);

        $response = $this->actingAs($user)->patchJson(route('api.teams.rename', ['team' => $team2]), [
            'name' => 'Team 55'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing(Team::class, [
            'name' => 'Team 55',
        ]);
    }
}
