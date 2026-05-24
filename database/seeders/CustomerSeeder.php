<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Buat akun customer dummy untuk keperluan testing.
     */
    public function run(): void
    {
        $customers = [
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@example.com',
                'password' => Hash::make('password'),
                'role'     => UserRole::Customer,
                'phone'    => '081234567890',
                'address'  => 'Jl. Merdeka No. 10, Jakarta Pusat',
            ],
            [
                'name'     => 'Siti Rahayu',
                'email'    => 'siti@example.com',
                'password' => Hash::make('password'),
                'role'     => UserRole::Customer,
                'phone'    => '082345678901',
                'address'  => 'Jl. Sudirman No. 25, Bandung',
            ],
            [
                'name'     => 'Ahmad Fauzi',
                'email'    => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'role'     => UserRole::Customer,
                'phone'    => '083456789012',
                'address'  => 'Jl. Diponegoro No. 7, Surabaya',
            ],
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }
    }
}
