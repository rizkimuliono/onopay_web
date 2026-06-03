<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
            --success: #28a745;
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

        .payment-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .payment-header .title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .payment-header .amount {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 15px 0;
        }

        .payment-header .description {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .payment-body {
            padding: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.95rem;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #999;
            font-weight: 600;
        }

        .detail-value {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .balance-info {
            background: var(--light-blue);
            border-left: 4px solid var(--primary-blue);
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .balance-info .label {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 5px;
        }

        .balance-info .amount {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .balance-warning {
            background: #ffe0e0;
            border-left: 4px solid #dc3545;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            display: none;
        }

        .balance-warning.show {
            display: block;
        }

        .btn-pay {
            background: var(--success);
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            width: 100%;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-pay:hover:not(:disabled) {
            background: #218838;
            color: white;
        }

        .btn-pay:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-cancel {
            background: #e0e0e0;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            color: #555;
            width: 100%;
            font-size: 0.95rem;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-cancel:hover {
            background: #d0d0d0;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            width: 50px;
            height: 50px;
        }

        .receiver-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            margin: 15px 0 0 0;
        }

        .receiver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .receiver-info {
            flex: 1;
        }

        .receiver-name {
            font-weight: 700;
            color: var(--primary-dark);
        }

        .receiver-phone {
            font-size: 0.9rem;
            color: #999;
        }

        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .success-modal.show {
            display: flex;
        }

        .success-content {
            background: white;
            border-radius: 20px;
            text-align: center;
            padding: 40px;
            max-width: 400px;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 1.5rem;
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-message {
            color: #666;
            margin-bottom: 20px;
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

        <div class="payment-card">
            <!-- Header -->
            <div class="payment-header">
                <div class="title">Konfirmasi Pembayaran</div>
                <div class="amount">Rp {{ number_format($qr->amount, 0) }}</div>
                <div class="description">{{ $qr->description ?? 'Pembayaran OnoPay' }}</div>
            </div>

            <!-- Body -->
            <div class="payment-body">
                <!-- Detail Penerima -->
                <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0;">
                    <div style="font-size: 0.85rem; color: #999; margin-bottom: 10px;">PENERIMA PEMBAYARAN</div>
                    <div class="receiver-profile">
                        <div class="receiver-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="receiver-info">
                            <div class="receiver-name">{{ $receiver->name }}</div>
                            <div class="receiver-phone">{{ $receiver->phone_number }}</div>
                        </div>
                    </div>
                </div>

                <!-- Saldo Pembayar -->
                <div class="balance-info">
                    <div class="label">Saldo Anda Saat Ini</div>
                    <div class="amount">Rp {{ number_format($payer->balance, 0) }}</div>
                </div>

                <!-- Warning -->
                <div class="balance-warning" id="balanceWarning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Saldo Tidak Cukup</strong><br>
                    <small>Anda memerlukan minimal Rp {{ number_format($qr->amount, 0) }} untuk melakukan pembayaran ini.</small>
                </div>

                <!-- Detail Transaksi -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <div class="detail-row">
                        <span class="detail-label">Nominal</span>
                        <span class="detail-value">Rp {{ number_format($qr->amount, 0) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nomor Referensi</span>
                        <span class="detail-value" style="font-size: 0.85rem; word-break: break-all;">{{ $qr->code }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Berlaku Sampai</span>
                        <span class="detail-value">{{ $qr->expires_at->format('H:i') }}</span>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2" style="color: #999;">Memproses pembayaran...</p>
                </div>

                <!-- Action Buttons -->
                <button class="btn btn-pay" id="payButton" @if($payer->balance < $qr->amount) disabled @endif>
                    <i class="bi bi-check-circle"></i> Bayar Sekarang
                </button>
                <button class="btn btn-cancel" onclick="window.location.href='{{ route('user.dashboard') }}'">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-content">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="success-title">Pembayaran Berhasil!</div>
            <div class="success-message">
                <p id="successMessage">Pembayaran Anda telah diterima</p>
            </div>
            <button class="btn btn-primary w-100" onclick="window.location.href='{{ route('user.dashboard') }}'">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const payButton = document.getElementById('payButton');
        const balanceWarning = document.getElementById('balanceWarning');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const successModal = document.getElementById('successModal');

        const payerBalance = {{ $payer->balance }};
        const qrAmount = {{ $qr->amount }};
        const qrCode = '{{ $qr->code }}';

        // Update warning status
        if (payerBalance < qrAmount) {
            balanceWarning.classList.add('show');
        }

        // Handle payment
        payButton.addEventListener('click', async function() {
            if (payerBalance < qrAmount) {
                alert('Saldo Anda tidak cukup untuk melakukan pembayaran ini');
                return;
            }

            payButton.disabled = true;
            loadingSpinner.style.display = 'block';

            try {
                const response = await fetch('{{ route("user.payment-process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        qr_code: qrCode
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Show success modal
                    document.getElementById('successMessage').innerHTML = `
                        <strong>Pembayaran Rp ${new Intl.NumberFormat('id-ID').format(data.data.amount)} berhasil!</strong><br>
                        <small>Kepada: <strong>${data.data.receiver}</strong><br>
                        Saldo baru Anda: Rp ${new Intl.NumberFormat('id-ID').format(data.data.new_balance)}</small>
                    `;
                    successModal.classList.add('show');

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("user.dashboard") }}';
                    }, 2000);
                } else {
                    alert('Pembayaran gagal: ' + data.message);
                    payButton.disabled = false;
                    loadingSpinner.style.display = 'none';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses pembayaran');
                payButton.disabled = false;
                loadingSpinner.style.display = 'none';
            }
        });
    </script>
</body>
</html>
