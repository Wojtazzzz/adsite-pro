<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Task;

use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_users_cannot_create_task_as_unauthenticated(): void
    {
        $team = Team::factory()->create();
        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $member = User::factory()->create();

        $response = $this->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $member->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertUnauthorized();
    }

    public function test_owner_can_create_task_for_yourself(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $user->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertCreated();
        $this->assertDatabaseCount(Task::class, 1);
        $this->assertDatabaseHas(Task::class, [
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'estimation' => 15,
            'status' => TaskStatus::IDLE->value,
        ]);
    }

    public function test_owner_can_create_task_for_a_member(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $member->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertCreated();
        $this->assertDatabaseCount(Task::class, 1);
        $this->assertDatabaseHas(Task::class, [
            'user_id' => $member->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'estimation' => 15,
            'status' => TaskStatus::IDLE->value,
        ]);
    }

    public function test_owner_cannot_exceed_max_user_estimation_with_single_task(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $member->id,
                'name' => 'Task 2',
                'description' => 'Task 2 description',
                'estimation' => 9800,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertBadRequest();
        $this->assertDatabaseCount(Task::class, 0);
    }

    public function test_owner_cannot_exceed_max_user_estimation_with_two_tasks(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $member->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 5600,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertCreated();
        $this->assertDatabaseCount(Task::class, 1);

        $response2 = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $member->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 5600,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response2->assertBadRequest();
        $this->assertDatabaseCount(Task::class, 1);
    }

    public function test_owner_can_create_task_with_correct_status(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $user->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $user->id,
                'name' => 'Task 2',
                'description' => 'Task 2 description',
                'estimation' => 15,
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $user->id,
                'name' => 'Task 3',
                'description' => 'Task 3 description',
                'estimation' => 15,
                'status' => TaskStatus::COMPLETED->value,
            ]
        );

        $this->assertDatabaseCount(Task::class, 3);
        $this->assertDatabaseHas(Task::class, [
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'estimation' => 15,
            'status' => TaskStatus::IDLE->value,
        ]);
        $this->assertDatabaseHas(Task::class, [
            'user_id' => $user->id,
            'name' => 'Task 2',
            'description' => 'Task 2 description',
            'estimation' => 15,
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);
        $this->assertDatabaseHas(Task::class, [
            'user_id' => $user->id,
            'name' => 'Task 3',
            'description' => 'Task 3 description',
            'estimation' => 15,
            'status' => TaskStatus::COMPLETED->value,
        ]);
    }

    public function test_owner_cannot_create_task_for_a_stranger(): void
    {
        $user = User::factory()->create();
        $stranger = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $stranger->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertUnprocessable();
        $this->assertDatabaseCount(Task::class, 0);
    }

    public function test_member_cannot_create_task(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id
        ]);

        $category = Category::factory()->create([
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($member)->postJson(
            route('api.teams.categories.tasks.store', ['team' => $team, 'category' => $category]),
            [
                'user_id' => $user->id,
                'name' => 'Task 1',
                'description' => 'Task 1 description',
                'estimation' => 15,
                'status' => TaskStatus::IDLE->value,
            ]
        );

        $response->assertForbidden();
        $this->assertDatabaseCount(Task::class, 0);
    }
}
