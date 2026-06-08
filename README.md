# TailorTrack

TailorTrack adalah platform pemesanan jasa jahit berbasis web yang menghubungkan customer dengan penjahit. Aplikasi ini membantu customer mencari penjahit sesuai layanan/keahlian, membuat pesanan, mengunggah referensi desain, memilih ukuran standar atau custom, melakukan pembayaran, memantau status pengerjaan, dan memberi review.

Admin mengelola data utama, penjahit, customer, daftar layanan, pembayaran, order, dan review. Penjahit mengelola profil toko, layanan yang diterima, jadwal, portofolio, serta progres pesanan.

## Tech Stack

- Backend: Laravel
- Frontend: Blade, Tailwind CSS
- Database: MySQL
- Build tool: Vite
- PWA: manifest, service worker, offline page

## Role Pengguna

### Admin

- Dashboard ringkasan platform.
- CRUD akun penjahit.
- Kelola data customer.
- Kelola daftar harga / layanan.
- Publikasi atau sembunyikan profil penjahit.
- Melihat dan membatalkan order jika perlu.
- Verifikasi atau tolak pembayaran.
- Moderasi review.

### Customer

- Register, login, dan edit profil.
- Cari penjahit berdasarkan layanan/keahlian.
- Melihat detail penjahit, rating, jadwal, layanan, dan portofolio.
- Membuat pesanan ke penjahit tertentu.
- Memilih layanan berdasarkan kategori.
- Upload gambar referensi desain.
- Memilih ukuran standar S, M, L, XL, XXL atau Custom.
- Menyimpan profil ukuran badan.
- Upload bukti pembayaran full, DP, atau pelunasan.
- Memantau tracking status order.
- Membatalkan pesanan pada status tertentu.
- Memberikan review setelah pesanan selesai.

### Penjahit

- Dashboard penjahit.
- Edit profil toko.
- Mengatur spesialisasi, deskripsi, foto profil, dan status ketersediaan.
- Memilih layanan yang diterima dari daftar layanan admin.
- Mengatur jadwal kerja, estimasi pengerjaan, batas order aktif, dan batas order mingguan.
- Mengatur tanggal tidak tersedia.
- CRUD portofolio.
- Melihat order masuk.
- Konfirmasi harga final.
- Update progres pengerjaan.
- Menolak pesanan saat masih menunggu konfirmasi.
- Melihat review dari customer.

## Fitur Utama

- Pencarian penjahit.
- Filter layanan/keahlian.
- Layanan order hanya muncul jika dipilih oleh penjahit.
- Pengelompokan layanan berdasarkan kategori.
- Upload referensi desain sampai 5 gambar.
- Sistem ukuran standar dan custom.
- Profil ukuran customer.
- Snapshot ukuran pada order agar data ukuran tidak berubah setelah profil diedit.
- Jadwal dan ketersediaan penjahit.
- Batas order aktif dan mingguan.
- Tanggal tidak tersedia.
- Tracking status order detail.
- Pembayaran full, DP, dan pelunasan.
- Verifikasi pembayaran oleh admin.
- Review dan moderasi review.
- Portofolio penjahit.
- PWA dasar dengan service worker dan halaman offline.

## Alur Order

1. Customer memilih penjahit.
2. Sistem menampilkan layanan yang diterima penjahit.
3. Customer memilih kategori layanan dan jenis layanan.
4. Customer mengisi detail pesanan, ukuran, jumlah, deadline, catatan, dan referensi desain.
5. Order dibuat dengan status `menunggu_konfirmasi`.
6. Penjahit mengonfirmasi harga final.
7. Status berubah menjadi `menunggu_pembayaran`.
8. Customer upload bukti pembayaran full atau DP.
9. Admin memverifikasi pembayaran.
10. Penjahit memproses order.
11. Status bergerak dari `diproses`, `finishing`, `siap_diambil`, sampai `selesai`.
12. Jika ada DP, customer dapat upload pelunasan.
13. Customer memberi review setelah order selesai.

## Status Order

- `menunggu_konfirmasi`
- `menunggu_pembayaran`
- `dibayar`
- `diproses`
- `finishing`
- `siap_diambil`
- `selesai`
- `dibatalkan`

## Status Pembayaran

Jenis pembayaran:

- `full`: pembayaran penuh.
- `dp`: panjar / pembayaran sebagian.
- `pelunasan`: pembayaran sisa setelah DP.

Status pembayaran:

- `pending`: menunggu verifikasi admin.
- `verified`: sudah diverifikasi admin.
- `rejected`: ditolak admin.

## Struktur Database Utama

Tabel utama:

- `users`
- `tailor_profiles`
- `price_lists`
- `tailor_price_lists`
- `portfolios`
- `orders`
- `order_images`
- `payments`
- `tracking_histories`
- `reviews`
- `tailor_unavailable_dates`
- `customer_measurements`

Relasi ringkas:

- `users` 1-1 `tailor_profiles`
- `users` 1-N `orders` sebagai customer
- `users` 1-N `orders` sebagai penjahit
- `users` 1-N `portfolios`
- `users` 1-N `customer_measurements`
- `users` N-M `price_lists` melalui `tailor_price_lists`
- `price_lists` 1-N `orders`
- `orders` 1-N `order_images`
- `orders` 1-N `payments`
- `orders` 1-N `tracking_histories`
- `orders` 1-1 `reviews`
- `users` 1-N `tailor_unavailable_dates`

Dokumentasi konteks lebih lengkap untuk ERD dan laporan tersedia di [gpt.md](gpt.md).

## Instalasi

### Prasyarat

- PHP
- Composer
- Node.js dan npm
- MySQL

### Langkah Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

Jika ingin mengisi data awal:

```bash
php artisan db:seed
```

Jalankan server lokal:

```bash
php artisan serve
```

Jalankan Vite saat development:

```bash
npm run dev
```

## Konfigurasi Penting

Pastikan `.env` menyesuaikan database lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tailorv2
DB_USERNAME=root
DB_PASSWORD=
```

Untuk upload file, jalankan:

```bash
php artisan storage:link
```

## Struktur Folder

```text
app/
  Enums/
  Http/Controllers/
    Admin/
    Auth/
    Customer/
    Public/
    Tailor/
  Models/
database/
  migrations/
  seeders/
public/
  manifest.webmanifest
  sw.js
resources/views/
  admin/
  auth/
  customer/
  layouts/
  public/
  tailor/
routes/
  web.php
```

## Migration

Migration sudah dirapikan agar patch kecil digabung ke migration utama.

Contoh:

- Kolom `payment_type`, `amount`, `bank_name`, `bank_account_number`, dan `bank_account_name` sudah berada di `2026_01_01_000006_create_payments_table.php`.
- Migration tambahan lama untuk menambah tipe pembayaran sudah tidak diperlukan.

## Testing

```bash
php artisan test
```

atau:

```bash
composer test
```

## Roadmap

- Notifikasi in-app/email/push untuk perubahan status order.
- Laporan admin yang lebih detail.
- Chat atau diskusi order antara customer dan penjahit.
- Payment gateway otomatis.
- Dashboard tindakan untuk admin dan penjahit.
- Optimasi PWA dan cache asset dinamis.

## Lisensi

Project ini digunakan untuk pengembangan TailorTrack. Sesuaikan lisensi repository jika akan dipublikasikan.
