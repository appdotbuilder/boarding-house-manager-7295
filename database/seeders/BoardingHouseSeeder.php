<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardingHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create boarding houses
        $boardingHouses = BoardingHouse::factory(3)->create();

        foreach ($boardingHouses as $boardingHouse) {
            // Create rooms for each boarding house
            $rooms = Room::factory(random_int(8, 15))->create([
                'boarding_house_id' => $boardingHouse->id,
            ]);

            // Create tenants
            $tenants = Tenant::factory(random_int(5, 12))->create();

            // Assign some tenants to rooms
            $occupiedRooms = $rooms->random(random_int(3, min(8, $rooms->count())));
            
            foreach ($occupiedRooms as $index => $room) {
                if ($index < $tenants->count()) {
                    // Update room status to occupied
                    $room->update(['status' => 'occupied']);

                    // Create room assignment
                    $assignment = RoomAssignment::factory()->create([
                        'tenant_id' => $tenants[$index]->id,
                        'room_id' => $room->id,
                        'monthly_rate' => $room->price,
                        'check_in_date' => fake()->dateTimeBetween('-6 months', '-1 month'),
                    ]);

                    // Create bills for the assignment
                    Bill::factory(random_int(2, 6))->create([
                        'room_assignment_id' => $assignment->id,
                    ]);

                    // Create some paid bills
                    Bill::factory(random_int(1, 3))->paid()->create([
                        'room_assignment_id' => $assignment->id,
                    ]);
                }
            }
        }
    }
}