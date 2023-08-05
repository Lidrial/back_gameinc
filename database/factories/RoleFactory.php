<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $roles;

        if (!$roles) {
            $roles = ['admin', 'developer', 'player'];
        }

        return [
            'name' => array_shift($roles),
        ];

        //permet de créer des roles différents
    }
}
