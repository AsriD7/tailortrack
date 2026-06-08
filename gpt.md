# TailorTrack - Konteks Sistem untuk AI Agent

Dokumen ini berisi ringkasan website TailorTrack agar AI agent lain dapat membantu membuat ERD, laporan, BAB analisis, dokumentasi, atau presentasi tanpa harus membaca seluruh source code.

## Identitas Aplikasi

Nama aplikasi: TailorTrack

Jenis aplikasi: platform pemesanan jasa jahit berbasis web.

Framework: Laravel dengan Blade template.

Tujuan utama: mempertemukan customer dengan penjahit, memudahkan customer mencari layanan jahit, membuat pesanan, upload referensi desain, memilih ukuran, melakukan pembayaran, memantau status pengerjaan, dan memberi review. Admin mengelola data utama, memverifikasi pembayaran, dan memoderasi review. Penjahit mengelola profil toko, layanan, portofolio, jadwal, dan pesanan masuk.

Konvensi tampilan nama penjahit: jika `tailor_profiles.shop_name` tersedia, gunakan nama toko sebagai identitas utama. Nama user penjahit (`users.name`) digunakan sebagai pendamping dengan format "oleh Nama Penjahit" atau sebagai fallback jika nama toko tidak tersedia.

## Aktor / Role

1. Admin
   - Membuat dan mengelola akun penjahit.
   - Mengelola data customer.
   - Mengelola daftar harga / layanan umum.
   - Mengelola publikasi/verifikasi profil penjahit.
   - Melihat semua pesanan.
   - Memverifikasi atau menolak pembayaran.
   - Memoderasi review.

2. Customer
   - Registrasi dan login.
   - Melihat daftar penjahit.
   - Mencari penjahit berdasarkan layanan/keahlian.
   - Melihat detail penjahit dan portofolio.
   - Membuat pesanan jahit.
   - Upload gambar referensi desain.
   - Memilih ukuran standar atau custom.
   - Menyimpan profil ukuran badan.
   - Upload bukti pembayaran.
   - Melihat tracking status pesanan.
   - Membatalkan pesanan pada status tertentu.
   - Memberikan review setelah pesanan selesai.

3. Penjahit
   - Login menggunakan akun yang dibuat admin.
   - Mengelola profil toko.
   - Mengatur spesialisasi, deskripsi, foto profil, layanan yang diterima, jadwal kerja, estimasi pengerjaan, batas order, dan tanggal tidak tersedia.
   - Mengelola portofolio hasil jahitan.
   - Melihat pesanan masuk.
   - Mengonfirmasi harga.
   - Mengubah status pengerjaan.
   - Memberi catatan progres kepada customer.
   - Menolak pesanan pada status menunggu konfirmasi.
   - Melihat review yang diterima.

## Fitur Utama

### Public

- Landing page.
- Daftar penjahit.
- Detail penjahit.
- Daftar harga / layanan.
- Daftar portofolio publik.
- Detail portofolio publik.
- PWA dasar dengan manifest, service worker, cache aset statis, dan halaman offline.

### Authentication

- Login.
- Register customer.
- Logout.
- Role-based middleware: admin, tailor, customer.

### Customer

- Dashboard customer.
- Edit profil customer.
- Kelola profil ukuran badan.
- Buat pesanan ke penjahit tertentu.
- Pilihan layanan hanya menampilkan layanan yang dipilih oleh penjahit.
- Layanan pada form order dikelompokkan berdasarkan kategori.
- Pilihan ukuran:
  - Standar: S, M, L, XL, XXL.
  - Custom: menggunakan profil ukuran tersimpan atau input manual.
- Detail ukuran disimpan sebagai snapshot di order agar tidak berubah walaupun profil ukuran diedit.
- Upload maksimal 5 gambar referensi desain.
- Melihat detail pesanan, progres status, catatan penjahit, pembayaran, dan review.
- Upload bukti pembayaran full, DP, atau pelunasan.
- Membatalkan pesanan jika masih menunggu konfirmasi atau menunggu pembayaran.
- Memberikan review saat pesanan selesai.

### Penjahit

- Dashboard penjahit.
- Edit profil toko.
- Mengatur layanan yang diterima dari daftar harga admin.
- Mengatur custom price per layanan melalui pivot `tailor_price_lists`.
- Mengatur hari kerja, estimasi pengerjaan, batas order aktif, batas order mingguan.
- Mengatur tanggal tidak tersedia.
- CRUD portofolio.
- Melihat detail pesanan masuk.
- Konfirmasi harga pesanan.
- Update status pengerjaan.
- Menolak pesanan.
- Melihat review.

### Admin

- Dashboard admin.
- CRUD penjahit.
- Publikasi/verifikasi profil penjahit.
- CRUD daftar harga / layanan.
- Kelola customer.
- Melihat semua order.
- Membatalkan order jika perlu.
- Kelola pembayaran.
- Verifikasi / tolak pembayaran.
- Moderasi review.

## Status Pesanan

Enum status order:

1. `menunggu_konfirmasi`
   - Pesanan baru dibuat customer dan menunggu konfirmasi penjahit.

2. `menunggu_pembayaran`
   - Penjahit sudah mengonfirmasi harga final, customer perlu upload pembayaran.

3. `dibayar`
   - Pembayaran sudah diverifikasi admin.

4. `diproses`
   - Pesanan mulai diproses oleh penjahit.

5. `finishing`
   - Jahitan utama selesai dan masuk tahap finishing.

6. `siap_diambil`
   - Pesanan siap diambil atau dikirim ke customer.

7. `selesai`
   - Pesanan selesai.

8. `dibatalkan`
   - Pesanan dibatalkan.

Aturan pembatalan:

- Customer dapat membatalkan saat `menunggu_konfirmasi` dan `menunggu_pembayaran`.
- Penjahit dapat membatalkan saat `menunggu_konfirmasi`.
- Admin dapat membatalkan selama belum selesai/dibatalkan.

## Status Pembayaran

Enum status pembayaran:

1. `pending`
   - Bukti pembayaran sudah diupload customer dan menunggu verifikasi admin.

2. `verified`
   - Pembayaran sudah diverifikasi admin.

3. `rejected`
   - Pembayaran ditolak admin, biasanya karena bukti tidak valid atau nominal tidak sesuai.

Jenis pembayaran:

- `full`: pembayaran penuh.
- `dp`: pembayaran panjar / sebagian.
- `pelunasan`: pembayaran sisa setelah DP.

## Alur Bisnis Utama

### Alur Pemesanan

1. Customer login.
2. Customer mencari dan memilih penjahit.
3. Sistem menampilkan layanan yang benar-benar diterima penjahit.
4. Customer memilih kategori layanan.
5. Customer memilih layanan / jenis pakaian.
6. Customer memilih ukuran:
   - standar S sampai XXL, atau
   - custom dengan profil ukuran/manual.
7. Customer mengisi deskripsi, jumlah, deadline, catatan, dan upload referensi desain.
8. Sistem menghitung estimasi harga awal berdasarkan harga layanan, surcharge ukuran, dan jumlah.
9. Order dibuat dengan status `menunggu_konfirmasi`.
10. Sistem membuat tracking history awal.

### Alur Konfirmasi Harga

1. Penjahit melihat order masuk.
2. Penjahit mengonfirmasi harga final dan dapat memberi catatan.
3. Status order berubah menjadi `menunggu_pembayaran`.
4. Customer melihat total harga final dan catatan penjahit.

### Alur Pembayaran

1. Customer upload bukti pembayaran.
2. Jenis pembayaran:
   - `full`: bayar penuh.
   - `dp`: bayar sebagian / panjar.
   - `pelunasan`: pembayaran sisa setelah DP.
3. Pembayaran masuk status `pending`.
4. Admin memverifikasi atau menolak pembayaran.
5. Jika pembayaran valid, status pembayaran menjadi `verified`.
6. Jika pembayaran full atau DP diverifikasi, order dapat masuk proses pengerjaan sesuai aturan aplikasi.
7. Jika pesanan memakai DP, customer dapat upload pelunasan setelah tahap tertentu/ketika sisa pembayaran diperlukan.

### Alur Pengerjaan

1. Setelah pembayaran diverifikasi, penjahit mulai proses.
2. Penjahit mengubah status:
   - `diproses`
   - `finishing`
   - `siap_diambil`
   - `selesai`
3. Setiap perubahan status disimpan di tracking history.
4. Customer dapat melihat progres dan catatan penjahit.

### Alur Review

1. Pesanan harus berstatus `selesai`.
2. Customer memberi rating 1 sampai 5 dan komentar opsional.
3. Review tersimpan ke order, customer, dan penjahit.
4. Admin dapat menghapus review jika perlu moderasi.

## Tabel Database Penting

### users

Menyimpan akun semua role.

Kolom utama:

- `id`
- `name`
- `email`
- `password`
- `role`: enum `admin`, `tailor`, `customer`
- `phone`
- `address`
- `remember_token`
- `created_at`
- `updated_at`

Relasi:

- User role tailor memiliki satu `tailor_profiles`.
- User role customer memiliki banyak `orders` sebagai customer.
- User role tailor memiliki banyak `orders` sebagai tailor.
- User role tailor memiliki banyak `portfolios`.
- User role customer memiliki banyak `customer_measurements`.
- User dapat menjadi pembuat tracking history.
- User customer dapat memberi review.
- User tailor dapat menerima review.

### tailor_profiles

Profil toko penjahit.

Kolom:

- `id`
- `user_id` FK ke `users.id`
- `shop_name`
- `specialization`
- `description`
- `experience_years`
- `profile_photo`
- `is_verified`: default true, digunakan sebagai publikasi/verifikasi tampil.
- `is_available`
- `max_active_orders`
- `max_weekly_orders`
- `estimated_processing_days`
- `working_days`: JSON
- `created_at`
- `updated_at`

Relasi:

- Banyak `tailor_profiles` tidak mungkin untuk satu user. Satu penjahit punya satu profil.
- `tailor_profiles.user_id` belongs to `users.id`.

### price_lists

Master daftar layanan/harga dari admin.

Kolom:

- `id`
- `name`
- `category`
- `description`
- `base_price`
- `created_at`
- `updated_at`

Contoh kategori: Atasan, Bawahan, Dress, Seragam, Perbaikan, dan sejenisnya.

Relasi:

- Banyak price list dapat dipilih banyak penjahit melalui `tailor_price_lists`.
- Satu price list dapat digunakan banyak order.

### tailor_price_lists

Pivot layanan yang diterima penjahit.

Kolom:

- `id`
- `tailor_id` FK ke `users.id`
- `price_list_id` FK ke `price_lists.id`
- `custom_price`
- `created_at`
- `updated_at`

Constraint:

- Unique gabungan `tailor_id` dan `price_list_id`.

Makna:

- Jika penjahit hanya memilih layanan tertentu, customer hanya dapat membuat order dari layanan tersebut.
- `custom_price` dapat menjadi harga khusus penjahit untuk layanan tertentu.

### portfolios

Portofolio hasil jahitan penjahit.

Kolom:

- `id`
- `tailor_id` FK ke `users.id`
- `title`
- `category`
- `client_type`
- `price_range`
- `completed_at`
- `is_featured`
- `image`
- `description`
- `created_at`
- `updated_at`

Relasi:

- Satu penjahit memiliki banyak portofolio.

### orders

Data utama pesanan jahit.

Kolom:

- `id`
- `customer_id` FK ke `users.id`
- `tailor_id` FK ke `users.id`
- `price_list_id` FK ke `price_lists.id`, nullable
- `order_code`: unique
- `category`
- `item_name`
- `description`
- `size`: enum `S`, `M`, `L`, `XL`, `XXL`, `Custom`
- `measurement_snapshot`: JSON
- `quantity`
- `estimated_price`
- `total_price`
- `status`: enum status order
- `deadline`
- `note`
- `cancelled_by` FK ke `users.id`, nullable
- `cancel_reason`
- `cancelled_at`
- `created_at`
- `updated_at`

Makna penting:

- `estimated_price` adalah estimasi awal.
- `total_price` adalah harga final setelah dikonfirmasi penjahit.
- `measurement_snapshot` menyimpan detail ukuran saat order dibuat.
- `order_code` memakai format seperti `TT-YYYYMMDD-XXXX`.

Relasi:

- Satu order dimiliki satu customer.
- Satu order diterima satu penjahit.
- Satu order memakai satu layanan price list.
- Satu order memiliki banyak gambar referensi.
- Satu order memiliki banyak pembayaran.
- Satu order memiliki banyak tracking history.
- Satu order memiliki satu review.

### order_images

Gambar referensi desain untuk order.

Kolom:

- `id`
- `order_id` FK ke `orders.id`
- `image`
- `created_at`

Relasi:

- Satu order dapat memiliki banyak gambar referensi.

### payments

Pembayaran order.

Kolom:

- `id`
- `order_id` FK ke `orders.id`
- `payment_type`: enum `full`, `dp`, `pelunasan`
- `amount`
- `bank_name`
- `bank_account_number`
- `bank_account_name`
- `payment_proof`
- `payment_date`
- `status`: enum `pending`, `verified`, `rejected`
- `created_at`
- `updated_at`

Makna:

- `full` untuk pembayaran penuh.
- `dp` untuk panjar.
- `pelunasan` untuk pembayaran sisa setelah DP.
- Admin memverifikasi pembayaran.

Relasi:

- Satu order dapat memiliki banyak pembayaran, terutama jika memakai DP dan pelunasan.

Catatan migration:

- Kolom `payment_type`, `amount`, `bank_name`, `bank_account_number`, dan `bank_account_name` sudah berada langsung di migration utama `2026_01_01_000006_create_payments_table.php`.
- Migration patch lama untuk menambah `payment_type`, `amount`, dan enum `pelunasan` sudah tidak diperlukan lagi.

### tracking_histories

Riwayat perubahan status order.

Kolom:

- `id`
- `order_id` FK ke `orders.id`
- `updated_by` FK ke `users.id`, nullable
- `status`
- `description`
- `created_at`

Relasi:

- Satu order memiliki banyak tracking history.
- Satu tracking dapat dibuat oleh user tertentu.

### reviews

Review customer untuk penjahit setelah order selesai.

Kolom:

- `id`
- `order_id` FK ke `orders.id`, unique
- `customer_id` FK ke `users.id`
- `tailor_id` FK ke `users.id`
- `rating`: 1 sampai 5
- `comment`
- `created_at`
- `updated_at`

Relasi:

- Satu order hanya memiliki satu review.
- Satu customer dapat memberi banyak review.
- Satu penjahit dapat menerima banyak review.

### tailor_unavailable_dates

Tanggal saat penjahit tidak tersedia.

Kolom:

- `id`
- `tailor_id` FK ke `users.id`
- `date`
- `reason`
- `created_at`
- `updated_at`

Constraint:

- Unique gabungan `tailor_id` dan `date`.

Makna:

- Digunakan untuk mencegah customer memilih deadline pada tanggal penjahit tidak tersedia.

### customer_measurements

Profil ukuran badan customer.

Kolom:

- `id`
- `customer_id` FK ke `users.id`
- `label`
- `gender`
- `height_cm`
- `weight_kg`
- `chest_cm`
- `waist_cm`
- `hip_cm`
- `shoulder_cm`
- `sleeve_length_cm`
- `shirt_length_cm`
- `pants_length_cm`
- `thigh_cm`
- `notes`
- `created_at`
- `updated_at`

Makna:

- Customer dapat menyimpan banyak profil ukuran.
- Saat order custom, data profil ukuran disalin ke `orders.measurement_snapshot`.

## Relasi ERD Ringkas

Gunakan daftar ini untuk menggambar ERD:

- `users.id` 1 - 1 `tailor_profiles.user_id`
- `users.id` 1 - N `orders.customer_id`
- `users.id` 1 - N `orders.tailor_id`
- `price_lists.id` 1 - N `orders.price_list_id`
- `orders.id` 1 - N `order_images.order_id`
- `orders.id` 1 - N `payments.order_id`
- `orders.id` 1 - N `tracking_histories.order_id`
- `users.id` 1 - N `tracking_histories.updated_by`
- `orders.id` 1 - 1 `reviews.order_id`
- `users.id` 1 - N `reviews.customer_id`
- `users.id` 1 - N `reviews.tailor_id`
- `users.id` 1 - N `portfolios.tailor_id`
- `users.id` 1 - N `tailor_unavailable_dates.tailor_id`
- `users.id` 1 - N `customer_measurements.customer_id`
- `users.id` N - M `price_lists.id` melalui `tailor_price_lists`
- `tailor_price_lists.tailor_id` N - 1 `users.id`
- `tailor_price_lists.price_list_id` N - 1 `price_lists.id`

## Kandidat Entitas untuk ERD

Entitas utama:

- User
- TailorProfile
- PriceList
- TailorPriceList
- Portfolio
- Order
- OrderImage
- Payment
- TrackingHistory
- Review
- TailorUnavailableDate
- CustomerMeasurement

Entitas Laravel bawaan yang tidak wajib masuk ERD utama:

- password_reset_tokens
- cache
- cache_locks
- jobs
- job_batches
- failed_jobs

## Use Case Utama

### Admin

- Login.
- Mengelola penjahit.
- Mengelola customer.
- Mengelola layanan.
- Melihat pesanan.
- Verifikasi pembayaran.
- Moderasi review.

### Customer

- Register/login.
- Cari penjahit.
- Lihat detail penjahit.
- Buat pesanan.
- Upload referensi desain.
- Kelola ukuran badan.
- Upload pembayaran.
- Pantau status.
- Beri review.

### Penjahit

- Login.
- Kelola profil toko.
- Kelola layanan dan jadwal.
- Kelola portofolio.
- Konfirmasi pesanan.
- Update status pesanan.
- Lihat review.

## Catatan Analisis Sistem

Masalah yang diselesaikan:

- Customer kesulitan mencari penjahit sesuai layanan tertentu.
- Proses order jahit masih manual dan tidak terdokumentasi.
- Customer tidak mudah memantau status pengerjaan.
- Penjahit sulit mengatur layanan, antrean, dan jadwal.
- Admin perlu kontrol atas data layanan, penjahit, pembayaran, dan review.

Solusi yang diberikan TailorTrack:

- Platform terpusat untuk pencarian penjahit dan pemesanan jasa jahit.
- Penjahit dapat memilih layanan yang diterima, sehingga form order customer relevan.
- Kategori layanan memudahkan customer memilih jenis pakaian.
- Upload referensi desain membantu penjahit memahami permintaan customer.
- Sistem ukuran standar dan custom mengurangi kesalahan pengukuran.
- Tracking status memberikan transparansi progres.
- Pembayaran dengan verifikasi admin meningkatkan kepercayaan.
- Review membantu customer menilai reputasi penjahit.

## Catatan untuk Laporan

Jika membuat laporan, struktur pembahasan yang cocok:

1. Latar belakang
   - Kebutuhan digitalisasi pemesanan jasa jahit.
   - Masalah komunikasi antara customer dan penjahit.
   - Kebutuhan transparansi status, harga, pembayaran, dan review.

2. Rumusan masalah
   - Bagaimana customer dapat mencari penjahit sesuai keahlian?
   - Bagaimana sistem mengelola pesanan jahit dari awal sampai selesai?
   - Bagaimana penjahit mengatur layanan, jadwal, dan antrean?
   - Bagaimana admin mengontrol pembayaran dan review?

3. Tujuan sistem
   - Membuat platform pemesanan jasa jahit.
   - Mempermudah pencarian penjahit.
   - Mempermudah pengelolaan order.
   - Menyediakan tracking status.
   - Menyediakan pembayaran dan review.

4. Batasan sistem
   - Pembayaran masih diverifikasi admin melalui bukti upload, belum payment gateway otomatis.
   - Komunikasi customer-penjahit masih melalui catatan/status, belum chat real-time.
   - Ukuran standar hanya acuan, penjahit tetap perlu menyesuaikan dengan model pakaian.

5. Metode pengembangan
   - Cocok menggunakan metode Waterfall atau Prototype, tergantung kebutuhan laporan.

6. Perancangan
   - Use case diagram berdasarkan tiga aktor: admin, customer, penjahit.
   - Activity diagram untuk pemesanan, pembayaran, dan update status.
   - ERD berdasarkan daftar relasi di dokumen ini.
   - Class diagram dapat mengikuti model Laravel.

## Prompt Singkat untuk Agent AI Lain

Gunakan prompt ini jika ingin meminta AI membuat ERD:

```text
Buatkan ERD untuk aplikasi TailorTrack berdasarkan konteks di gpt.md. Fokus pada entitas users, tailor_profiles, price_lists, tailor_price_lists, portfolios, orders, order_images, payments, tracking_histories, reviews, tailor_unavailable_dates, dan customer_measurements. Sertakan kardinalitas, primary key, foreign key, dan penjelasan singkat tiap relasi.
```

Gunakan prompt ini jika ingin meminta AI membuat laporan:

```text
Buatkan laporan analisis dan perancangan sistem TailorTrack berdasarkan konteks di gpt.md. Susun dengan bagian latar belakang, rumusan masalah, tujuan, batasan masalah, analisis kebutuhan, use case, activity diagram naratif, ERD naratif, rancangan database, dan penutup.
```

Gunakan prompt ini jika ingin meminta AI membuat use case:

```text
Buatkan use case diagram naratif untuk TailorTrack berdasarkan aktor Admin, Customer, dan Penjahit. Gunakan fitur dan alur bisnis yang dijelaskan pada gpt.md.
```
