# OnoPay - Setup & Installation Guide

## 📋 Daftar Isi
1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Database Setup](#database-setup)
4. [Menjalankan Aplikasi](#menjalankan-aplikasi)
5. [Admin Login](#admin-login)
6. [Struktur Project](#struktur-project)
7. [Troubleshooting](#troubleshooting)

---

## Requirements

### System Requirements
- **PHP**: 8.2 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Composer**: Terbaru
- **Node.js**: Optional (untuk assets)

### Cara Cek Versi
```bash
PHP:    php --version
MySQL:  mysql --version
Composer: composer --version
```

---

## Installation

### 1. Navigate ke Project Directory

```bash
cd /Users/rizkimuliono/Library/Mobile\ Documents/com~apple~CloudDocs/PROYEK_WEB/onopay_web
```

### 2. Composer Install

```bash
composer install
```

Jika belum pernah, command ini akan:
- Download semua dependencies
- Generate autoload files
- Create vendor folder

Waktu estimasi: 2-5 menit (tergantung kecepatan internet)

### 3. Generate App Key

```bash
php artisan key:generate
```

Command ini akan:
- Generate APP_KEY yang unik
- Update file `.env` secara otomatis
- APP_KEY digunakan untuk encryption

### 4. Clear Cache (Optional tapi recommended)

```bash
php artisan cache:clear
php artisan config:cache
```

---

## Database Setup

### 1. Create Database

```bash
# Akses MySQL
mysql -u root

# Di MySQL console:
CREATE DATABASE onopay_db;
EXIT;
```

Atau jika database sudah ada dan ingin di-reset:
```bash
# Jalankan di project root
php artisan migrate:refresh --seed
```

### 2. Update `.env` File

Buka `.env` dan pastikan database config:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=onopay_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations

```bash
php artisan migrate
```

Output yang diharapkan:
```
INFO  Running migrations.

  0001_01_01_000000_create_users_table ........................... ✓
  0001_01_01_000001_create_cache_table .......................... ✓
  0001_01_01_000002_create_jobs_table ........................... ✓
  2026_06_02_000001_create_onopay_users_table ................... ✓
  2026_06_02_000002_create_admins_table ......................... ✓
  2026_06_02_000003_create_transactions_table ................... ✓
  2026_06_02_000004_create_qr_codes_table ....................... ✓
  2026_06_02_000005_create_merchants_table ...................... ✓
```

### 4. Run Seeders

```bash
php artisan db:seed
```

Seeders akan membuat:
- **2 Admin users** untuk login
- **5 Test users** dengan saldo
- **50 Sample transactions**
- **10 Sample QR codes**

---

## Menjalankan Aplikasi

### 1. Start Development Server

```bash
php artisan serve
```

Output:
```
   INFO  Server running on [http://127.0.0.1:8000].

  Press Ctrl+C to quit
```

### 2. Akses Aplikasi

Buka browser dan akses:
- **Admin Panel**: http://localhost:8000/login
- **Dashboard**: http://localhost:8000/dashboard
- **API Base**: http://localhost:8000/api/v1

---

## Admin Login

### Default Admin Credentials

```
Email:    admin@onopay.local
Password: password123
```

**Ada 2 admin yang dibuat:**
1. `admin@onopay.local` - Super Admin
2. `support@onopay.local` - Admin Support

---

## Struktur Project

### Project Structure
```
onopay_web/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── MerchantController.php
│   │   │   │   └── PaymentController.php
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   └── TransactionController.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Admin.php
│   │   ├── Transaction.php
│   │   ├── QRCode.php
│   │   └── Merchant.php
│   └── Providers/
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_06_02_000001_create_onopay_users_table.php
│   │   ├── 2026_06_02_000002_create_admins_table.php
│   │   ├── 2026_06_02_000003_create_transactions_table.php
│   │   ├── 2026_06_02_000004_create_qr_codes_table.php
│   │   └── 2026_06_02_000005_create_merchants_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       ├── UserSeeder.php
│       └── DatabaseSeeder.php
│
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       └── transaction/
│           ├── index.blade.php
│           ├── show.blade.php
│           └── edit.blade.php
│
├── bootstrap/
│   ├── app.php
│   └── providers.php
│
├── .env
├── composer.json
└── README.md
```

### Database Tables

#### 1. onopay_users
```sql
- id (PK)
- phone_number (UNIQUE)
- name
- email (UNIQUE)
- balance (decimal)
- status (active|inactive|blocked)
- pin (nullable)
- created_at, updated_at
```

#### 2. admins
```sql
- id (PK)
- email (UNIQUE)
- password
- name
- role (super_admin|admin)
- remember_token
- created_at, updated_at
```

#### 3. transactions
```sql
- id (PK)
- transaction_id (UNIQUE)
- user_id (FK)
- merchant_code (nullable)
- amount (decimal)
- type (payment|topup|transfer|withdrawal)
- status (pending|success|failed|cancelled)
- description (nullable)
- notes (nullable)
- completed_at (nullable)
- created_at, updated_at
```

#### 4. qr_codes
```sql
- id (PK)
- code (UNIQUE)
- merchant_code (nullable)
- user_id (FK)
- amount (decimal, nullable)
- description
- qr_data (text)
- status (active|expired|used|cancelled)
- expires_at (nullable)
- created_at, updated_at
```

#### 5. merchants
```sql
- id (PK)
- merchant_code (UNIQUE)
- name
- email (UNIQUE)
- balance (decimal)
- status (active|inactive|blocked)
- contact_person (nullable)
- phone (nullable)
- address (nullable)
- created_at, updated_at
```

---

## Troubleshooting

### 1. Error: "No application encryption key has been specified"

**Solusi:**
```bash
php artisan key:generate
```

Check `.env` apakah `APP_KEY` sudah terisi.

### 2. Error: "SQLSTATE[HY000]: General error: 1030"

**Solusi:**
```bash
# Cek MySQL status
mysql -u root -e "SELECT 1"

# Jika error, restart MySQL
# MacOS
brew services restart mysql

# Linux
sudo systemctl restart mysql

# Windows
net stop MySQL80
net start MySQL80
```

### 3. Error: "Class not found"

**Solusi:**
```bash
composer dump-autoload
php artisan cache:clear
```

### 4. Database Connection Error

**Check:**
1. MySQL sudah running?
2. Database `onopay_db` sudah ada?
3. `.env` config sudah benar?
4. Credentials `root` dan password benar?

**Test Connection:**
```bash
php artisan tinker
DB::connection()->getPdo();
```

### 5. Session/Auth Error

**Solusi:**
```bash
php artisan cache:clear
php artisan config:cache
```

### 6. Port 8000 Already in Use

**Solusi:**
```bash
# Gunakan port berbeda
php artisan serve --port=8001

# Atau kill process yang menggunakan port 8000
# MacOS/Linux
lsof -i :8000
kill -9 <PID>

# Windows
netstat -ano | findstr :8000
taskkill /PID <PID> /F
```

### 7. Files Permission Error

**Solusi:**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 8. Factory/Seeder Not Working

**Solusi:**
```bash
composer dump-autoload
php artisan migrate:refresh --seed
```

---

## Useful Artisan Commands

```bash
# Database
php artisan migrate                    # Run migrations
php artisan migrate:refresh            # Reset & migrate
php artisan migrate:fresh --seed       # Fresh install dengan seeders
php artisan db:seed                    # Run seeders

# Cache
php artisan cache:clear                # Clear cache
php artisan config:cache               # Cache config
php artisan config:clear               # Clear config cache

# Development
php artisan serve                      # Start server
php artisan tinker                     # Laravel REPL

# Debug
php artisan route:list                 # List all routes
php artisan make:migration <name>      # Create migration
php artisan make:model <name>          # Create model

# Utility
php artisan storage:link               # Link storage
php artisan queue:work                 # Process jobs (jika digunakan)
```

---

## Next Steps

1. ✅ Setup database
2. ✅ Jalankan migrations & seeders
3. ✅ Start server
4. ✅ Login ke admin panel
5. 📖 Baca [API_TESTING.md](./API_TESTING.md) untuk API testing
6. 🧪 Test API endpoints
7. 📊 Explore admin panel features

---

## Important Notes

### For Learning Purpose
- Aplikasi ini dirancang **simple & ringan** untuk pembelajaran
- API **tidak ada authentication** agar mudah dipelajari
- Database bersifat **local hanya**
- Cocok untuk praktek mahasiswa

### Before Production
1. Implementasikan proper authentication (API key, OAuth, JWT)
2. Validasi input lebih ketat
3. Implementasikan rate limiting
4. Encrypt sensitive data
5. Setup logging & monitoring
6. Implementasikan proper error handling
7. Add unit & integration tests
8. Setup CI/CD pipeline

---

## Support & Resources

- **Laravel Docs**: https://laravel.com/docs/12.x
- **Laravel API**: https://laravel.com/api/12.x
- **Bootstrap Docs**: https://getbootstrap.com/docs/5.3

---

**Selamat! Aplikasi OnoPay sudah siap digunakan! 🎉**
