<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin utama sistem.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin TailorTrack',
            'email'    => 'admin@tailortrack.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
            'phone'    => '08100000000',
            'address'  => 'Kantor Pusat TailorTrack',
        ]);
    }
}
