<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DriverData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $customerRole = Role::firstOrCreate(['name' => 'Driver']);

        // Buat 5 User + Customer
        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => "Driver {$i}",
                'email' => "driver{$i}@example.com",
                'password' => Hash::make('password'), // default password
                'phone_number' => '0812' . rand(1000000, 9999999),
            ]);

            $user->assignRole($customerRole);
        }
    }
}
