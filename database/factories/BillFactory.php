<?php

namespace Database\Factories;

use App\Models\RoomAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $billingStart = fake()->dateTimeBetween('-6 months', 'now');
        $billingEnd = (clone $billingStart)->modify('+1 month');
        $dueDate = (clone $billingEnd)->modify('+15 days');
        
        return [
            'room_assignment_id' => RoomAssignment::factory(),
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'billing_period_start' => $billingStart,
            'billing_period_end' => $billingEnd,
            'amount' => fake()->randomFloat(2, 5000, 25000),
            'utilities' => fake()->randomFloat(2, 500, 3000),
            'other_charges' => fake()->randomFloat(2, 0, 1000),
            'due_date' => $dueDate,
            'status' => fake()->randomElement(['pending', 'paid', 'overdue']),
            'payment_date' => fake()->optional(0.6)->dateTimeBetween($billingEnd, 'now'),
            'payment_method' => fake()->optional()->randomElement(['cash', 'bank_transfer', 'check', 'online']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the bill is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'payment_date' => fake()->dateTimeBetween($attributes['billing_period_end'], 'now'),
            'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'check', 'online']),
        ]);
    }

    /**
     * Indicate that the bill is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_date' => null,
            'payment_method' => null,
        ]);
    }
}