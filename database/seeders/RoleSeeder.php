<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Role::create(['name' => 'Driver']);


        $user = User::create([
            'name' => "Mohammad Entol",
            'email' => "sa@cisha.id",
            'password' => Hash::make('password'),
            'phone_number' => '0813 2308 6509',
        ]);
        $user->assignRole('Super Admin');
    }
}
