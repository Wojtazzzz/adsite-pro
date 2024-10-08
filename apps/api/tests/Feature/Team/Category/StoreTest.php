<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Category;

use App\Models\Category;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_users_cannot_create_category_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $response = $this->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertUnauthorized();
    }

    public function test_owner_can_create_category(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertCreated();
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseHas(Category::class, [
            'name' => 'Category 1',
            'team_id' => $team->id,
        ]);
    }

    public function test_owners_cannot_create_category_for_not_owned_teams(): void
    {
        $user = User::factory()->create();
        Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $team2 = Team::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team2]), [
            'name' => 'Category 1'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount(Category::class, 0);
    }

    public function test_owner_cannot_create_category_with_too_short_name(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'C'
        ]);

        $response->assertUnprocessable();
        $this->assertDatabaseCount(Category::class, 0);
    }

    public function test_member_cannot_create_category(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->hasAttached($user)->create();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount(Category::class, 0);
    }

    public function test_stranger_cannot_create_category(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount(Category::class, 0);
    }

    public function test_owners_cannot_create_category_with_same_name(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertBadRequest();
        $this->assertDatabaseCount(Category::class, 1);
    }

    public function test_owners_can_create_max_3_categories_for_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 1'
        ]);

        $response->assertCreated();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 2'
        ]);

        $response->assertCreated();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 3'
        ]);

        $response->assertCreated();

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team]), [
            'name' => 'Category 4'
        ]);

        $response->assertBadRequest();
        $this->assertDatabaseCount(Category::class, 3);

        $team2 = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson(route('api.teams.categories.store', ['team' => $team2]), [
            'name' => 'Category 1'
        ]);

        $response->assertCreated();
        $this->assertDatabaseCount(Category::class, 4);
    }
}
