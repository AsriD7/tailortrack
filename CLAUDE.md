# TailorTrack - Project Documentation

## Project Overview

**TailorTrack** adalah sebuah aplikasi web marketplace yang menghubungkan customers dengan penjahit (tailors). Platform ini memungkinkan customers untuk melihat profil penjahit, membuat order custom, dan melakukan pembayaran. Penjahit dapat mengelola order, portfolio mereka, dan pricing. Admin memiliki kontrol penuh untuk mengelola semua aspek platform.

**Tech Stack:**
- Framework: Laravel 13.8
- PHP: 8.3+
- Database: SQLite (bisa disesuaikan)
- Frontend: Blade Templates + Vite

---

## Struktur Direktori

```
tailortrack/
├── app/
│   ├── Enums/                 # Enum untuk tipe data (UserRole, OrderStatus, PaymentStatus)
│   ├── Http/
│   │   └── Controllers/       # Business logic untuk setiap route
│   │       ├── Admin/         # Controller untuk admin panel
│   │       ├── Auth/          # Controller untuk login/register
│   │       ├── Customer/      # Controller untuk customer dashboard
│   │       ├── Public/        # Controller untuk public pages
│   │       └── Tailor/        # Controller untuk tailor dashboard
│   ├── Models/                # Eloquent Models untuk database
│   └── Providers/             # Service providers
├── config/                    # Konfigurasi aplikasi
├── database/
│   ├── migrations/            # Schema database
│   ├── factories/             # Factory untuk testing
│   └── seeders/               # Database seeding
├── resources/
│   └── views/                 # Blade templates
│       ├── auth/              # Halaman login & register
│       ├── admin/             # Template admin panel
│       ├── customer/          # Template customer area
│       ├── tailor/            # Template tailor area
│       ├── public/            # Template public pages
│       └── layouts/           # Layout templates
├── routes/
│   └── web.php                # Routing configuration
├── tests/                     # Unit & Feature tests
└── public/                    # Assets (CSS, JS, images)
```

---

## Data Models

### User
Model utama untuk semua pengguna aplikasi.

**Attributes:**
- `id` - Primary key
- `name` - Nama lengkap
- `email` - Email unik
- `password` - Password terenkripsi
- `role` - Enum: Admin, Tailor, Customer
- `phone` - Nomor telepon
- `address` - Alamat

**Relations:**
- `tailorProfile()` - Satu profil tailor jika user adalah tailor
- `customerOrders()` - Banyak order sebagai customer
- `tailorOrders()` - Banyak order sebagai tailor
- `portfolios()` - Banyak portfolio
- `trackingHistories()` - Riwayat tracking

---

### TailorProfile
Profil dan toko dari seorang penjahit.

**Key Attributes:**
- `user_id` - FK ke User
- `shop_name` - Nama toko
- `bio` - Deskripsi
- `specialization` - Spesialisasi (e.g., "Baju Rias", "Pakaian Pria")
- `is_verified` - Status verifikasi oleh admin
- `rating` - Rating dari customers
- `experience_years` - Tahun pengalaman

**Relations:**
- `user()` - Relasi ke User
- `portfolios()` - Banyak portfolio
- `orders()` - Banyak order
- `priceLists()` - Banyak daftar harga

---

### Order
Order yang dibuat customer untuk tailor.

**Key Attributes:**
- `customer_id` - FK ke customer (User)
- `tailor_id` - FK ke tailor (User)
- `description` - Deskripsi order
- `status` - Enum: Pending, Confirmed, In Progress, Completed, Cancelled
- `price_quoted` - Harga yang dikutip penjahit
- `price_confirmed` - Harga yang dikonfirmasi customer
- `estimated_completion` - Estimasi selesai
- `completion_date` - Tanggal selesai aktual

**Relations:**
- `customer()` - Relasi ke User (customer)
- `tailor()` - Relasi ke User (tailor)
- `orderImages()` - Banyak gambar order
- `payments()` - Banyak payment
- `trackingHistories()` - Riwayat tracking order

---

### Payment
Pembayaran untuk order.

**Key Attributes:**
- `order_id` - FK ke Order
- `amount` - Jumlah pembayaran
- `status` - Enum: Pending, Verified, Rejected
- `payment_method` - Metode pembayaran
- `proof_image` - Bukti pembayaran (foto)
- `verified_at` - Waktu diverifikasi

**Relations:**
- `order()` - Relasi ke Order

---

### Portfolio
Portfolio/showcase dari work penjahit.

**Key Attributes:**
- `tailor_id` - FK ke Tailor (User)
- `title` - Judul portfolio
- `description` - Deskripsi
- `image_path` - Path gambar portfolio

**Relations:**
- `tailor()` - Relasi ke User

---

### PriceList
Daftar harga dari penjahit atau admin.

**Key Attributes:**
- `tailor_id` - FK ke Tailor (bisa NULL untuk daftar harga global admin)
- `title` - Judul (e.g., "Baju Rias Wanita")
- `description` - Deskripsi
- `price` - Harga

---

### OrderImage
Gambar untuk order (dari customer).

**Key Attributes:**
- `order_id` - FK ke Order
- `image_path` - Path gambar
- `description` - Deskripsi gambar

---

### TrackingHistory
Riwayat status update order.

**Key Attributes:**
- `order_id` - FK ke Order
- `status` - Status baru
- `description` - Deskripsi perubahan
- `updated_by` - User yang update (FK ke User)
- `updated_at` - Waktu update

---

## User Roles & Permissions

### Admin
Pengguna dengan akses penuh ke sistem.

**Routes:** `/admin/*`
**Permissions:**
- Manage tailors (CRUD + verify)
- View all orders & payments
- Manage price lists
- View all customers
- Accept/reject payments
- View statistics & reports

---

### Tailor (Penjahit)
Penjahit yang menawarkan layanan.

**Routes:** `/tailor/*`
**Permissions:**
- Edit profil & toko
- Manage portfolio
- View orders yang masuk
- Confirm/reject order price
- Update order status
- Cancel order
- View payments

---

### Customer
Pengguna yang mencari layanan jahit.

**Routes:** `/customer/*`
**Permissions:**
- View tailor profiles
- Create order
- View own orders
- Make payment
- Track order progress

---

### Public User (Tidak login)
Dapat mengakses:
- Landing page
- Daftar tailors
- Profil tailor
- Daftar harga publik

---

## Authentication & Authorization

**File:** `app/Http/Controllers/Auth/AuthController.php`

**Features:**
- Login/Register
- Role-based access control
- Middleware checks:
  - `auth` - Harus login
  - `guest` - Harus tidak login
  - `admin` - Harus role Admin
  - `customer` - Harus role Customer
  - `tailor` - Harus role Tailor

---

## Route Structure

### Public Routes
```
GET  /                           # Landing page
GET  /tailors                    # Daftar tailors
GET  /tailors/{tailor}           # Detail tailor
GET  /price-lists                # Daftar harga publik
```

### Auth Routes
```
GET  /login                      # Form login
POST /login                      # Process login
GET  /register                   # Form register
POST /register                   # Process register
POST /logout                     # Logout
```

### Customer Routes (prefix: `/customer`)
```
GET  /dashboard                  # Dashboard customer
GET  /orders                     # Daftar order customer
GET  /tailors/{tailor}/orders/create   # Form buat order
POST /orders                     # Simpan order
GET  /orders/{order}             # Detail order
PATCH /orders/{order}/cancel     # Cancel order
POST /orders/{order}/payment     # Submit payment
```

### Tailor Routes (prefix: `/tailor`)
```
GET  /dashboard                  # Dashboard tailor
GET  /profile/edit               # Form edit profil
PUT  /profile                    # Simpan profil
GET  /portfolios                 # Daftar portfolio
POST /portfolios                 # Tambah portfolio
GET  /portfolios/{portfolio}/edit # Edit portfolio
DELETE /portfolios/{portfolio}    # Hapus portfolio
GET  /orders                     # Daftar order
GET  /orders/{order}             # Detail order
PATCH /orders/{order}/confirm-price    # Confirm harga
PATCH /orders/{order}/status     # Update status
PATCH /orders/{order}/cancel     # Cancel order
```

### Admin Routes (prefix: `/admin`)
```
GET  /dashboard                  # Dashboard admin
GET  /tailors                    # Daftar tailors
GET  /tailors/{tailor}           # Detail tailor
POST /tailors                    # Tambah tailor
PATCH /tailors/{tailor}/verify   # Verify tailor
GET  /price-lists                # Daftar harga
POST /price-lists                # Tambah harga
DELETE /price-lists/{priceList}  # Hapus harga
GET  /users                      # Daftar customers
DELETE /users/{user}             # Hapus customer
GET  /orders                     # Daftar semua orders
GET  /orders/{order}             # Detail order
PATCH /orders/{order}/cancel     # Cancel order
GET  /payments                   # Daftar payments
PATCH /payments/{payment}/verify # Verify payment
PATCH /payments/{payment}/reject # Reject payment
```

---

## Enums

### UserRole
```php
enum UserRole {
    case Admin;      // Administrator
    case Tailor;     // Penjahit
    case Customer;   // Pelanggan
}
```

### OrderStatus
```php
enum OrderStatus {
    case Pending;        // Menunggu konfirmasi harga
    case Confirmed;      // Harga dikonfirmasi, menunggu payment
    case InProgress;     // Sedang dikerjakan
    case Completed;      // Selesai
    case Cancelled;      // Dibatalkan
}
```

### PaymentStatus
```php
enum PaymentStatus {
    case Pending;    // Menunggu verifikasi
    case Verified;   // Terverifikasi
    case Rejected;   // Ditolak
}
```

---

## Views Structure

### Public Views
- `public/landing.blade.php` - Halaman utama
- `public/tailors/index.blade.php` - Daftar tailors
- `public/tailors/show.blade.php` - Detail tailor
- `public/price-lists/index.blade.php` - Daftar harga publik

### Auth Views
- `auth/login.blade.php` - Form login
- `auth/register.blade.php` - Form register

### Customer Views
- `customer/dashboard.blade.php` - Dashboard
- `customer/orders/index.blade.php` - Daftar orders
- `customer/orders/create.blade.php` - Form buat order
- `customer/orders/show.blade.php` - Detail order

### Tailor Views
- `tailor/dashboard.blade.php` - Dashboard
- `tailor/profile/edit.blade.php` - Edit profil
- `tailor/portfolios/` - Portfolio management
- `tailor/orders/` - Order management

### Admin Views
- `admin/dashboard.blade.php` - Dashboard
- `admin/tailors/` - Tailor management
- `admin/price-lists/` - Price list management
- `admin/users/` - Customer management
- `admin/orders/` - Order management
- `admin/payments/` - Payment management

### Layouts
- `layouts/app.blade.php` - Layout untuk authenticated users
- `layouts/customer.blade.php` - Layout khusus customer
- `layouts/admin.blade.php` - Layout khusus admin
- `layouts/tailor.blade.php` - Layout khusus tailor

---

## Key Features

### 1. Order Management
- Customer dapat membuat order dengan detail dan foto
- Tailor dapat confirm/reject order dengan harga
- Status tracking dari pending hingga completed
- Riwayat perubahan status

### 2. Payment System
- Proof of payment via image upload
- Admin verification untuk payment
- Multiple payment methods support

### 3. Portfolio System
- Tailor dapat showcase portfolio
- Customers dapat melihat work samples
- Image upload support

### 4. Rating & Review
- Customers dapat rate penjahit
- Rating calculation dan display

### 5. Price List Management
- Tailor bisa set custom price list
- Admin bisa manage global price list
- Flexible pricing untuk setiap layanan

---

## Setup & Running

### Installation
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Build assets
npm run build
```

### Development
```bash
npm run dev  # atau
composer run dev  # untuk menjalankan dev server + queue + logs + vite
```

### Testing
```bash
composer test
```

---

## Environment Setup

Key `.env` variables:
```
APP_NAME=TailorTrack
APP_URL=http://localhost:8000
DB_DATABASE=tailortrack
DB_CONNECTION=sqlite
```

---

## Important Notes

1. **Email Verification** - Belum diimplementasikan, bisa ditambahkan
2. **Payment Gateway** - Saat ini manual upload bukti, bisa diintegrasikan dengan Midtrans/Payment gateway lain
3. **Image Storage** - Menggunakan local storage, bisa migrasi ke S3
4. **Notifications** - Bisa ditambahkan untuk order status updates
5. **API** - Belum ada API, hanya web routes

---

## Git Workflow

**Branch:** `main`
**Modified files status** - Lihat git status untuk perubahan terbaru

---

Dokumentasi lengkap dapat diakses di https://laravel.com/docs
