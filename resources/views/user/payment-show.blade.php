<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Pembayaran - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h3 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .amount-display {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 15px 0;
        }

        .description-text {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .qr-box {
            background: #f5f7fa;
            border: 2px dashed #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 250px;
        }

        #qrcode {
            max-width: 100%;
            height: auto;
        }

        .code-text {
            background: var(--light-blue);
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--primary-dark);
            word-break: break-all;
            font-size: 0.9rem;
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #0066cc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
        }

        .info-box strong {
            color: var(--primary-dark);
            display: block;
            margin-bottom: 5px;
        }

        .info-box small {
            color: #666;
        }

        .expiry-badge {
            display: inline-block;
            background: #fff3cd;
            color: #664d03;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }

        .btn-secondary-custom {
            background: white;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: var(--light-blue);
        }

        .timer {
            font-size: 0.85rem;
            color: #ff6b6b;
            font-weight: 600;
            margin-top: 10px;
        }

        .status-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 10px;
        }

        .link-group {
            margin-top: 15px;
        }

        .link-group a {
            display: block;
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.85rem;
            margin: 8px 0;
        }

        .link-group a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <!-- Header -->
        <div class="header">
            <div class="status-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3>QR Code Pembayaran Anda</h3>
            <p style="color: #999; margin: 0; font-size: 0.9rem;">Bagikan ke pembeli untuk menerima pembayaran</p>
        </div>

        <!-- Amount -->
        <div class="amount-display">
            Rp{{ number_format($qr->amount, 0) }}
        </div>

        <!-- Description -->
        @if ($qr->description)
            <div class="description-text">
                <i class="bi bi-file-text"></i> {{ $qr->description }}
            </div>
        @endif

        <!-- Expiry Info -->
        <div class="expiry-badge">
            <i class="bi bi-clock"></i> Berlaku hingga {{ $qr->expires_at->format('H:i') }}
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <strong><i class="bi bi-info-circle"></i> Cara Penggunaan</strong>
            <small>
                1. Bagikan kode QR ke pembeli<br>
                2. Pembeli scan dengan aplikasi OnoPay<br>
                3. Pembayaran langsung masuk ke akun Anda
            </small>
        </div>

        <!-- QR Code Display -->
        <div class="qr-box">
            <div id="qrcode"></div>
        </div>

        <!-- QR Code Text -->
        <div class="code-text">
            {{ $qr->code }}
        </div>

        <!-- Action Buttons -->
        <div class="button-group">
            <button class="btn-primary-custom" onclick="downloadQR()">
                <i class="bi bi-download"></i> Download
            </button>
            <button class="btn-secondary-custom" onclick="shareQR()">
                <i class="bi bi-share"></i> Bagikan
            </button>
        </div>

        <!-- Additional Links -->
        <div class="link-group">
            <a href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
            <a href="{{ route('user.payment-create') }}">+ Buat QR Lain</a>
        </div>

        <!-- Timer -->
        <div class="timer" id="timer">
            Sisa waktu: <span id="countdown"></span>
        </div>
    </div>

    <script>
        // Generate QR Code
        const qrCode = new QRCode(document.getElementById('qrcode'), {
            text: '{{ $qr->code }}',
            width: 200,
            height: 200,
            colorDark: '#003d7a',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

        // Countdown Timer
        function updateCountdown() {
            const expiryTime = new Date('{{ $qr->expires_at }}').getTime();
            const now = new Date().getTime();
            const distance = expiryTime - now;

            if (distance < 0) {
                document.getElementById('countdown').textContent = 'Kadaluarsa';
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown').textContent =
                (minutes < 10 ? '0' + minutes : minutes) + ':' +
                (seconds < 10 ? '0' + seconds : seconds);
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Download QR Code
        function downloadQR() {
            const canvas = document.querySelector('#qrcode canvas');
            const link = document.createElement('a');
            link.href = canvas.toDataURL();
            link.download = 'qr-payment-{{ $qr->code }}.png';
            link.click();
        }

        // Share QR Code
        async function shareQR() {
            const text = `Bayar saya Rp{{ number_format($qr->amount, 0) }} via OnoPay\nKode QR: {{ $qr->code }}`;

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Permintaan Pembayaran OnoPay',
                        text: text
                    });
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        copyToClipboard(text);
                    }
                }
            } else {
                copyToClipboard(text);
            }
        }

        // Copy to Clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Kode QR dan nominal berhasil disalin!');
            });
        }
    </script>
</body>
</html>
