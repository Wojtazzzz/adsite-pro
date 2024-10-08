<?php

declare(strict_types=1);

namespace tests\Feature\Teams\User;

use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class DetailsTest extends TestCase
{
    public function test_users_cannot_get_users_details_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $response = $this->getJson(route('api.teams.users.details', ['team' => $team]));
        $response->assertUnauthorized();
    }

    public function test_owners_can_get_yourself(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.users.details', ['team' => $team]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                    'tasksCount' => 0,
                    'idleTasksCount' => 0,
                    'inProgressTasksCount' => 0,
                    'completedTasksCount' => 0,
                    'totalEstimation' => 0,
                ]
            ]
        ]);
    }

    public function test_owners_can_get_members_details(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.users.details', ['team' => $team]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                    'tasksCount' => 0,
                    'idleTasksCount' => 0,
                    'inProgressTasksCount' => 0,
                    'completedTasksCount' => 0,
                    'totalEstimation' => 0,
                ],
                [
                    'id' => $member->id,
                    'name' => $member->name,
                    'tasksCount' => 0,
                    'idleTasksCount' => 0,
                    'inProgressTasksCount' => 0,
                    'completedTasksCount' => 0,
                    'totalEstimation' => 0,
                ]
            ]
        ]);
    }

    public function test_members_cannot_get_details(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($member)->getJson(route('api.teams.users.details', ['team' => $team]));

        $response->assertForbidden();
    }

    public function test_strangers_cannot_get_details(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($member)->getJson(route('api.teams.users.details', ['team' => $team]));

        $response->assertForbidden();
    }

    public function test_stats_are_correct(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'estimation' => 15,
            'status' => TaskStatus::IDLE->value,
        ]);

        Task::factory(2)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Task 2',
            'description' => 'Task 2 description',
            'estimation' => 30,
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);

        Task::factory(3)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Task 2',
            'description' => 'Task 2 description',
            'estimation' => 60,
            'status' => TaskStatus::COMPLETED->value,
        ]);

        $team2 = Team::factory()->create();
        $category2 = Category::factory()->create([
            'team_id' => $team2->id,
        ]);

        Task::factory(3)->create([
            'user_id' => $user->id,
            'category_id' => $category2->id,
            'name' => 'Task 2',
            'description' => 'Task 2 description',
            'estimation' => 60,
            'status' => TaskStatus::COMPLETED->value,
        ]);

        $response = $this->actingAs($user)->getJson(route('api.teams.users.details', ['team' => $team]));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                    'tasksCount' => 6,
                    'idleTasksCount' => 1,
                    'inProgressTasksCount' => 2,
                    'completedTasksCount' => 3,
                    'totalEstimation' => 255,
                ]
            ]
        ]);
    }
}

