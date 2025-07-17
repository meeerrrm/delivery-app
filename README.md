
# 📦 Aplikasi Pemesanan Pengiriman

Repositori ini adalah implementasi dari penelitian ilmiah berjudul **"Pembuatan Aplikasi Pemesanan Pengiriman Menggunakan Laravel dan Filament"**. Sistem ini dirancang untuk mengelola pemesanan pengiriman, armada truk, pelanggan, lokasi, dan pelacakan status pengiriman melalui dashboard berbasis web.

---

## 🚀 Tech Stack

| Teknologi | Versi |
|----------|--------|
| PHP      | ^8.2   |
| Laravel  | ^12.0  |
| Filament | ^3.3   |

---

## 📁 Struktur Utama

.
├── app
│   ├── Filament         # Panel Admin (Admin, Customer, Driver)
│   ├── Http\Controllers # Controller Laravel
│   ├── Models           # Model Eloquent (Customer, DO, Truck, dsb)
│   ├── Providers        # Service & Panel Provider
│   └── Support          # Utility seperti StatusColor
├── config
├── database
├── public
├── resources
├── routes
├── storage
├── tests
└── vendor

---

## ✨ Fitur Unggulan

- ✅ Manajemen **Customer**, **Truck**, **Truck Type**, dan **Delivery Order**
- 📦 Pelacakan status pengiriman (log perjalanan)
- 👤 Panel khusus untuk **Admin**, **Customer**, dan **Driver**
- 📊 Statistik dan grafik pengiriman (Filament Widgets)
- 🔐 Hak akses menggunakan **Spatie Laravel Permission**

---

## ⚙️ Instalasi Lokal

### 1. Clone Repository
git clone https://github.com/meeerrrm/delivery-app.git
cd delivery-app

### 2. Install Dependency
composer install
npm install && npm run build

### 3. Setup Environment
cp .env.example .env
php artisan key:generate

### 4. Jalankan Migration
php artisan migrate

### 5. Jalankan Aplikasi
php artisan serve

> Untuk development lengkap (termasuk queue, logs, vite, dsb):
composer dev

---

## 📦 Daftar Dependency Utama

### Production
- filament/filament – UI Admin modern & modular
- spatie/laravel-permission – Role & Permission
- laravel/framework – Framework utama Laravel

### Development
- laravel/pint – Code Style Formatter
- laravel/pail – Realtime Laravel logs
- phpunit/phpunit – Testing
- fakerphp/faker – Seeder & dummy data
- nunomaduro/collision – Output error keren di CLI

---

## 📊 Statistik dan Dashboard

Tiap role memiliki dashboard dan widget masing-masing:
- Widgets\Admin\* – Statistik harian dan jumlah DO
- Widgets\Customer\* – Riwayat pengiriman oleh customer
- Widgets\Driver\* – Riwayat DO dan log status

---

## 🛡️ License

MIT – Silakan gunakan, modifikasi, dan distribusikan.

---

## 👨‍🔬 Catatan Penelitian

Penelitian ini dilakukan sebagai bagian dari pengembangan sistem informasi manajemen pemesanan pengiriman berbasis web. Sistem ini berfokus pada:

- Otomatisasi proses pengiriman
- Pelacakan status perjalanan
- Pemetaan lokasi pengiriman
- Pembagian akses berdasarkan role

---

## 📞 Kontak

Untuk informasi lebih lanjut atau demo:
📧 Email: [your@email.com]
🌐 Website: https://cisha.dev (opsional)
