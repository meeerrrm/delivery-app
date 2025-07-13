<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DummyCustomerData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);

        // Buat 5 User + Customer
        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@example.com",
                'password' => Hash::make('password'), // default password
                'phone_number' => '0812' . rand(1000000, 9999999),
            ]);

            $user->assignRole($customerRole);

            Customer::create([
                'company_name' => "PT Customer {$i}",
                'company_contacts' => json_encode([
                    [
                        'name' => "Kontak {$i}A",
                        'position' => 'Manager',
                        'phone' => '0813' . rand(1000000, 9999999)
                    ],
                    [
                        'name' => "Kontak {$i}B",
                        'position' => 'Supervisor',
                        'phone' => '0814' . rand(1000000, 9999999)
                    ]
                ]),
                'company_address' => "Jl. Raya Nomor {$i}, Jakarta",
                'industry' => 'Manufaktur',
                'logo' => null, // default logo null
                'user_id' => $user->id,
            ]);
        }
    }
}
