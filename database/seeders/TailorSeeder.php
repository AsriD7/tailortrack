<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Portfolio;
use App\Models\TailorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TailorSeeder extends Seeder
{
    /**
     * Buat akun penjahit dummy beserta profil dan portfolio.
     */
    public function run(): void
    {
        $tailors = [
            [
                'user' => [
                    'name'     => 'Lina Tailor',
                    'email'    => 'lina@tailortrack.com',
                    'password' => Hash::make('password'),
                    'role'     => UserRole::Tailor,
                    'phone'    => '081111111111',
                    'address'  => 'Jl. Kembang No. 5, Yogyakarta',
                ],
                'profile' => [
                    'shop_name'        => 'Lina Tailor',
                    'specialization'   => 'Kebaya & Batik',
                    'description'      => 'Penjahit profesional dengan pengalaman lebih dari 10 tahun dalam membuat kebaya modern dan batik. Mengutamakan kualitas dan ketepatan waktu.',
                    'experience_years' => 10,
                    'is_verified'      => true,
                    'is_available'     => true,
                    'profile_photo'    => 'tailor-profiles/tailor-lina.jpg',
                ],
                'portfolios' => [
                    [
                        'title'       => 'Kebaya Modern Pengantin',
                        'category'    => 'Kebaya',
                        'description' => 'Kebaya modern dengan detail bordir yang elegan untuk acara pernikahan.',
                        'image'       => 'portfolios/portfolio-kebaya-modern.jpg',
                    ],
                    [
                        'title'       => 'Batik Tulis Halus',
                        'category'    => 'Atasan',
                        'description' => 'Kemeja batik tulis premium dengan motif parang.',
                        'image'       => 'portfolios/portfolio-batik-tulis.jpg',
                    ],
                ],
            ],
            [
                'user' => [
                    'name'     => 'Dian Modiste',
                    'email'    => 'dian@tailortrack.com',
                    'password' => Hash::make('password'),
                    'role'     => UserRole::Tailor,
                    'phone'    => '082222222222',
                    'address'  => 'Jl. Pahlawan No. 12, Semarang',
                ],
                'profile' => [
                    'shop_name'        => 'Dian Modiste',
                    'specialization'   => 'Gaun & Dress',
                    'description'      => 'Spesialis pembuatan gaun pesta dan dress formal. Berpengalaman 8 tahun melayani pelanggan di seluruh Jawa Tengah.',
                    'experience_years' => 8,
                    'is_verified'      => true,
                    'is_available'     => true,
                    'profile_photo'    => 'tailor-profiles/tailor-dian.jpg',
                ],
                'portfolios' => [
                    [
                        'title'       => 'Gaun Pesta Malam',
                        'category'    => 'Dress',
                        'description' => 'Gaun malam dengan detail payet dan sifon yang menawan.',
                        'image'       => 'portfolios/portfolio-gaun-pesta.jpg',
                    ],
                    [
                        'title'       => 'Dress Casual Modern',
                        'category'    => 'Terusan',
                        'description' => 'Dress casual bahan linen dengan potongan A-line yang nyaman.',
                        'image'       => 'portfolios/portfolio-dress-casual.jpg',
                    ],
                ],
            ],
            [
                'user' => [
                    'name'     => 'Rapi Jaya Tailor',
                    'email'    => 'rapi@tailortrack.com',
                    'password' => Hash::make('password'),
                    'role'     => UserRole::Tailor,
                    'phone'    => '083333333333',
                    'address'  => 'Jl. Ahmad Yani No. 33, Surabaya',
                ],
                'profile' => [
                    'shop_name'        => 'Rapi Jaya Tailor',
                    'specialization'   => 'Kemeja & Jas',
                    'description'      => 'Penjahit pria berpengalaman dalam pembuatan kemeja, jas, dan setelan formal. Sudah melayani lebih dari 500 pelanggan selama 15 tahun.',
                    'experience_years' => 15,
                    'is_verified'      => true,
                    'is_available'     => true,
                    'profile_photo'    => 'tailor-profiles/tailor-rapi.jpg',
                ],
                'portfolios' => [
                    [
                        'title'       => 'Jas Formal Hitam',
                        'category'    => 'Atasan',
                        'description' => 'Jas formal hitam slim fit untuk acara resmi.',
                        'image'       => 'portfolios/portfolio-jas-formal.jpg',
                    ],
                    [
                        'title'       => 'Kemeja Batik Pria',
                        'category'    => 'Atasan',
                        'description' => 'Kemeja batik pria lengan panjang motif kawung premium.',
                        'image'       => 'portfolios/portfolio-kemeja-batik.jpg',
                    ],
                    [
                        'title'       => 'Setelan Jas Pernikahan',
                        'category'    => 'Atasan',
                        'description' => 'Setelan jas pengantin pria warna abu-abu dengan rompi.',
                        'image'       => 'portfolios/portfolio-setelan-jas.jpg',
                    ],
                ],
            ],
        ];

        foreach ($tailors as $tailorData) {
            // Buat user penjahit
            $user = User::create($tailorData['user']);

            // Buat profil penjahit (sudah termasuk profile_photo)
            TailorProfile::create(array_merge(
                ['user_id' => $user->id],
                $tailorData['profile']
            ));

            // Buat portfolio dengan gambar placeholder
            foreach ($tailorData['portfolios'] as $portfolioData) {
                Portfolio::create(array_merge(
                    [
                        'tailor_id'  => $user->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    $portfolioData
                ));
            }
        }
    }
}
