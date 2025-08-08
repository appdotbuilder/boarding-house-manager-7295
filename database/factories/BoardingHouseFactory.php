<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardingHouse>
 */
class BoardingHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Boarding House',
            'address' => fake()->address(),
            'number_of_rooms' => fake()->numberBetween(10, 50),
            'owner' => fake()->name(),
            'contact' => fake()->phoneNumber(),
        ];
    }
}