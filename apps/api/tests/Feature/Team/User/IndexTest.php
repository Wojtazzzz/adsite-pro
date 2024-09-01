<?php

declare(strict_types=1);

namespace tests\Feature\Teams\User;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_users_cannot_get_users_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $response = $this->getJson(route('api.teams.users.index', ['team' => $team]));
        $response->assertUnauthorized();
    }

    public function test_owners_can_get_yourself(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.users.index', ['team' => $team]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                ]
            ]
        ]);
    }

    public function test_owners_can_get_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.users.index', ['team' => $team]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                [
                    'id' => $member->id,
                    'name' => $member->name,
                ]
            ]
        ]);
    }

    public function test_members_cannot_get_users(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($member)->getJson(route('api.teams.users.index', ['team' => $team]));

        $response->assertForbidden();
    }
}
