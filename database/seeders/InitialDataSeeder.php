<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        $adminEmail = 'admin@angkasbacolod.local';
        DB::table('users')->updateOrInsert(
            ['email' => $adminEmail],
            [
                'name' => 'Admin User',
                'email' => $adminEmail,
                'phone' => '09170000001',
                'email_verified_at' => now(),
                'password' => Hash::make('secret123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $adminId = DB::table('users')->where('email', $adminEmail)->value('id');

        // DRIVER
        $driverEmail = 'driver@angkasbacolod.local';
        DB::table('users')->updateOrInsert(
            ['email' => $driverEmail],
            [
                'name' => 'Test Driver',
                'email' => $driverEmail,
                'phone' => '09170000002',
                'email_verified_at' => now(),
                'password' => Hash::make('secret123'),
                'role' => 'driver',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $driverId = DB::table('users')->where('email', $driverEmail)->value('id');

        // RIDER
        $riderEmail = 'rider@angkasbacolod.local';
        DB::table('users')->updateOrInsert(
            ['email' => $riderEmail],
            [
                'name' => 'Test Rider',
                'email' => $riderEmail,
                'phone' => '09170000003',
                'email_verified_at' => now(),
                'password' => Hash::make('secret123'),
                'role' => 'rider',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $riderId = DB::table('users')->where('email', $riderEmail)->value('id');

        // DRIVER PROFILE (for the driver user)
        DB::table('driver_profiles')->updateOrInsert(
            ['user_id' => $driverId],
            [
                'vehicle_type' => 'motorcycle',
                'vehicle_model' => 'Honda Click 125',
                'plate_number' => 'ABC1234',
                'license_number' => 'D1234567',
                'license_expiry_date' => '2027-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // WALLET (for driver)
        DB::table('wallets')->updateOrInsert(
            ['user_id' => $driverId],
            [
                'balance' => 500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // ADMIN SETTINGS (key/value style)
        DB::table('admin_settings')->updateOrInsert(
            ['key' => 'commission_rate'],
            ['value' => '10', 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('admin_settings')->updateOrInsert(
            ['key' => 'min_wallet_balance'],
            ['value' => '100', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
