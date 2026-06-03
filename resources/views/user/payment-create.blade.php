<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minta Pembayaran - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.1.5/html5-qrcode.min.js"></script>
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
            max-width: 500px;
            margin: 20px auto;
            padding: 0 15px;
            padding-bottom: 100px;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .form-title {
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.15);
        }

        .btn-submit {
            background: var(--primary-blue);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-back {
            color: #999;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .btn-back:hover {
            color: var(--primary-blue);
        }

        .info-box {
            background: var(--light-blue);
            border-left: 4px solid var(--primary-blue);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #555;
        }

        .amount-input {
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
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

        .nav-item-btn:hover {
            color: var(--primary-blue);
        }

        .nav-item-btn i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 3px;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
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
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                <strong>{{ $errors->first() }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="form-card">
            <div class="form-title">
                <i class="bi bi-qr-code"></i>
                Buat Permintaan Pembayaran
            </div>

            <div class="info-box">
                <i class="bi bi-info-circle"></i>
                Pembeli akan memindai QR Code ini untuk mengirimkan pembayaran kepada Anda.
            </div>

            <form action="{{ route('user.payment-create.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nominal (Rp)</label>
                    <input type="number" class="form-control amount-input @error('amount') is-invalid @enderror"
                           name="amount" placeholder="0" min="100" step="1000"
                           value="{{ old('amount') }}" required autocomplete="off">
                    @error('amount')
                        <small class="text-danger mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi (Opsional)</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="3" placeholder="Contoh: Pembayaran Makan Siang"
                              >{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-danger mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-qr-code"></i> Buat QR Code
                </button>
            </form>

            <hr>

            <div style="font-size: 0.85rem; color: #999; text-align: center;">
                <i class="bi bi-shield-check"></i> QR Code berlaku 30 menit
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
        <a href="#" class="nav-item-btn">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
