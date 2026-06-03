<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .navbar-doc {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-doc .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .sidebar-nav {
            position: fixed;
            left: 0;
            top: 60px;
            width: 280px;
            height: calc(100vh - 60px);
            background: white;
            border-right: 1px solid #e0e0e0;
            overflow-y: auto;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        }

        .sidebar-nav .nav-link {
            color: #333;
            padding: 10px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--light-blue);
            border-left-color: var(--primary-blue);
            color: var(--primary-dark);
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--light-blue);
            border-left-color: var(--primary-blue);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .main-content {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        .section-header {
            color: var(--primary-dark);
            font-weight: 600;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-blue);
        }

        .endpoint-card {
            background: white;
            border-left: 4px solid var(--primary-blue);
            border-radius: 6px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .endpoint-method {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-right: 10px;
        }

        .endpoint-method.post {
            background-color: #cfe2ff;
            color: #084298;
        }

        .endpoint-method.get {
            background-color: #d1e7dd;
            color: #0a3622;
        }

        .endpoint-url {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 12px 15px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin: 15px 0;
            overflow-x: auto;
        }

        .parameter-table {
            width: 100%;
            margin: 15px 0;
            font-size: 0.95rem;
        }

        .parameter-table thead {
            background-color: var(--light-blue);
        }

        .parameter-table th {
            color: var(--primary-dark);
            font-weight: 600;
            border: none;
            padding: 12px 15px;
        }

        .parameter-table td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
        }

        .parameter-type {
            background-color: #e7f3ff;
            color: #0066cc;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 0.85rem;
        }

        .code-example {
            background-color: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }

        .response-example {
            background-color: #f8f9fa;
            border-left: 4px solid var(--success);
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-required {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-optional {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .desc-text {
            color: #666;
            line-height: 1.8;
        }

        .intro-box {
            background: linear-gradient(135deg, var(--light-blue) 0%, #e0f0ff 100%);
            border-left: 4px solid var(--primary-blue);
            padding: 25px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .intro-box h2 {
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .intro-box p {
            color: #555;
            margin-bottom: 10px;
        }

        .base-url {
            background-color: white;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            border-radius: 4px;
            font-family: monospace;
            margin: 15px 0;
        }

        .copy-btn {
            float: right;
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .copy-btn:hover {
            background: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .sidebar-nav {
                position: relative;
                width: 100%;
                height: auto;
                top: 0;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                padding: 10px 0;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar-nav .nav-link {
                display: inline-block;
                margin: 0 10px;
                border-left: none;
                border-bottom: 3px solid transparent;
            }

            .sidebar-nav .nav-link:hover,
            .sidebar-nav .nav-link.active {
                border-left: none;
                border-bottom-color: var(--primary-blue);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-doc">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('api-docs') }}">
                <i class="bi bi-book"></i> OnoPay API Documentation
            </a>
        </div>
    </nav>

    <div style="display: flex;">
        <!-- Sidebar Navigation -->
        <div class="sidebar-nav">
            <nav class="nav flex-column">
                <a class="nav-link active" href="#introduction" data-section="introduction">
                    <i class="bi bi-info-circle"></i> Pengenalan
                </a>
                <a class="nav-link" href="#getting-started" data-section="getting-started">
                    <i class="bi bi-play-circle"></i> Memulai
                </a>
                <a class="nav-link" href="#merchant-api" data-section="merchant-api">
                    <i class="bi bi-shop"></i> Merchant API
                </a>
                <a class="nav-link" href="#payment-api" data-section="payment-api">
                    <i class="bi bi-credit-card"></i> Payment API
                </a>
                <a class="nav-link" href="#payment-flow" data-section="payment-flow">
                    <i class="bi bi-diagram-2"></i> Payment Flow
                </a>
                <a class="nav-link" href="#response-codes" data-section="response-codes">
                    <i class="bi bi-list-ul"></i> Response Codes
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Introduction Section -->
            <section id="introduction">
                <div class="intro-box">
                    <h2><i class="bi bi-book-open"></i> Selamat Datang di OnoPay API</h2>
                    <p>OnoPay API menyediakan akses kepada sistem pembayaran digital yang aman dan efisien. API kami dirancang untuk memungkinkan merchant dan pihak ketiga mengintegrasikan layanan pembayaran dengan mudah.</p>
                    <p><strong>📝 Catatan:</strong> API OnoPay tidak memerlukan autentikasi khusus. Semua endpoint dapat diakses secara publik tanpa API key atau token.</p>
                </div>

                <h3 class="section-header"><i class="bi bi-gear"></i> Informasi Teknis</h3>
                <div class="endpoint-card">
                    <p><strong>Base URL:</strong></p>
                    <div class="base-url">
                        <code id="baseUrlDisplay">{{ $baseUrl }}</code>
                        <button class="copy-btn" id="copyBaseUrlBtn" onclick="copyToClipboard(document.getElementById('baseUrlDisplay').textContent)">Copy</button>
                    </div>
                    <p><strong>Format Response:</strong> JSON</p>
                    <p><strong>Request Method:</strong> POST (untuk semua endpoint)</p>
                    <p><strong>Content-Type:</strong> application/json</p>
                </div>
            </section>

            <!-- Getting Started Section -->
            <section id="getting-started">
                <h3 class="section-header"><i class="bi bi-rocket"></i> Memulai</h3>

                <div class="endpoint-card">
                    <h5>Persyaratan</h5>
                    <ul class="desc-text">
                        <li>Koneksi internet yang stabil</li>
                        <li>Tools untuk membuat HTTP request (curl, Postman, atau HTTP client library)</li>
                        <li>Pemahaman dasar tentang REST API</li>
                    </ul>
                </div>

                <div class="endpoint-card">
                    <h5>Contoh Request Dasar dengan cURL</h5>
                    <div class="code-example">
                        <pre>curl -X POST "{{ $baseUrl }}/merchant/check-user" \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789"
  }'</pre>
                    </div>
                </div>

                <div class="endpoint-card">
                    <h5>Contoh Request dengan JavaScript/Fetch</h5>
                    <div class="code-example">
                        <pre>fetch('{{ $baseUrl }}/merchant/check-user', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    phone_number: '08123456789'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));</pre>
                    </div>
                </div>

                <div class="endpoint-card">
                    <h5>Contoh Request dengan Python</h5>
                    <div class="code-example">
                        <pre>import requests

url = '{{ $baseUrl }}/merchant/check-user'
payload = {
    'phone_number': '08123456789'
}

response = requests.post(url, json=payload)
print(response.json())</pre>
                    </div>
                </div>
            </section>

            <!-- Merchant API Section -->
            <section id="merchant-api">
                <h3 class="section-header"><i class="bi bi-shop"></i> Merchant API</h3>

                <!-- Check User Endpoint -->
                <div class="endpoint-card">
                    <div>
                        <span class="endpoint-method post">POST</span>
                        <strong>{{ $baseUrl }}/merchant/check-user</strong>
                    </div>
                    <p class="desc-text mt-2">Memeriksa keberadaan pengguna berdasarkan nomor telepon dan mengembalikan informasi dasar pengguna.</p>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Parameter Request</h6>
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>phone_number</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Nomor telepon pengguna (contoh: 08123456789)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Contoh Request</h6>
                    <div class="code-example">
                        <pre>curl -X POST "{{ $baseUrl }}/merchant/check-user" \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789"
  }'</pre>
                    </div>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Response Success (200)</h6>
                    <div class="response-example">
                        <pre>{
  "success": true,
  "message": "User ditemukan",
  "data": {
    "id": 1,
    "phone_number": "08123456789",
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "status": "active"
  }
}</pre>
                    </div>

                    <h6 style="margin-top: 15px; color: var(--danger);">Response Error (404)</h6>
                    <div class="response-example" style="border-left-color: var(--danger);">
                        <pre>{
  "success": false,
  "message": "User tidak ditemukan",
  "data": null
}</pre>
                    </div>
                </div>

                <!-- Check Balance Endpoint -->
                <div class="endpoint-card">
                    <div>
                        <span class="endpoint-method post">POST</span>
                        <strong>{{ $baseUrl }}/merchant/check-balance</strong>
                    </div>
                    <p class="desc-text mt-2">Memeriksa saldo pengguna berdasarkan nomor telepon.</p>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Parameter Request</h6>
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>phone_number</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Nomor telepon pengguna (contoh: 08123456789)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Contoh Request</h6>
                    <div class="code-example">
                        <pre>curl -X POST "{{ $baseUrl }}/merchant/check-balance" \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789"
  }'</pre>
                    </div>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Response Success (200)</h6>
                    <div class="response-example">
                        <pre>{
  "success": true,
  "message": "Balance ditemukan",
  "data": {
    "phone_number": "08123456789",
    "name": "Budi Santoso",
    "balance": 5000000
  }
}</pre>
                    </div>
                </div>
            </section>

            <!-- Payment API Section -->
            <section id="payment-api">
                <h3 class="section-header"><i class="bi bi-credit-card"></i> Payment API</h3>

                <!-- Topup Endpoint -->
                <div class="endpoint-card">
                    <div>
                        <span class="endpoint-method post">POST</span>
                        <strong>{{ $baseUrl }}/payment/topup</strong>
                    </div>
                    <p class="desc-text mt-2">Melakukan top-up saldo untuk seorang pengguna.</p>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Parameter Request</h6>
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>phone_number</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Nomor telepon pengguna</td>
                            </tr>
                            <tr>
                                <td><code>amount</code></td>
                                <td><span class="parameter-type">numeric</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Jumlah top-up (minimum: 1000)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Contoh Request</h6>
                    <div class="code-example">
                        <pre>curl -X POST "{{ $baseUrl }}/payment/topup" \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789",
    "amount": 100000
  }'</pre>
                    </div>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Response Success (200)</h6>
                    <div class="response-example">
                        <pre>{
  "success": true,
  "message": "Topup berhasil",
  "data": {
    "transaction_id": "TXN-1780366262-gUyZvt",
    "amount": 100000,
    "new_balance": 5100000,
    "status": "success"
  }
}</pre>
                    </div>
                </div>

                <!-- Generate QR Code Endpoint -->
                <div class="endpoint-card">
                    <div>
                        <span class="endpoint-method post">POST</span>
                        <strong>{{ $baseUrl }}/payment/qr/generate</strong>
                    </div>
                    <p class="desc-text mt-2">Menghasilkan kode QR untuk pembayaran. QR code ini dapat digunakan oleh pengguna lain untuk melakukan pembayaran.</p>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Parameter Request</h6>
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>phone_number</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Nomor telepon penerima pembayaran</td>
                            </tr>
                            <tr>
                                <td><code>amount</code></td>
                                <td><span class="parameter-type">numeric</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Jumlah pembayaran (minimum: 100)</td>
                            </tr>
                            <tr>
                                <td><code>merchant_code</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-optional">Optional</span></td>
                                <td>Kode merchant pembayaran</td>
                            </tr>
                            <tr>
                                <td><code>description</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-optional">Optional</span></td>
                                <td>Deskripsi pembayaran</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Contoh Request</h6>
                    <div class="code-example">
                        <pre>curl -X POST "{{ $baseUrl }}/payment/qr/generate" \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "08123456789",
    "amount": 50000,
    "merchant_code": "MERCHANT001",
    "description": "Pembayaran makanan"
  }'</pre>
                    </div>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Response Success (200)</h6>
                    <div class="response-example">
                        <pre>{
  "success": true,
  "message": "QR code berhasil dibuat",
  "data": {
    "qr_code": "QR-ABCDEF123456",
    "amount": 50000,
    "merchant_code": "MERCHANT001",
    "expires_at": "2026-06-02T02:46:07+00:00",
    "description": "Pembayaran makanan"
  }
}</pre>
                    </div>
                </div>

                <!-- Payment QR Endpoint -->
                <div class="endpoint-card">
                    <div>
                        <span class="endpoint-method post">POST</span>
                        <strong>{{ $baseUrl }}/payment/qr/pay</strong>
                    </div>
                    <p class="desc-text mt-2">Melakukan pembayaran menggunakan kode QR yang telah dihasilkan.</p>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Parameter Request</h6>
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>qr_code</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Kode QR yang telah dihasilkan</td>
                            </tr>
                            <tr>
                                <td><code>payer_phone</code></td>
                                <td><span class="parameter-type">string</span></td>
                                <td><span class="status-badge status-required">Required</span></td>
                                <td>Nomor telepon pengguna yang melakukan pembayaran</td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Contoh Request</h6>
                    <div class="code-example">
                        <pre>curl -X POST "http://127.0.0.1:8001/api/v1/payment/qr/pay" \
  -H "Content-Type: application/json" \
  -d '{
    "qr_code": "QR-ABCDEF123456",
    "payer_phone": "08777888999"
  }'</pre>
                    </div>

                    <h6 style="margin-top: 20px; color: var(--primary-dark);">Response Success (200)</h6>
                    <div class="response-example">
                        <pre>{
  "success": true,
  "message": "Pembayaran berhasil",
  "data": {
    "transaction_id": "TXN-1780366262-qTOCzT",
    "payer_phone": "08777888999",
    "receiver_phone": "08123456789",
    "amount": 50000,
    "payer_new_balance": 4950000,
    "receiver_new_balance": 5050000,
    "status": "success"
  }
}</pre>
                    </div>
                </div>
            </section>

            <!-- Payment Flow Section -->
            <section id="payment-flow">
                <h3 class="section-header"><i class="bi bi-diagram-2"></i> Complete Payment Flow (Alur Pembayaran Lengkap)</h3>

                <div class="endpoint-card">
                    <h5>⭐ Alur Pembayaran Peer-to-Peer dengan QR Code</h5>
                    <p class="desc-text">Berikut adalah alur lengkap transaksi pembayaran menggunakan OnoPay API:</p>

                    <div style="background: #f9f9f9; padding: 20px; border-radius: 6px; margin: 20px 0; line-height: 2;">
                        <p><strong style="color: var(--primary-blue);">Langkah 1:</strong> Penerima uang (Seller/Merchant) membuat permintaan pembayaran</p>
                        <p style="margin-left: 40px; color: #666;"><code>POST /payment/qr/generate</code></p>
                        <p style="margin-left: 40px; color: #666;">Input: phone_number, amount, description</p>
                        <p style="margin-left: 40px; font-size: 0.9rem; color: #999;">↓ Sistem menghasilkan unique QR code ↓</p>

                        <p><strong style="color: var(--primary-blue);">Langkah 2:</strong> QR code dikomunikasikan ke pembayar</p>
                        <p style="margin-left: 40px; color: #666;">Via: WhatsApp, Email, SMS, atau media komunikasi lainnya</p>
                        <p style="margin-left: 40px; color: #666;">QR code berlaku selama 30 menit</p>
                        <p style="margin-left: 40px; font-size: 0.9rem; color: #999;">↓ Pembayar menerima dan menginput QR code ↓</p>

                        <p><strong style="color: var(--primary-blue);">Langkah 3:</strong> Pembayar memproses pembayaran</p>
                        <p style="margin-left: 40px; color: #666;"><code>POST /payment/qr/pay</code></p>
                        <p style="margin-left: 40px; color: #666;">Input: qr_code, payer_phone</p>
                        <p style="margin-left: 40px; font-size: 0.9rem; color: #999;">↓ Sistem validasi ↓</p>

                        <div style="background: white; padding: 15px; border-left: 4px solid var(--primary-blue); margin: 20px 0;">
                            <p style="margin: 0;"><strong>Validasi yang dilakukan sistem:</strong></p>
                            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                                <li>QR code ada di database</li>
                                <li>QR code status = "active" (belum digunakan)</li>
                                <li>QR code belum expired</li>
                                <li>Payer (pembayar) active status</li>
                                <li>Payer memiliki saldo >= jumlah pembayaran</li>
                            </ul>
                        </div>

                        <p><strong style="color: #28a745;">Langkah 4:</strong> Transaksi Berhasil (✓) ⭐</p>
                        <p style="margin-left: 40px; background: #d1e7dd; padding: 10px; border-radius: 4px;">
                            ✓ Kurangi saldo payer<br>
                            ✓ Tambah saldo receiver<br>
                            ✓ Buat transaction record dengan status "success"<br>
                            ✓ Tandai QR code sebagai "used"
                        </p>
                    </div>

                    <div style="background: #e7f3ff; border-left: 4px solid var(--info); padding: 15px; border-radius: 4px; margin: 20px 0;">
                        <p style="margin: 0;"><strong style="color: #0066cc;">💡 Keunggulan API OnoPay:</strong></p>
                        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                            <li>Tidak memerlukan autentikasi API Key - akses terbuka untuk semua pihak</li>
                            <li>Atomicity terjamin - jika salah satu step gagal, seluruh transaksi dibatalkan</li>
                            <li>Real-time processing - uang langsung transfer antar akun</li>
                            <li>Keamanan tingkat enterprise - semua data terenkripsi dan tervalidasi</li>
                            <li>Error handling lengkap - setiap kemungkinan error sudah ditangani</li>
                        </ul>
                    </div>
                </div>

                <div class="endpoint-card">
                    <h5>Skenario Error & Penanganan</h5>

                    <p class="desc-text"><strong>Error 1: QR code tidak ditemukan (404)</strong></p>
                    <div class="code-example" style="background: #f8d7da; color: #721c24;">
                        <pre>{
  "success": false,
  "message": "QR code tidak ditemukan"
}</pre>
                    </div>

                    <p class="desc-text" style="margin-top: 15px;"><strong>Error 2: Saldo tidak cukup (402)</strong></p>
                    <div class="code-example" style="background: #f8d7da; color: #721c24;">
                        <pre>{
  "success": false,
  "message": "Saldo tidak cukup"
}</pre>
                    </div>
                    <p class="desc-text">Kategori status: 402 Payment Required sesuai standar HTTP</p>

                    <p class="desc-text" style="margin-top: 15px;"><strong>Error 3: QR code sudah digunakan/expired (403)</strong></p>
                    <div class="code-example" style="background: #f8d7da; color: #721c24;">
                        <pre>{
  "success": false,
  "message": "QR code tidak aktif atau sudah digunakan"
}</pre>
                    </div>

                    <p class="desc-text" style="margin-top: 15px;"><strong>Error 4: User tidak aktif (403)</strong></p>
                    <div class="code-example" style="background: #f8d7da; color: #721c24;">
                        <pre>{
  "success": false,
  "message": "User tidak aktif"
}</pre>
                    </div>
                </div>
            </section>

            <!-- Response Codes Section -->
            <section id="response-codes">
                <h3 class="section-header"><i class="bi bi-list-ul"></i> Kode Response HTTP</h3>

                <div class="endpoint-card">
                    <table class="parameter-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>200</strong></td>
                                <td><span class="status-badge" style="background-color: #d1e7dd; color: #0a3622;">OK</span></td>
                                <td>Request berhasil diproses</td>
                            </tr>
                            <tr>
                                <td><strong>400</strong></td>
                                <td><span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Bad Request</span></td>
                                <td>Parameter yang dikirim tidak valid atau kurang</td>
                            </tr>
                            <tr>
                                <td><strong>402</strong></td>
                                <td><span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Payment Required</span></td>
                                <td>Saldo pengguna tidak cukup untuk melakukan transaksi</td>
                            </tr>
                            <tr>
                                <td><strong>403</strong></td>
                                <td><span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Forbidden</span></td>
                                <td>User tidak aktif, QR code sudah expired, atau akses ditolak</td>
                            </tr>
                            <tr>
                                <td><strong>404</strong></td>
                                <td><span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Not Found</span></td>
                                <td>User atau QR code tidak ditemukan</td>
                            </tr>
                            <tr>
                                <td><strong>500</strong></td>
                                <td><span class="status-badge" style="background-color: #f8d7da; color: #721c24;">Server Error</span></td>
                                <td>Terjadi kesalahan di sisi server</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="endpoint-card">
                    <h5>Struktur Response Error</h5>
                    <p class="desc-text">Semua response error mengikuti format yang konsisten:</p>
                    <div class="code-example">
                        <pre>{
  "success": false,
  "message": "Deskripsi error",
  "data": null
}</pre>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <div style="margin-top: 60px; padding-top: 30px; border-top: 2px solid #e0e0e0; text-align: center; color: #666;">
                <p><strong>OnoPay API Documentation</strong></p>
                <p>Versi 1.0 • Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}</p>
                <p style="font-size: 0.85rem; color: #999;">API ini tersedia untuk integrasi pihak ketiga. Support: contact@onopay.com</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script>
        // Set dynamic base URL from server
        const API_BASE_URL = '{{ $baseUrl }}';

        // Replace all hardcoded URLs with dynamic base URL
        function replaceUrls() {
            document.querySelectorAll('pre, code, .base-url').forEach(el => {
                let html = el.innerHTML;
                // Replace hardcoded localhost URL with dynamic base URL
                html = html.replace(/http:\/\/127\.0\.0\.1:8001\/api\/v1/g, API_BASE_URL);
                html = html.replace(/http:\/\/localhost:8001\/api\/v1/g, API_BASE_URL);
                html = html.replace(/http:\/\/localhost\/api\/v1/g, API_BASE_URL);
                el.innerHTML = html;
            });
        }

        // Highlight code blocks
        document.querySelectorAll('pre').forEach(el => {
            hljs.highlightElement(el);
        });

        // Replace URLs after DOM ready
        document.addEventListener('DOMContentLoaded', replaceUrls);

        // Navigation
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.sidebar-nav .nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const section = this.getAttribute('data-section');
                let targetId = section;

                if (targetId.startsWith('#')) {
                    targetId = targetId.substring(1);
                }

                const element = document.getElementById(targetId);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard: ' + text);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
    </script>
</body>

</html>
