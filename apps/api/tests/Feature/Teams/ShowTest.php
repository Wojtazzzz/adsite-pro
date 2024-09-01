<?php

declare(strict_types=1);

namespace tests\Feature\Teams;

use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_users_cannot_get_team_details_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $response = $this->getJson(route('api.teams.show', ['team' => $team]));
        $response->assertUnauthorized();
    }

    public function test_users_cannot_get_details_of_team_which_does_not_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('api.teams.show', ['team' => 18]));

        $response->assertNotFound();
    }

    public function test_users_can_get_details_of_owned_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'categories' => [],
                'id' => $team->id,
                'name' => $team->name,
            ]
        ]);
    }

    public function test_members_can_get_details_about_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->hasAttached(
            $user
        )->create();

        $response = $this->actingAs($user)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'categories' => [],
                'id' => $team->id,
                'name' => $team->name,
            ]
        ]);
    }

    public function test_users_cannot_get_details_about_foreign_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $response = $this->actingAs($user)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertForbidden();
    }

    public function test_owners_can_get_members_tasks(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()
            ->hasAttached($member)
            ->create([
                'user_id' => $owner->id,
            ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member->id,
        ]);

        $response = $this->actingAs($owner)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertJson(function (AssertableJson $json) use ($category, $task) {
            $json->has('data', function (AssertableJson $json) use ($category, $task) {
                $json->has('categories.0', function (AssertableJson $json) use ($category, $task) {
                    $json->where('id', $category->id);
                    $json->where('name', $category->name);
                    $json->has('tasks.0', function (AssertableJson $json) use ($task) {
                        $json->where('id', $task->id);
                        $json->where('user_id', $task->user_id);
                        $json->etc();
                    });
                });
                $json->etc();
            });
        });
    }

    public function test_owners_can_get_own_tasks(): void
    {
        $owner = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $owner->id,
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $owner->id,
        ]);

        $response = $this->actingAs($owner)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertJson(function (AssertableJson $json) use ($category, $task) {
            $json->has('data', function (AssertableJson $json) use ($category, $task) {
                $json->has('categories.0', function (AssertableJson $json) use ($category, $task) {
                    $json->where('id', $category->id);
                    $json->where('name', $category->name);
                    $json->has('tasks.0', function (AssertableJson $json) use ($task) {
                        $json->where('id', $task->id);
                        $json->where('user_id', $task->user_id);
                        $json->etc();
                    });
                });
                $json->etc();
            });
        });
    }

    public function test_members_can_get_own_tasks(): void
    {
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create();

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member->id,
        ]);

        $response = $this->actingAs($member)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertJson(function (AssertableJson $json) use ($category, $task) {
            $json->has('data', function (AssertableJson $json) use ($category, $task) {
                $json->has('categories.0', function (AssertableJson $json) use ($category, $task) {
                    $json->where('id', $category->id);
                    $json->where('name', $category->name);
                    $json->has('tasks.0', function (AssertableJson $json) use ($task) {
                        $json->where('id', $task->id);
                        $json->where('user_id', $task->user_id);
                        $json->etc();
                    });
                });
                $json->etc();
            });
        });
    }

    public function test_members_cannot_get_foreign_tasks(): void
    {
        $member = User::factory()->create();
        $member2 = User::factory()->create();

        $team = Team::factory()
            ->hasAttached($member)
            ->hasAttached($member2)
            ->create();

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member2->id,
        ]);

        $response = $this->actingAs($member)->getJson(route('api.teams.show', ['team' => $team]));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
                'categories' => [
                    [
                        'id' => $category->id,
                        'name' => $category->name,
                        'tasks' => []
                    ]
                ]
            ]
        ]);
    }
}
