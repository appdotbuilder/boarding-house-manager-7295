<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomAssignment>
 */
class RoomAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkInDate = fake()->dateTimeBetween('-1 year', 'now');
        
        return [
            'tenant_id' => Tenant::factory(),
            'room_id' => Room::factory(),
            'check_in_date' => $checkInDate,
            'check_out_date' => null,
            'monthly_rate' => fake()->randomFloat(2, 5000, 25000),
            'is_active' => true,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the assignment is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'check_out_date' => fake()->dateTimeBetween($attributes['check_in_date'], 'now'),
        ]);
    }
}