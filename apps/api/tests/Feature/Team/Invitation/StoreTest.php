<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Invitation;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_users_cannot_create_invitation_as_unauthenticated(): void
    {
        $team = Team::factory()->create();
        $guest = User::factory()->create();

        $response = $this->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertUnauthorized();
    }

    public function test_owners_can_create_invitation(): void
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertCreated();
    }

    public function test_owners_cannot_create_invitation_for_invalid_email(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => 'invalid-email.com',
            ]
        );

        $response->assertUnprocessable();
    }

    public function test_owners_cannot_create_invitation_for_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $member->email,
            ]
        );

        $response->assertUnprocessable();
    }

    public function test_owners_cannot_create_invitation_for_already_invited_users(): void
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        Invitation::factory()->create([
            'user_id' => $guest->id,
            'team_id' => $team->id,
            'status' => InvitationStatus::PENDING,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertUnprocessable();
    }

    public function test_owners_can_create_invitation_for_users_already_invited_by_some_other_teams(): void
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $team2 = Team::factory()->create();

        Invitation::factory()->create([
            'user_id' => $guest->id,
            'team_id' => $team2->id,
            'status' => InvitationStatus::PENDING,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertCreated();
    }

    public function test_owners_cannot_create_invitation_for_non_existing_user(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => 'jane@example.com',
            ]
        );

        $response->assertUnprocessable();
    }

    public function test_members_cannot_create_invitation(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();
        $guest = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($member)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertForbidden();
    }

    public function test_strangers_cannot_create_invitation(): void
    {
        $user = User::factory()->create();
        $stranger = User::factory()->create();
        $guest = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($stranger)->postJson(
            route('api.teams.invitations.store', ['team' => $team]),
            [
                'email' => $guest->email,
            ]
        );

        $response->assertForbidden();
    }
}
