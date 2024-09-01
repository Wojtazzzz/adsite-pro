<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Team;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_users_cannot_get_teams_as_unauthenticated(): void
    {
        $response = $this->getJson(route('api.teams.index'));
        $response->assertUnauthorized();
    }

    public function test_ok_response_when_no_teams(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('api.teams.index'));

        $response->assertOk();
        $response->assertJson([
            'data' => []
        ]);
    }

    public function test_users_can_get_owned_teams(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.index'));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $team->id,
                    'name' => $team->name,
                    'isOwner' => true,
                ]
            ]
        ]);
    }


    public function test_users_can_get_teams_where_are_members(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->hasAttached(
            $user
        )->create();

        $response = $this->actingAs($user)->getJson(route('api.teams.index'));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $team->id,
                    'name' => $team->name,
                    'isOwner' => false,
                ]
            ]
        ]);
    }
}
