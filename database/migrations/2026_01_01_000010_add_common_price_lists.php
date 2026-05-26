<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        $now = now();

        $priceLists = [
            [
                'name' => 'Almamater',
                'category' => 'Seragam',
                'description' => 'Jas almamater sekolah, kampus, komunitas, atau organisasi',
                'base_price' => 130000,
            ],
            [
                'name' => 'Seragam',
                'category' => 'Seragam',
                'description' => 'Seragam sekolah, kantor, komunitas, atau organisasi',
                'base_price' => 85000,
            ],
            [
                'name' => 'Batik',
                'category' => 'Atasan',
                'description' => 'Baju batik pria/wanita untuk kerja, acara formal, atau seragam',
                'base_price' => 80000,
            ],
            [
                'name' => 'Baju Pengantin',
                'category' => 'Formal',
                'description' => 'Busana pengantin dan pakaian acara pernikahan',
                'base_price' => 250000,
            ],
            [
                'name' => 'Gaun',
                'category' => 'Terusan',
                'description' => 'Gaun pesta, gaun formal, atau gaun acara khusus',
                'base_price' => 150000,
            ],
        ];

        foreach ($priceLists as $priceList) {
            $exists = DB::table('price_lists')
                ->where('name', $priceList['name'])
                ->exists();

            if (!$exists) {
                DB::table('price_lists')->insert($priceList + [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        DB::table('price_lists')
            ->whereIn('name', ['Almamater', 'Seragam', 'Batik', 'Baju Pengantin', 'Gaun'])
            ->delete();
    }
};
