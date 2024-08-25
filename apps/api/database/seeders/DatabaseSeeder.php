<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password')
        ]);

        $user = User::create([
            'name' => 'Marcin Witas',
            'email' => 'marcin.witas72@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $team = Team::firstOrCreate([
            'name' => 'Team 1',
            'user_id' => $owner->id,
        ]);

        $team->users()->attach($user);

        $category = Category::create([
            'name' => 'Category 1',
            'team_id' => $team->id,
        ]);

        $category_2 = Category::create([
            'name' => 'Category 2',
            'team_id' => $team->id,
        ]);

        Task::create([
            'category_id' => $category_2->id,
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => fake()->text(),
            'estimation' => 30,
            'status' => 'IDLE'
        ]);

        Task::create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'name' => 'Task 2',
            'description' => fake()->text(),
            'estimation' => 30,
            'status' => 'IDLE'
        ]);

        Task::create([
            'category_id' => $category_2->id,
            'user_id' => $user->id,
            'name' => 'Task 3',
            'description' => fake()->text(),
            'estimation' => 60,
            'status' => 'IDLE'
        ]);
    }
}
