<?php

declare(strict_types=1);

namespace tests\Feature\Teams\Task;

use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class UpdateStatusTest extends TestCase
{
    public function test_users_cannot_update_status_as_unauthenticated(): void
    {
        $team = Team::factory()->create();

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertUnauthorized();
    }

    public function test_team_owners_can_update_status_on_own_tasks(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($user)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);
    }

    public function test_team_owners_can_update_status_on_members_tasks(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($user)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::COMPLETED->value,
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::COMPLETED->value,
        ]);
    }

    public function test_task_owners_can_update_status_on_own_tasks(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($member)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);
    }

    public function test_task_owners_cannot_update_status_on_other_members_tasks(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();
        $member2 = User::factory()->create();

        $team = Team::factory()->hasAttached($member)->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member2->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($member)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertForbidden();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::IDLE->value,
        ]);
    }

    public function test_strangers_cannot_update_status_on_tasks(): void
    {
        $user = User::factory()->create();
        $stranger = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['team_id' => $team->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($stranger)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertForbidden();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::IDLE->value,
        ]);
    }

    public function test_owners_cannot_update_status_on_foreign_teams_members(): void
    {
        $user = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $team2 = Team::factory()->hasAttached($member)->create();

        $category = Category::factory()->create(['team_id' => $team2->id]);

        $task = Task::factory()->create([
            'category_id' => $category->id,
            'user_id' => $member->id,
            'name' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => TaskStatus::IDLE->value
        ]);

        $response = $this->actingAs($user)->patchJson(
            route('api.teams.categories.tasks.update.status', ['team' => $team, 'category' => $category, 'task' => $task]),
            [
                'status' => TaskStatus::IN_PROGRESS->value,
            ]
        );

        $response->assertForbidden();
        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'status' => TaskStatus::IDLE->value,
        ]);
    }
}
