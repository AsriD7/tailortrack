<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder untuk TailorTrack.
     */
    public function run(): void
    {
        // Urutan penting: Admin → Customer → Tailor → PriceList
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            TailorSeeder::class,
            PriceListSeeder::class,
        ]);
    }
}
