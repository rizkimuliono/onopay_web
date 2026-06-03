<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar dengan QR - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container-main {
            max-width: 100%;
            padding: 20px;
            padding-bottom: 100px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .input-card {
            background: white;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .input-group input::placeholder {
            color: #ccc;
        }

        .btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            border: none;
            color: white;
            padding: 14px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }

        .btn-secondary-custom {
            background: white;
            border: 2px solid #e0e0e0;
            color: var(--primary-dark);
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #0066cc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box strong {
            color: var(--primary-dark);
            display: block;
            margin-bottom: 5px;
        }

        .info-box small {
            color: #666;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            gap: 10px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            color: #999;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .error-message {
            background: #f8d7da;
            color: #842029;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            display: none;
        }

        .bottom-nav {
            background: white;
            border-top: 1px solid #e0e0e0;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-item-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px;
            text-align: center;
            color: #999;
            font-size: 0.75rem;
            cursor: pointer;
            text-decoration: none;
        }

        .nav-item-btn.active {
            color: var(--primary-blue);
        }

        .nav-item-btn:hover {
            color: var(--primary-blue);
        }

        .nav-item-btn i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 3px;
        }

        .help-text {
            font-size: 0.85rem;
            color: #999;
            margin-top: 10px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('user.dashboard') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-chevron-left"></i> Kembali
            </a>
            <div style="font-weight: 700;"><i class="bi bi-wallet2"></i> OnoPay</div>
            <div style="width: 40px;"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container-main">
        <!-- Header -->
        <div style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-dark); font-weight: 700; margin-bottom: 10px;">Bayar dengan QR Code</h2>
            <p style="color: #999; margin: 0;">Masukkan kode QR yang ingin Anda bayar</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <strong><i class="bi bi-info-circle"></i> Bagaimana cara membayar?</strong>
            <small>
                1. Minta kode QR dari penerima<br>
                2. Masukkan kode atau scan menggunakan kamera<br>
                3. Konfirmasi pembayaran dan selesai
            </small>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Input Card -->
        <div class="input-card">
            <form id="qrForm" onsubmit="handleSubmit(event)">
                @csrf

                <div class="input-group">
                    <label for="qrCode">Kode QR / Referensi Pembayaran</label>
                    <input
                        type="text"
                        id="qrCode"
                        name="qr_code"
                        placeholder="Contoh: QR-A1B2C3D4E5F6"
                        required
                        autocomplete="off"
                        style="text-transform: uppercase; letter-spacing: 0.5px;"
                    />
                    <div class="help-text">
                        <i class="bi bi-lightbulb"></i> Format kode: QR-XXXXXXXXXX (10-12 karakter)
                    </div>
                </div>

                <!-- Buttons -->
                <div class="btn-group">
                    <button type="button" class="btn-secondary-custom" onclick="resetForm()">
                        <i class="bi bi-arrow-counterclockwise"></i> Bersihkan
                    </button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-arrow-right"></i> Lanjutkan
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>ATAU</span>
            </div>

            <!-- Scan Button -->
            <button class="btn-primary-custom" style="width: 100%; background: white; color: var(--primary-blue); border: 2px solid var(--primary-blue);" onclick="startScanner()">
                <i class="bi bi-camera"></i> Scan QR Code
            </button>
        </div>

        <!-- Camera Scanner (Hidden) -->
        <div id="scannerContainer" style="display: none; margin-top: 20px;">
            <div class="card" style="padding: 20px;">
                <div style="text-align: center; margin-bottom: 15px;">
                    <h5 style="color: var(--primary-dark);">Aktifkan Kamera</h5>
                    <small style="color: #999;">Arahkan kamera ke QR Code</small>
                </div>
                <video id="video" style="width: 100%; border-radius: 8px; margin-bottom: 15px;"></video>
                <button type="button" class="btn-secondary-custom" style="width: 100%;" onclick="stopScanner()">
                    <i class="bi bi-x-circle"></i> Tutup Kamera
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-item-btn">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('user.wallet') }}" class="nav-item-btn">
            <i class="bi bi-wallet2"></i>
            <span>Wallet</span>
        </a>
        <a href="{{ route('user.transactions') }}" class="nav-item-btn">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('user.profile') }}" class="nav-item-btn">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleSubmit(e) {
            e.preventDefault();
            const qrCode = document.getElementById('qrCode').value.trim().toUpperCase();

            if (!qrCode) {
                showError('Masukkan kode QR terlebih dahulu');
                return;
            }

            // Redirect to payment confirmation page
            window.location.href = `{{ route('user.payment-confirm', '') }}/${qrCode}`;
        }

        function resetForm() {
            document.getElementById('qrForm').reset();
            document.getElementById('qrCode').focus();
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';

            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        function startScanner() {
            const scannerContainer = document.getElementById('scannerContainer');
            const video = document.getElementById('video');

            scannerContainer.style.display = 'block';

            // Check for browser support
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' }
                }).then(stream => {
                    video.srcObject = stream;
                    video.play();
                }).catch(err => {
                    showError('Tidak dapat mengakses kamera. Silakan gunakan input manual.');
                    scannerContainer.style.display = 'none';
                    console.error('Camera error:', err);
                });
            } else {
                showError('Browser Anda tidak mendukung akses kamera');
            }
        }

        function stopScanner() {
            const video = document.getElementById('video');
            const scannerContainer = document.getElementById('scannerContainer');

            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }

            scannerContainer.style.display = 'none';
        }

        // Auto focus on load
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('qrCode').focus();
        });
    </script>
</body>
</html>
