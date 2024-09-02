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
            'name' => 'John Smith',
            'email' => 'john@smith.com',
            'password' => Hash::make('password'),
        ]);

        $member = User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => Hash::make('password')
        ]);

        $ownerTeam = Team::firstOrCreate([
            'name' => 'Owner team',
            'user_id' => $owner->id,
        ]);

        $userTeam = Team::firstOrCreate([
            'name' => 'Your team',
            'user_id' => $user->id,
        ]);

        $ownerTeam->users()->attach($user);
        $ownerTeam->users()->attach($member);

        $userTeam->users()->attach($member);

        $category = Category::create([
            'name' => 'Owner category 1',
            'team_id' => $ownerTeam->id,
        ]);

        $category2 = Category::create([
            'name' => 'Owner category 2',
            'team_id' => $ownerTeam->id,
        ]);

        Task::factory(1)->create([
            'category_id' => $category2->id,
            'user_id' => $user->id,
        ]);

        Task::factory(2)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $category = Category::create([
            'name' => 'Category 1',
            'team_id' => $userTeam->id,
        ]);

        $category2 = Category::create([
            'name' => 'Category 2',
            'team_id' => $userTeam->id,
        ]);

        Task::factory(3)->create([
            'category_id' => $category2->id,
            'user_id' => $member->id,
        ]);

        Task::factory(1)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }
}
