# OnoPay - Project Structure & Architecture

## 📂 Directory Structure

```
onopay_web/
│
├── app/                          # Application logic
│   ├── Http/
│   │   ├── Controllers/          # Request handlers
│   │   │   ├── Api/
│   │   │   │   ├── MerchantController.php    # Check user, check balance
│   │   │   │   └── PaymentController.php     # Topup, QR, payment
│   │   │   ├── AuthController.php            # Login & logout
│   │   │   ├── DashboardController.php       # Dashboard stats
│   │   │   └── TransactionController.php     # Transaksi CRUD
│   │   ├── Kernel.php            # HTTP kernel configuration
│   │   └── Middleware/           # Middleware (future)
│   │
│   ├── Models/                   # Database models
│   │   ├── User.php             # OnoPay users (onopay_users table)
│   │   ├── Admin.php            # Admins (admins table)
│   │   ├── Transaction.php      # Transactions (transactions table)
│   │   ├── QRCode.php          # QR codes (qr_codes table)
│   │   └── Merchant.php         # Merchants (merchants table)
│   │
│   ├── Providers/                # Service providers
│   │   └── AppServiceProvider.php # Boot application
│   │
│   └── Exceptions/               # Exception handlers
│       └── Handler.php
│
├── database/
│   ├── migrations/               # Database schema
│   │   ├── 0001_01_01_000000_create_users_table.php          # Default Laravel setup
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_06_02_000001_create_onopay_users_table.php   # OnoPay Users
│   │   ├── 2026_06_02_000002_create_admins_table.php         # Admins
│   │   ├── 2026_06_02_000003_create_transactions_table.php   # Transactions
│   │   ├── 2026_06_02_000004_create_qr_codes_table.php       # QR Codes
│   │   └── 2026_06_02_000005_create_merchants_table.php      # Merchants
│   │
│   ├── seeders/                  # Database seeders
│   │   ├── DatabaseSeeder.php    # Main seeder (calls AdminSeeder & UserSeeder)
│   │   ├── AdminSeeder.php       # Creates 2 admin users
│   │   └── UserSeeder.php        # Creates 5 test users + 50 transactions + 10 QRs
│   │
│   └── factories/                # Model factories (future)
│       └── UserFactory.php
│
├── routes/
│   ├── web.php                   # Web routes (login, dashboard, transaksi)
│   ├── api.php                   # API routes (merchant endpoints)
│   └── console.php               # Console commands (artisan)
│
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── layouts/
│   │   │   └── app.blade.php            # Main layout (navbar, sidebar, footer)
│   │   │
│   │   ├── auth/
│   │   │   └── login.blade.php          # Login form
│   │   │
│   │   ├── dashboard/
│   │   │   └── index.blade.php          # Dashboard with stats
│   │   │
│   │   └── transaction/
│   │       ├── index.blade.php          # Transaction list with filter
│   │       ├── show.blade.php           # Transaction detail
│   │       └── edit.blade.php           # Edit transaction status & notes
│   │
│   ├── css/                      # CSS files (future)
│   ├── js/                       # JavaScript files (future)
│   └── components/               # Blade components (future)
│
├── bootstrap/
│   ├── app.php                   # Application bootstrapper
│   ├── cache/                    # Bootstrap cache directory
│   └── providers.php             # Service provider bootstrapper
│
├── config/
│   ├── app.php                   # Application configuration
│   ├── database.php              # Database configuration
│   ├── cache.php                 # Cache configuration
│   └── ...                       # Other config files
│
├── storage/
│   ├── app/                      # Application storage
│   ├── logs/                     # Application logs
│   └── framework/                # Framework storage
│
├── tests/                        # Test files (future)
│   ├── Unit/
│   ├── Feature/
│   └── TestCase.php
│
├── public/
│   ├── index.php                 # Entry point
│   └── .htaccess
│
├── vendor/                       # Composer dependencies (not committed)
│
├── .env                          # Environment configuration (local)
├── .env.example                  # Example environment file
├── .gitignore                    # Git ignore file
├── composer.json                 # PHP dependencies
├── composer.lock                 # Locked dependency versions
│
├── artisan                       # Laravel CLI
│
├── README.md                     # Project README
├── SETUP.md                      # Setup & installation guide
├── API_TESTING.md                # API testing guide
├── FEATURES.md                   # Features documentation
└── PROJECT_STRUCTURE.md          # This file
```

---

## 🔧 Core Files Explanation

### 1. Controllers

#### `app/Http/Controllers/Api/MerchantController.php`
```php
Functions:
- checkUser()              // Cek user by phone number
- checkBalance()           // Cek saldo user
```

**Used for**: Merchant queries tentang user

#### `app/Http/Controllers/Api/PaymentController.php`
```php
Functions:
- topup()                  // Topup saldo
- generateQR()             // Generate QR code
- paymentQR()              // Process payment by QR
```

**Used for**: Payment processing & QR management

#### `app/Http/Controllers/AuthController.php`
```php
Functions:
- loginForm()              // Show login page
- login()                  // Process login
- logout()                 // Process logout
```

**Used for**: Admin authentication

#### `app/Http/Controllers/DashboardController.php`
```php
Functions:
- index()                  // Show dashboard with stats
```

**Fetches**:
- Total users & active users
- Total balance in system
- Total transactions
- Today's transactions

#### `app/Http/Controllers/TransactionController.php`
```php
Functions:
- index()                  // List transactions (with filter)
- show()                   // Show transaction detail
- edit()                   // Show edit form
- update()                 // Update transaction
```

**Features**: Filter, search, pagination

---

### 2. Models

#### `app/Models/User.php`
```php
Table: onopay_users

Attributes:
- phone_number (unique)
- name
- email (unique)
- balance (decimal)
- status (active|inactive|blocked)
- pin (hashed)

Relationships:
- hasMany('transactions')
- hasMany('qrcodes')
```

#### `app/Models/Admin.php`
```php
Table: admins

Attributes:
- email (unique)
- password
- name
- role (super_admin|admin)

Features:
- Extends Authenticatable
- Password hashing via bcrypt
```

#### `app/Models/Transaction.php`
```php
Table: transactions

Attributes:
- transaction_id (unique)
- user_id (FK)
- merchant_code
- amount
- type (payment|topup|transfer|withdrawal)
- status (pending|success|failed|cancelled)
- description
- notes (for admin)
- completed_at

Relationships:
- belongsTo('user')
```

#### `app/Models/QRCode.php`
```php
Table: qr_codes

Attributes:
- code (unique)
- merchant_code
- user_id (FK)
- amount
- description
- qr_data (JSON)
- status (active|expired|used|cancelled)
- expires_at

Relationships:
- belongsTo('user')
```

---

### 3. Routes

#### `routes/web.php`
```php
// Authentication
POST /login          → AuthController@login
POST /logout         → AuthController@logout

// Protected Routes (require session)
GET  /dashboard      → DashboardController@index
GET  /transaction    → TransactionController@index
GET  /transaction/{id}        → TransactionController@show
GET  /transaction/{id}/edit   → TransactionController@edit
PUT  /transaction/{id}        → TransactionController@update
```

#### `routes/api.php`
```php
// Public API (no auth required)
Prefix: /api/v1

// Merchant endpoints
POST /merchant/check-user       → MerchantController@checkUser
POST /merchant/check-balance    → MerchantController@checkBalance

// Payment endpoints
POST /payment/topup             → PaymentController@topup
POST /payment/qr/generate       → PaymentController@generateQR
POST /payment/qr/pay            → PaymentController@paymentQR
```

---

### 4. Migrations

#### Migration Timeline
```
1. Default Laravel tables (users, cache, jobs, sessions)
2. onopay_users table
3. admins table
4. transactions table
5. qr_codes table
6. merchants table
```

#### Key Migrations Detail

**onopay_users**
```sql
id (PK)
phone_number (VARCHAR, UNIQUE)
name (VARCHAR)
email (VARCHAR, UNIQUE)
balance (DECIMAL 15,2)
status (ENUM: active, inactive, blocked)
pin (TEXT - hashed)
timestamps
```

**admins**
```sql
id (PK)
email (VARCHAR, UNIQUE)
password (VARCHAR)
name (VARCHAR)
role (ENUM: super_admin, admin)
remember_token (VARCHAR)
timestamps
```

**transactions**
```sql
id (PK)
transaction_id (VARCHAR, UNIQUE)
user_id (FK → onopay_users)
merchant_code (VARCHAR, nullable)
amount (DECIMAL 15,2)
type (ENUM: payment, topup, transfer, withdrawal)
status (ENUM: pending, success, failed, cancelled)
description (VARCHAR, nullable)
notes (TEXT, nullable)
completed_at (TIMESTAMP, nullable)
timestamps
```

**qr_codes**
```sql
id (PK)
code (VARCHAR, UNIQUE)
merchant_code (VARCHAR, nullable)
user_id (FK → onopay_users)
amount (DECIMAL 15,2, nullable)
description (TEXT)
qr_data (LONGTEXT - JSON)
status (ENUM: active, expired, used, cancelled)
expires_at (TIMESTAMP, nullable)
timestamps
```

---

### 5. Views (Blade Templates)

#### Layout: `resources/views/layouts/app.blade.php`
- Main layout dengan sidebar & navbar
- Bootstrap 5 responsive grid
- Custom CSS dengan gradien biru
- Navigation menu
- User info & logout button
- Alert messages section
- Content yield area

#### Authentication: `resources/views/auth/login.blade.php`
- Standalone login page (tidak pakai main layout)
- Bootstrap form styling
- Error messages display
- Demo credentials info

#### Dashboard: `resources/views/dashboard/index.blade.php`
- 4 stat cards (Users, Balance, Transactions, Today)
- Recent transactions table (10 rows)
- Status badges dengan warna berbeda
- Responsive grid layout

#### Transactions: `resources/views/transaction/index.blade.php`
- Filter card (search, type, status)
- Transactions table dengan pagination
- Action buttons (view, edit)
- Empty state handling
- Mobile responsive

#### Transaction Detail: `resources/views/transaction/show.blade.php`
- Transaction info section
- Admin notes section
- User info sidebar
- Action buttons
- Edit link

#### Edit Transaction: `resources/views/transaction/edit.blade.php`
- Read-only fields (user, amount, etc)
- Editable fields (status, notes)
- Form validation
- Helpful sidebar notes
- Submit & cancel buttons

---

## 🗄️ Database Relationships

```
┌─────────────────┐
│   onopay_users  │
├─────────────────┤
│ id (PK)         │
│ phone_number    │
│ name            │
│ email           │
│ balance         │
│ status          │
│ pin             │
└────────┬────────┘
         │
         │ 1:Many
         │
    ┌────┴──────────────┐
    │                   │
    ▼                   ▼
┌──────────────┐  ┌──────────────┐
│transactions  │  │   qr_codes   │
├──────────────┤  ├──────────────┤
│ id (PK)      │  │ id (PK)      │
│ user_id (FK) │  │ user_id (FK) │
│ amount       │  │ amount       │
│ type         │  │ code         │
│ status       │  │ status       │
│ ...          │  │ ...          │
└──────────────┘  └──────────────┘

┌─────────────┐
│   admins    │
├─────────────┤
│ id (PK)     │
│ email       │
│ password    │
│ name        │
│ role        │
└─────────────┘

┌──────────────┐
│  merchants   │
├──────────────┤
│ id (PK)      │
│ code         │
│ name         │
│ balance      │
│ ...          │
└──────────────┘
```

---

## 🚀 Application Flow Architecture

```
HTTP Request
    │
    ├─ /login ────────────► AuthController::loginForm() ──► login.blade.php
    │
    ├─ POST /login ───────► AuthController::login() ──► Session created
    │
    ├─ /dashboard ───────► DashboardController::index() ──► Fetch stats ──► dashboard/index.blade.php
    │
    ├─ /transaction ─────► TransactionController::index() ──► Filter/search ──► transaction/index.blade.php
    │
    ├─ /transaction/{id} ► TransactionController::show() ──► Show detail ──► transaction/show.blade.php
    │
    ├─ /transaction/{id}/edit ► TransactionController::edit() ──► Show form ──► transaction/edit.blade.php
    │
    │
    API Routes:
    │
    ├─ POST /api/v1/merchant/check-user ──► MerchantController::checkUser() ──► JSON response
    │
    ├─ POST /api/v1/merchant/check-balance ──► MerchantController::checkBalance() ──► JSON
    │
    ├─ POST /api/v1/payment/topup ──► PaymentController::topup() ──► Update balance ──► JSON
    │
    ├─ POST /api/v1/payment/qr/generate ──► PaymentController::generateQR() ──► Create QR ──► JSON
    │
    └─ POST /api/v1/payment/qr/pay ──► PaymentController::paymentQR() ──► Process payment ──► JSON
```

---

## 📋 Configuration Files

### `config/database.php`
```php
// MySQL configuration
'mysql' => [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', '127.0.0.1'),
    'port'      => env('DB_PORT', '3306'),
    'database'  => env('DB_DATABASE', 'onopay_db'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', ''),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]
```

### `config/app.php`
```php
'name' => 'OnoPay',
'locale' => 'id',
'fallback_locale' => 'id',
'key' => env('APP_KEY'),
'debug' => env('APP_DEBUG', false),
```

### `.env`
```env
APP_NAME=OnoPay
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=onopay_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=session
```

---

## 💾 File Size Summary

```
Controllers:        ~600 lines
Models:             ~150 lines
Migrations:         ~300 lines
Seeders:            ~200 lines
Routes:             ~50 lines
Views:              ~1500 lines (Blade templates)
Total:              ~2800 lines
```

---

## 🔄 Deployment Structure

### Development
```
Local machine
├── Database: MySQL (localhost:3306)
├── Server: php artisan serve (localhost:8000)
└── Storage: storage/logs (local)
```

### Production (Recommended)
```
Web Server (Production)
├── Database: Remote MySQL server
├── Server: PHP-FPM + Nginx/Apache
├── Storage: Cloud storage (S3, etc)
├── Logs: Centralized logging
└── Cache: Redis
```

---

## 📚 Important Files to Remember

| File | Purpose |
|------|---------|
| `.env` | Environment config (DB, APP settings) |
| `routes/web.php` | Web routes |
| `routes/api.php` | API routes |
| `bootstrap/app.php` | Application bootstrapper |
| `app/Models/User.php` | User model |
| `app/Http/Controllers/` | Controllers |
| `resources/views/` | Blade templates |
| `database/migrations/` | Database schemas |
| `database/seeders/` | Database seeders |
| `composer.json` | PHP dependencies |

---

## 🎓 Learning Path

1. **Understand**: Read this structure file
2. **Explore**: Navigate project folders
3. **Study**: Read model & controller code
4. **Test**: Run migrations & seeders
5. **API Test**: Use API_TESTING.md
6. **Admin**: Login & explore admin panel
7. **Modify**: Change code & experiment

---

**Master the structure, master the application! 🚀**
