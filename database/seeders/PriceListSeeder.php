<?php

namespace Database\Seeders;

use App\Models\PriceList;
use Illuminate\Database\Seeder;

class PriceListSeeder extends Seeder
{
    /**
     * Buat daftar harga layanan jahit.
     */
    public function run(): void
    {
        $priceLists = [
            [
                'name'        => 'Kemeja',
                'category'    => 'Atasan',
                'description' => 'Kemeja pria/wanita berbagai bahan (katun, oxford, flannel)',
                'base_price'  => 45000,
            ],
            [
                'name'        => 'Celana Bahan',
                'category'    => 'Bawahan',
                'description' => 'Celana formal pria/wanita berbahan dasar kain wol atau katun',
                'base_price'  => 70000,
            ],
            [
                'name'        => 'Dress',
                'category'    => 'Terusan',
                'description' => 'Dress kasual atau semi formal wanita',
                'base_price'  => 75000,
            ],
            [
                'name'        => 'Permak Celana',
                'category'    => 'Perbaikan',
                'description' => 'Permak / ubah ukuran celana (kecilkan, panjangkan, dll)',
                'base_price'  => 25000,
            ],
            [
                'name'        => 'Ganti Resleting',
                'category'    => 'Perbaikan',
                'description' => 'Ganti resleting celana, rok, jaket, atau tas',
                'base_price'  => 30000,
            ],
            [
                'name'        => 'Kebaya',
                'category'    => 'Atasan',
                'description' => 'Kebaya tradisional atau modern untuk acara formal dan pernikahan',
                'base_price'  => 120000,
            ],
            [
                'name'        => 'Jas',
                'category'    => 'Atasan',
                'description' => 'Jas formal pria untuk acara resmi, meeting, atau pernikahan',
                'base_price'  => 150000,
            ],
            [
                'name'        => 'Gamis',
                'category'    => 'Terusan',
                'description' => 'Gamis wanita berbahan jersey, katun, atau sutra',
                'base_price'  => 90000,
            ],
            [
                'name'        => 'Almamater',
                'category'    => 'Seragam',
                'description' => 'Jas almamater sekolah, kampus, komunitas, atau organisasi',
                'base_price'  => 130000,
            ],
            [
                'name'        => 'Seragam',
                'category'    => 'Seragam',
                'description' => 'Seragam sekolah, kantor, komunitas, atau organisasi',
                'base_price'  => 85000,
            ],
            [
                'name'        => 'Batik',
                'category'    => 'Atasan',
                'description' => 'Baju batik pria/wanita untuk kerja, acara formal, atau seragam',
                'base_price'  => 80000,
            ],
            [
                'name'        => 'Baju Pengantin',
                'category'    => 'Formal',
                'description' => 'Busana pengantin dan pakaian acara pernikahan',
                'base_price'  => 250000,
            ],
            [
                'name'        => 'Gaun',
                'category'    => 'Terusan',
                'description' => 'Gaun pesta, gaun formal, atau gaun acara khusus',
                'base_price'  => 150000,
            ],
        ];

        foreach ($priceLists as $priceList) {
            PriceList::updateOrCreate(
                ['name' => $priceList['name']],
                $priceList
            );
        }
    }
}
