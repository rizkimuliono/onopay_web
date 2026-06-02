# OnoPay - Fitur & Panduan Penggunaan

## 📱 Platform: API & Web Admin

OnoPay adalah aplikasi payment gateway dengan 2 platform utama:

### 1. API untuk Merchant/Pihak Ketiga
- Tanpa authentikasi (untuk kemudahan pembelajaran)
- RESTful endpoints
- JSON request/response

### 2. Admin Web Panel
- Dengan autentikasi (login)
- Dashboard & statistik
- Manajemen transaksi
- Tema responsif Bootstrap

---

## 🔌 API Merchant Features

### 1. Check User by Phone Number

**Fungsi**: Verifikasi user OnoPay berdasarkan nomor HP

```
POST /api/v1/merchant/check-user
```

**Kegunaan**:
- Validasi nomor HP user sebelum transaksi
- Cek ketersediaan user di sistem

**Request**:
```json
{
  "phone_number": "08123456789"
}
```

**Response (Success)**:
```json
{
  "success": true,
  "message": "User ditemukan",
  "data": {
    "id": 1,
    "phone_number": "08123456789",
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "status": "active"
  }
}
```

---

### 2. Check User Balance

**Fungsi**: Melihat saldo user OnoPay

```
POST /api/v1/merchant/check-balance
```

**Kegunaan**:
- Cek saldo user sebelum pembayaran
- Validasi ketersediaan dana
- Informasi akun user

**Request**:
```json
{
  "phone_number": "08123456789"
}
```

**Response (Success)**:
```json
{
  "success": true,
  "message": "Balance ditemukan",
  "data": {
    "phone_number": "08123456789",
    "name": "Budi Santoso",
    "balance": 5000000
  }
}
```

**Flow**:
```
Check User → Check Balance → Lanjut ke Payment
```

---

### 3. Topup Saldo User

**Fungsi**: Menambah saldo user melalui API

```
POST /api/v1/payment/topup
```

**Kegunaan**:
- User atau merchant bisa melakukan topup
- Integrasi dengan payment gateway
- Saldo langsung ditambahkan ke user

**Request**:
```json
{
  "phone_number": "08123456789",
  "amount": 500000
}
```

**Response (Success)**:
```json
{
  "success": true,
  "message": "Topup berhasil",
  "data": {
    "transaction_id": "TXN-1717373920-ABCDEF",
    "amount": 500000,
    "new_balance": 5500000,
    "status": "success"
  }
}
```

**Catatan**:
- Minimum topup: Rp 1.000
- Saldo langsung ter-update
- Transaction ID untuk tracking

---

### 4. Generate QR Code untuk Pembayaran

**Fungsi**: Membuat QR code yang dapat di-scan untuk pembayaran

```
POST /api/v1/payment/qr/generate
```

**Kegunaan**:
- Merchant bisa menerima pembayaran via QR
- User scan QR dari mobile app
- Dinamis berdasarkan nominal

**Request**:
```json
{
  "phone_number": "08123456789",
  "amount": 250000,
  "merchant_code": "MERCHANT-001",
  "description": "Pembayaran Belanja"
}
```

**Response (Success)**:
```json
{
  "success": true,
  "message": "QR code berhasil dibuat",
  "data": {
    "qr_code": "QR-ABCD1234EFGH",
    "amount": 250000,
    "merchant_code": "MERCHANT-001",
    "expires_at": "2026-06-02T12:30:00Z",
    "description": "Pembayaran Belanja"
  }
}
```

**Payment Flow**:
```
Generate QR → QR ditampilkan di kasir → User scan + confirm → Payment processed
```

**Fitur**:
- QR berlaku 15 menit
- Bisa untuk fixed amount atau dinamis
- Terintegrasi dengan merchant code
- Dapat melacak pembayaran per QR

---

### 5. Process Payment via QR Code

**Fungsi**: Melakukan pembayaran dengan scanning QR code

```
POST /api/v1/payment/qr/pay
```

**Kegunaan**:
- User transfer uang ke merchant
- Saldo kurang dari payer
- Saldo bertambah untuk receiver
- Transaksi tercatat otomatis

**Request**:
```json
{
  "qr_code": "QR-ABCD1234EFGH",
  "payer_phone": "08987654321"
}
```

**Response (Success)**:
```json
{
  "success": true,
  "message": "Pembayaran berhasil",
  "data": {
    "transaction_id": "TXN-1717373920-XYZ789",
    "amount": 250000,
    "receiver": "Budi Santoso",
    "payer_new_balance": 2250000,
    "status": "success"
  }
}
```

**Payment Processing**:
```
1. Validasi QR code
2. Cek saldo payer
3. Kurangi saldo payer
4. Tambah saldo receiver
5. Buat transaction record
6. Tandai QR as "used"
7. Return transaction ID
```

**Error Handling**:
- QR code tidak valid → reject
- QR code expired → reject
- Saldo tidak cukup → reject
- User tidak aktif → reject

---

## 🖥️ Admin Web Panel Features

### 1. Authentication & Login

**URL**: `http://localhost:8000/login`

**Credentials**:
```
Email:    admin@onopay.local
Password: password123
```

**Features**:
- Session-based authentication
- Remember token untuk Stay logged in
- Secure password hashing
- Logout functionality

---

### 2. Dashboard

**URL**: `http://localhost:8000/dashboard`

**Statistik Ditampilkan**:
- ✅ Total Users (dengan breakdown aktif)
- ✅ Total Saldo di sistem
- ✅ Total Transaksi
- ✅ Transaksi hari ini (count & amount)
- ✅ List transaksi terbaru (10 teratas)

**Informasi Transaksi Terbaru**:
- ID Transaksi
- Nama & No HP User
- Tipe (Pembayaran, Topup, Transfer)
- Nominal
- Status (Sukses, Pending, Gagal, Batal)
- Waktu
- Link lihat detail

**Visual Design**:
- Stat cards dengan border biru
- Responsive grid layout
- Bootstrap 5 components
- Color scheme: Dark blue, Blue, White

---

### 3. Daftar Transaksi

**URL**: `http://localhost:8000/transaction`

**Features**:

#### Filter & Pencarian
- 🔍 Search by phone number / name / transaction ID
- 🏷️ Filter by type (Payment, Topup, Transfer)
- 📊 Filter by status (Success, Pending, Failed, Cancelled)
- 🔄 Real-time filtering

#### Tabel Transaksi
| Column | Data |
|--------|------|
| ID Transaksi | TXN-xxx-xxx |
| Pengguna | Nama + No HP |
| Tipe | Badge with icon |
| Nominal | Rp X.XXX.XXX |
| Status | Badge color (green/red/yellow) |
| Tanggal | dd/mm/yyyy HH:mm |
| Aksi | View + Edit button |

#### Fitur Tambahan
- Pagination (20 per halaman)
- Total data counter
- Responsive table
- Mobile-friendly

**Use Case**:
```
Admin buka Transaksi → Filter by status:pending → 
Lihat detail → Edit status → Save
```

---

### 4. Detail Transaksi

**URL**: `http://localhost:8000/transaction/{id}`

**Informasi Ditampilkan**:

#### Section 1: Transaksi Info
- ID Transaksi
- Status (dengan badge)
- Tipe Transaksi
- Nominal
- Keterangan
- Dibuat tanggal & jam
- Selesai tanggal & jam (jika ada)

#### Section 2: Catatan Admin
- Tampilkan catatan yang pernah dibuat
- Jika kosong: "Belum ada catatan"

#### Section 3: Data Pengguna (Sidebar)
- Avatar (icon)
- Nama user
- No HP
- Email
- Status (aktif/blocked)
- Saldo saat ini
- Merchant code (jika ada)

#### Tombol Aksi
- Edit Transaksi
- Kembali ke Daftar

---

### 5. Edit Transaksi & Status

**URL**: `http://localhost:8000/transaction/{id}/edit`

**Read-Only Fields** (tidak bisa diubah):
- Nama Pengguna
- No HP
- Tipe Transaksi
- Nominal
- Keterangan Transaksi

**Editable Fields**:

#### Status Transaksi
- Dropdown: Pending / Success / Failed / Cancelled
- Untuk mengubah status jika ada error

#### Catatan Admin
- Text area (5 rows)
- Untuk mencatat alasan perubahan atau catatan penting

**Info Box**:
- Reminder untuk admin:
  - Hanya ubah jika ada masalah
  - Cantumkan alasan di catatan
  - Perubahan akan tercatat

**Sidebar Informasi**:
- Riwayat transaksi
- Status saat ini
- Warning tentang perubahan

**Alert Box**:
- Status sebelum & sesudah perubahan
- Updated timestamp

**Use Case**:
```
Scenario 1: Transaksi stuck di Pending
Admin: Click Edit → Change status to Success → Add note
"Manual approve karena payment gateway delay" → Save

Scenario 2: User lapor transaksi failed tapi saldo mereka berkurang
Admin: Click Edit → Change status to Success (jika OK) 
atau Cancelled (jika salah) → Add note + Save
```

---

## 🎨 UI/UX Design

### Color Scheme
- **Primary Dark**: #003d7a (Biru Tua)
- **Primary Blue**: #0066cc (Biru)
- **Light Blue**: #e6f2ff (Background highlight)
- **White**: #ffffff
- **Gray**: #f5f7fa (Background utama)

### Components
- ✅ Responsive Navbar
- ✅ Fixed Sidebar Navigation
- ✅ Bootstrap Cards
- ✅ Stat Cards with borders
- ✅ Badges & Buttons
- ✅ Tables with hover effect
- ✅ Forms dengan validation
- ✅ Alerts & Messages
- ✅ Bootstrap Icons

### Responsive
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (< 768px)

---

## 📊 Data Models & Relationships

### User (onopay_users)
```
- Phone number (unik)
- Name, Email
- Balance (decimal)
- Status: active / inactive / blocked
- PIN (untuk transaksi, hashed)
```

### Admin (admins)
```
- Email (unik)
- Password (hashed)
- Name
- Role: super_admin / admin
```

### Transaction
```
- Transaction ID (unik)
- User ID (FK ke onopay_users)
- Merchant code
- Amount
- Type: payment / topup / transfer / withdrawal
- Status: pending / success / failed / cancelled
- Description & Notes
- Completed At timestamp
```

### QR Code
```
- QR Code (unik)
- Merchant code
- User ID (FK)
- Amount
- Description
- QR Data (JSON)
- Status: active / expired / used / cancelled
- Expires At
```

---

## 🔄 Complete Transaction Flow

### Flow 1: Topup via API
```
1. User/Merchant request topup
2. API validate user exists & amount
3. Add amount ke balance
4. Record transaction sebagai "topup"
5. Return transaction_id
6. Balance updated di database
```

### Flow 2: Payment via QR
```
1. Merchant generate QR code
2. QR ditampilkan di toko/kasir
3. User scan QR dari app
4. App show nominal & merchant info
5. User confirm pembayaran
6. API validate QR & saldo payer
7. Deduct payer balance
8. Add receiver balance
9. Create transaction record
10. Mark QR as used
11. Return confirmation
```

### Flow 3: Admin Manage Transaction
```
1. Admin login
2. View dashboard / transaksi list
3. Search atau filter transaksi
4. Click "Lihat" untuk detail
5. Review informasi & user data
6. Jika ada error, click "Edit"
7. Change status & add notes
8. Save perubahan
9. Redirect ke detail page dengan success message
```

---

## 🧪 Testing Scenarios

### Scenario 1: Basic User Check
```
1. Call check-user dengan "08123456789"
2. Verify response contains user details
3. Status should be "active"
```

### Scenario 2: Full Payment Flow
```
1. Call check-balance untuk payer
2. Verify balance cukup
3. Call generate-qr
4. Save QR code
5. Call payment-qr dengan QR & payer
6. Verify saldo payer berkurang
7. Verify saldo receiver bertambah
8. Check transaction record di admin
```

### Scenario 3: Admin Transaction Edit
```
1. Login ke admin
2. Go to transactions
3. Search transaksi specific
4. Click "Lihat" detail
5. Click "Edit"
6. Change status
7. Add catatan
8. Save & verify update
```

---

## 📝 Important Notes

### API Security (Current vs Production)

**Current** (Untuk pembelajaran):
- ❌ Tanpa authentication
- ❌ Tanpa rate limiting
- ❌ Tanpa request validation ketat

**Production** (Harus):
- ✅ API Key atau OAuth
- ✅ Rate limiting (1000 req/hour)
- ✅ Input validation ketat
- ✅ Output sanitization
- ✅ HTTPS only
- ✅ CORS configuration

### Data Safety
- Jangan share database credentials
- Jangan commit `.env` ke git
- Backup data secara berkala
- Gunakan hashed password

### Performance Tips
- Pagination untuk large dataset
- Caching untuk frequently accessed data
- Database indexing on phone_number & transaction_id

---

**Selamat! Anda sudah memahami semua fitur OnoPay! 🎉**
