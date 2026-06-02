# OnoPay - Quick Start Guide

## 🚀 5 Menit Setup

### 1. Database Setup
```bash
# Create database
mysql -u root -e "CREATE DATABASE onopay_db;"
```

### 2. Project Setup
```bash
cd /Users/rizkimuliono/Library/Mobile\ Documents/com~apple~CloudDocs/PROYEK_WEB/onopay_web

# Install dependencies
composer install

# Generate key
php artisan key:generate

# Run migrations & seeds
php artisan migrate
php artisan db:seed
```

### 3. Start Server
```bash
php artisan serve
```

**Done!** Aplikasi berjalan di `http://localhost:8000`

---

## 📱 Quick Access

| Link | Purpose |
|------|---------|
| http://localhost:8000/login | Admin login page |
| http://localhost:8000/dashboard | Admin dashboard |
| http://localhost:8000/transaction | View transactions |
| http://localhost:8000/api/v1/merchant/check-user | API endpoint |

---

## 🔐 Admin Credentials

```
Email:    admin@onopay.local
Password: password123
```

---

## 🧪 Quick API Test (cURL)

### Test 1: Check User
```bash
curl -X POST http://localhost:8000/api/v1/merchant/check-user \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

### Test 2: Check Balance
```bash
curl -X POST http://localhost:8000/api/v1/merchant/check-balance \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789"}'
```

### Test 3: Topup
```bash
curl -X POST http://localhost:8000/api/v1/payment/topup \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789","amount":500000}'
```

### Test 4: Generate QR
```bash
curl -X POST http://localhost:8000/api/v1/payment/qr/generate \
  -H "Content-Type: application/json" \
  -d '{"phone_number":"08123456789","amount":250000,"merchant_code":"MERCHANT-001"}'
```

---

## 🧑‍💼 Test Users

| Phone | Name | Balance |
|-------|------|---------|
| 08123456789 | Budi Santoso | Rp 5M |
| 08987654321 | Siti Nurhaliza | Rp 2.5M |
| 08111222333 | Ahmad Wijaya | Rp 1M |
| 08444555666 | Dewi Lestari | Rp 7.5M |
| 08777888999 | Roni Permana | Rp 3M |

---

## 📚 Documentation Files

| File | Content |
|------|---------|
| `README.md` | Project overview |
| `SETUP.md` | Detailed setup guide |
| `API_TESTING.md` | API endpoint documentation |
| `FEATURES.md` | Complete feature list |
| `PROJECT_STRUCTURE.md` | Project architecture |
| `QUICK_START.md` | This file |

---

## 🛠️ Useful Commands

```bash
# Development
php artisan serve                  # Start server (port 8000)
php artisan serve --port=8001     # Start with custom port

# Database
php artisan migrate               # Run migrations
php artisan migrate:refresh       # Reset & migrate
php artisan migrate:fresh --seed  # Fresh install with data
php artisan db:seed              # Run seeders

# Cache
php artisan cache:clear          # Clear cache
php artisan config:cache         # Cache configuration

# Debug
php artisan tinker               # Laravel REPL shell
php artisan route:list           # Show all routes
php artisan route:list --path=api # Show only API routes

# Utility
php artisan artisan key:generate # Generate app key
php artisan storage:link         # Link storage directory
```

---

## 🔗 API Endpoints Summary

```
Base URL: http://localhost:8000/api/v1

1. POST /merchant/check-user
2. POST /merchant/check-balance
3. POST /payment/topup
4. POST /payment/qr/generate
5. POST /payment/qr/pay
```

---

## 🎯 Common Tasks

### Task 1: Restart Server
```bash
# Stop: Press Ctrl+C
# Start: php artisan serve
```

### Task 2: Reset Database
```bash
php artisan migrate:fresh --seed
```

### Task 3: Check Database Tables
```bash
php artisan tinker
>>> Schema::getTables();
```

### Task 4: Clear All Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Task 5: Test API in Terminal
```bash
# Install httpie (optional)
brew install httpie

# Use httpie
http POST http://localhost:8000/api/v1/merchant/check-user phone_number=08123456789
```

---

## ⚡ Performance Tips

1. **Use pagination** untuk large datasets
2. **Enable caching** untuk frequently accessed data
3. **Index database** columns yang sering di-query
4. **Use eager loading** untuk relations (Eloquent)
5. **Optimize queries** dengan SQL explains

---

## 🐛 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| MySQL error | Restart MySQL: `brew services restart mysql` |
| Port 8000 in use | Use different port: `php artisan serve --port=8001` |
| Class not found | `composer dump-autoload` |
| Permission denied | `chmod -R 755 storage bootstrap/cache` |
| Blank page | Check `storage/logs/laravel.log` |
| DB connection error | Check `.env` database config |

---

## 📖 Next Steps

1. ✅ Run setup commands
2. ✅ Start server
3. ✅ Login to admin panel
4. ✅ Explore admin features
5. ✅ Test API endpoints
6. ✅ Read documentation files
7. 📊 Experiment & modify code
8. 🚀 Build your own features!

---

## 💡 Learning Resources

**Documentation Files** (in project):
- SETUP.md - Detailed setup
- API_TESTING.md - API examples
- FEATURES.md - Feature documentation
- PROJECT_STRUCTURE.md - Code structure

**External Resources**:
- Laravel: https://laravel.com/docs/12.x
- Bootstrap: https://getbootstrap.com/docs/5.3
- MySQL: https://dev.mysql.com/doc/

---

## 🎓 For Mahasiswa

Ini adalah project pembelajaran. Anda dapat:

1. **Memahami** struktur Laravel application
2. **Belajar** membuat API endpoints
3. **Praktik** authentication & authorization
4. **Eksperimen** dengan database design
5. **Kembangkan** fitur tambahan
6. **Deploy** ke production (dengan security hardening)

---

## ✅ Checklist

- [ ] Database created
- [ ] Dependencies installed
- [ ] Migrations running
- [ ] Seeders executed
- [ ] Server started
- [ ] Admin panel accessible
- [ ] API endpoints tested
- [ ] Documentation read

**All done? Selamat coding! 🚀**

---

## 🆘 Need Help?

1. Check `storage/logs/laravel.log` for errors
2. Read relevant documentation file
3. Try clearing cache: `php artisan cache:clear`
4. Restart server: `php artisan serve`
5. Reset database: `php artisan migrate:fresh --seed`

---

**Happy coding dengan OnoPay! 💰✨**
