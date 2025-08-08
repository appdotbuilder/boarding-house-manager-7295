<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'boarding_house_id' => BoardingHouse::factory(),
            'room_number' => fake()->unique()->numberBetween(101, 999),
            'type' => fake()->randomElement(['single', 'double', 'suite', 'dormitory']),
            'price' => fake()->randomFloat(2, 5000, 25000),
            'status' => fake()->randomElement(['occupied', 'vacant', 'maintenance']),
        ];
    }

    /**
     * Indicate that the room is occupied.
     */
    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'occupied',
        ]);
    }

    /**
     * Indicate that the room is vacant.
     */
    public function vacant(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'vacant',
        ]);
    }
}