# OnoPay API - Testing Guide

## 🚀 Quick Start

### 1. Start Server
```bash
cd /Users/rizkimuliono/Library/Mobile\ Documents/com~apple~CloudDocs/PROYEK_WEB/onopay_web
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

### 2. Access Admin Panel
- URL: http://localhost:8000/login
- Email: `admin@onopay.local`
- Password: `password123`

## 📡 API Testing

### Base URL
```
http://localhost:8000/api/v1
```

Semua API endpoints **TIDAK memerlukan authentication**.

---

## 1️⃣ Check User Information

### Endpoint
```http
POST /merchant/check-user
Content-Type: application/json
```

### cURL Example
```bash
curl -X POST http://localhost:8000/api/v1/merchant/check-user \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789"
  }'
```

### Request Body
```json
{
  "phone_number": "08123456789"
}
```

### Success Response (200)
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

### Error Response (404)
```json
{
  "success": false,
  "message": "User tidak ditemukan",
  "data": null
}
```

---

## 2️⃣ Check Balance

### Endpoint
```http
POST /merchant/check-balance
Content-Type: application/json
```

### cURL Example
```bash
curl -X POST http://localhost:8000/api/v1/merchant/check-balance \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789"
  }'
```

### Request Body
```json
{
  "phone_number": "08123456789"
}
```

### Success Response (200)
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

### Error Responses

**User tidak ditemukan (404)**
```json
{
  "success": false,
  "message": "User tidak ditemukan",
  "data": null
}
```

**User tidak aktif (403)**
```json
{
  "success": false,
  "message": "User tidak aktif",
  "data": null
}
```

---

## 3️⃣ Topup Balance

### Endpoint
```http
POST /payment/topup
Content-Type: application/json
```

### cURL Example
```bash
curl -X POST http://localhost:8000/api/v1/payment/topup \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789",
    "amount": 500000
  }'
```

### Request Body
```json
{
  "phone_number": "08123456789",
  "amount": 500000
}
```

### Success Response (200)
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

### Error Responses

**Minimum amount (minimum 1000)**
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "amount": ["amount harus minimal 1000"]
  }
}
```

---

## 4️⃣ Generate QR Code

### Endpoint
```http
POST /payment/qr/generate
Content-Type: application/json
```

### cURL Example
```bash
curl -X POST http://localhost:8000/api/v1/payment/qr/generate \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789",
    "amount": 250000,
    "merchant_code": "MERCHANT-001",
    "description": "Pembayaran untuk Toko Elektronik"
  }'
```

### Request Body
```json
{
  "phone_number": "08123456789",
  "amount": 250000,
  "merchant_code": "MERCHANT-001",
  "description": "Pembayaran untuk Toko Elektronik"
}
```

### Success Response (200)
```json
{
  "success": true,
  "message": "QR code berhasil dibuat",
  "data": {
    "qr_code": "QR-ABCD1234EFGH",
    "amount": 250000,
    "merchant_code": "MERCHANT-001",
    "expires_at": "2026-06-02T12:30:00Z",
    "description": "Pembayaran untuk Toko Elektronik"
  }
}
```

### Notes
- QR code berlaku 15 menit setelah dibuat
- Amount minimum: 100
- Merchant code & description optional

---

## 5️⃣ Payment via QR Code

### Endpoint
```http
POST /payment/qr/pay
Content-Type: application/json
```

### cURL Example
```bash
curl -X POST http://localhost:8000/api/v1/payment/qr/pay \
  -H "Content-Type: application/json" \
  -d '{
    "qr_code": "QR-ABCD1234EFGH",
    "payer_phone": "08987654321"
  }'
```

### Request Body
```json
{
  "qr_code": "QR-ABCD1234EFGH",
  "payer_phone": "08987654321"
}
```

### Success Response (200)
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

### Error Responses

**QR code tidak ditemukan (404)**
```json
{
  "success": false,
  "message": "QR code tidak ditemukan"
}
```

**QR code sudah expired (403)**
```json
{
  "success": false,
  "message": "QR code sudah expired"
}
```

**Saldo tidak cukup (402)**
```json
{
  "success": false,
  "message": "Saldo tidak cukup"
}
```

**Payer tidak aktif (403)**
```json
{
  "success": false,
  "message": "Payer tidak aktif"
}
```

---

## 📊 Test Data Available

### Users
```
Phone: 08123456789
Name: Budi Santoso
Balance: Rp 5.000.000
Status: Active

Phone: 08987654321
Name: Siti Nurhaliza
Balance: Rp 2.500.000
Status: Active

Phone: 08111222333
Name: Ahmad Wijaya
Balance: Rp 1.000.000
Status: Active

Phone: 08444555666
Name: Dewi Lestari
Balance: Rp 7.500.000
Status: Active

Phone: 08777888999
Name: Roni Permana
Balance: Rp 3.000.000
Status: Active
```

---

## 🧪 Testing with Postman

### 1. Import Collection
Create a new Postman Collection with requests below

### 2. Set Variables
```
base_url: http://localhost:8000/api/v1
```

### 3. Create Requests

**Request 1: Check User**
```
POST {{base_url}}/merchant/check-user
Body (raw JSON):
{
  "phone_number": "08123456789"
}
```

**Request 2: Check Balance**
```
POST {{base_url}}/merchant/check-balance
Body (raw JSON):
{
  "phone_number": "08123456789"
}
```

**Request 3: Topup**
```
POST {{base_url}}/payment/topup
Body (raw JSON):
{
  "phone_number": "08123456789",
  "amount": 500000
}
```

**Request 4: Generate QR**
```
POST {{base_url}}/payment/qr/generate
Body (raw JSON):
{
  "phone_number": "08123456789",
  "amount": 250000,
  "merchant_code": "MERCHANT-001"
}
```

**Request 5: Pay via QR**
```
POST {{base_url}}/payment/qr/pay
Body (raw JSON):
{
  "qr_code": "QR-ABCD1234EFGH",
  "payer_phone": "08987654321"
}
```

---

## 🐛 Troubleshooting

### Error: "Connection refused"
- Pastikan server sudah berjalan: `php artisan serve`
- Server harus berjalan di port 8000

### Error: "SQLSTATE[HY000]: General error"
- Pastikan database sudah dibuat
- Jalankan `php artisan migrate`

### Error: "Class not found"
- Clear cache: `php artisan cache:clear`
- Composer autoload: `composer dump-autoload`

### Error: "Validation error"
- Cek request body format JSON
- Pastikan field yang required sudah terisi

---

## 📝 Notes untuk Mahasiswa

1. **API Flow**:
   - Generate QR → User scan → Payment → Confirmation

2. **Transaction Tracking**:
   - Setiap transaksi dapat dilacak via transaction_id
   - Admin dapat melihat riwayat di dashboard

3. **Error Handling**:
   - Selalu cek `success` flag dalam response
   - Gunakan `message` untuk user feedback
   - Lihat `data` untuk informasi detail

4. **Security Notes** (untuk production):
   - Implementasikan API authentication (API key atau OAuth)
   - Validasi input lebih ketat
   - Implementasikan rate limiting
   - Encrypt sensitive data (PIN, payment info)

---

## 🔗 Related Files

- API Routes: `routes/api.php`
- Controllers: `app/Http/Controllers/Api/`
- Models: `app/Models/`
- Database: `onopay_db` (MySQL)

---

**Happy Testing! 🎉**
