<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Game;
use App\Models\Role;
use App\Models\User;
use Database\Factories\GameFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

         Role::factory(3)->create();

         Company::factory(10)->create();

         Comment::factory(30)->create();

         Category::factory(10)->create();

        $ids = range(1, 10);

        //seed pivot table category_game with random categories
         Game::factory(10)->create()->each(function ($game) use($ids) {
             shuffle($ids);
             $game->categories()->attach(array_slice($ids, 0, rand(1, 3)));
             $game->users()->attach(array_slice($ids, 0, rand(1, 3)));
         });

         //create one admin
        User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'pseudo' => 'admin',
            'company_id' => 1,
            'role_id' => 1,
            'email' => 'admin@admin.fr',
            'password' => bcrypt('admin'),
        ]);

    }
}
