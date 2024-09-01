<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Teams;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_users_cannot_create_teams_as_unauthenticated(): void
    {
        $response = $this->postJson(route('api.teams.store'), [
            'name' => 'Team 1'
        ]);
        $response->assertUnauthorized();
    }

    public function test_users_can_create_teams(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'Team 1'
        ]);

        $response->assertCreated();
        $this->assertDatabaseCount(Team::class, 1);
        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 1',
            'user_id' => $user->id,
        ]);
    }

    public function test_users_can_create_max_3_teams(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'Team 1'
        ]);

        $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'Team 2'
        ]);

        $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'Team 3'
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'Team 4'
        ]);

        $response->assertBadRequest();
        $this->assertDatabaseCount(Team::class, 3);
        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 1',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 2',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas(Team::class, [
            'name' => 'Team 3',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing(Team::class, [
            'name' => 'Team 4',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_create_team_with_too_short_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.teams.store'), [
            'name' => 'T'
        ]);

        $response->assertUnprocessable();
        $this->assertDatabaseCount(Team::class, 0);
    }
}
