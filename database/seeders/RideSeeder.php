<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ride;
use App\Models\User;

class RideSeeder extends Seeder
{
    public function run(): void
    {
        $driver = User::where('role', 'driver')->first();
        $rider = User::where('role', 'rider')->first();

        if (!$driver || !$rider) {
            $this->command->warn('No driver or rider found. Please seed users first.');
            return;
        }

        // Create some completed rides with fares
        Ride::factory()->createMany([
            [
                'driver_id' => $driver->id,
                'rider_id' => $rider->id,
                'status' => 'completed',
                'fare' => 150.00,
            ],
            [
                'driver_id' => $driver->id,
                'rider_id' => $rider->id,
                'status' => 'completed',
                'fare' => 200.00,
            ],
        ]);

        // Create some ongoing/pending rides (no earnings yet)
        Ride::factory()->count(4)->create([
            'driver_id' => $driver->id,
            'rider_id' => $rider->id,
            'status' => 'pending',
            'fare' => 0.00,
        ]);
    }
}
