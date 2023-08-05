<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
             'name' => $this->faker->name(),
             'company_id' => $this->faker->numberBetween(1, 10),
             'description' => $this->faker->text(),
             'image' => $this->faker->url(),
             'average_rate' => $this->faker->randomFloat(2, 0, 5),
         ];
    }
}
