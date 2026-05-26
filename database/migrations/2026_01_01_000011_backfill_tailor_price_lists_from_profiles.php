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
        $priceLists = DB::table('price_lists')->get(['id', 'name']);
        $profiles = DB::table('tailor_profiles')->get(['user_id', 'specialization', 'description']);
        $now = now();

        foreach ($profiles as $profile) {
            $text = mb_strtolower(trim(($profile->specialization ?? '') . ' ' . ($profile->description ?? '')));

            if ($text === '') {
                continue;
            }

            foreach ($priceLists as $priceList) {
                if (!str_contains($text, mb_strtolower($priceList->name))) {
                    continue;
                }

                $exists = DB::table('tailor_price_lists')
                    ->where('tailor_id', $profile->user_id)
                    ->where('price_list_id', $priceList->id)
                    ->exists();

                if (!$exists) {
                    DB::table('tailor_price_lists')->insert([
                        'tailor_id' => $profile->user_id,
                        'price_list_id' => $priceList->id,
                        'custom_price' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        // Backfill bersifat non-destruktif; pilihan layanan bisa sudah diedit manual.
    }
};
