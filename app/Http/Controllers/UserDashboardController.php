<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\QRCode;
use App\Models\SystemSetting;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserDashboardController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = User::find(session('user_id'));
        $recentTransactions = $user->transactions()
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', [
            'user' => $user,
            'recentTransactions' => $recentTransactions,
        ]);
    }

    // Wallet
    public function wallet()
    {
        $user = User::find(session('user_id'));
        return view('user.wallet', ['user' => $user]);
    }

    // Transactions
    public function transactions()
    {
        $user = User::find(session('user_id'));
        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('user.transactions', [
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }

    // Show payment input (untuk pembayar menginput QR code)
    public function showPaymentInput()
    {
        $user = User::find(session('user_id'));
        return view('user.payment-input', ['user' => $user]);
    }

    // Show payment create (generate QR)
    public function showPaymentCreate()
    {
        $user = User::find(session('user_id'));
        return view('user.payment-create', ['user' => $user]);
    }

    // Show user's QR list and status
    public function myQRCodes()
    {
        $user = User::find(session('user_id'));
        $qrcodes = QRCode::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('user.my-qrcodes', [
            'user' => $user,
            'qrcodes' => $qrcodes,
        ]);
    }

    // Create QR Code
    public function createQRCode(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'description' => 'nullable|string|max:255',
            'qr_mode' => 'required|in:single_use,reusable',
        ]);

        $user = User::find(session('user_id'));

        try {
            $qrCode = Str::upper('QR-' . Str::random(12));
            $qrData = json_encode([
                'code' => $qrCode,
                'user_id' => $user->id,
                'phone_number' => $user->phone_number,
                'amount' => (float)$validated['amount'],
                'qr_mode' => $validated['qr_mode'],
                'timestamp' => now()->toIso8601String(),
            ]);

            $expiresAt = $validated['qr_mode'] === 'reusable' ? null : now()->addMinutes(30);

            $qr = QRCode::create([
                'code' => $qrCode,
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? 'OnoPay Payment',
                'qr_mode' => $validated['qr_mode'],
                'qr_data' => $qrData,
                'status' => 'active',
                'expires_at' => $expiresAt,
            ]);

            return redirect()->route('user.payment-show', $qrCode)->with('success', 'QR Code berhasil dibuat');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat QR Code: ' . $e->getMessage()]);
        }
    }

    // Show QR Code detail
    public function showQRCode($qrCode)
    {
        $qr = QRCode::where('code', $qrCode)->firstOrFail();

        if ($qr->user_id !== session('user_id')) {
            abort(403, 'Unauthorized');
        }

        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data($qr->code)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(400)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        $qrImageBase64 = 'data:image/png;base64,' . base64_encode($qrResult->getString());

        return view('user.payment-show', [
            'qr' => $qr,
            'qrImageBase64' => $qrImageBase64,
        ]);
    }

    // Show payment confirmation (untuk pembayar)
    public function showPaymentConfirm($qrCode)
    {
        $qr = QRCode::where('code', $qrCode)->firstOrFail();

        if ($qr->status !== 'active') {
            return redirect()->route('user.dashboard')->withErrors(['error' => 'QR Code tidak aktif atau sudah digunakan']);
        }

        if ($qr->expires_at && $qr->expires_at < now()) {
            $qr->update(['status' => 'expired']);
            return redirect()->route('user.dashboard')->withErrors(['error' => 'QR Code sudah kadaluarsa']);
        }

        $payer = User::find(session('user_id'));
        $receiver = $qr->user;

        return view('user.payment-confirm', [
            'qr' => $qr,
            'payer' => $payer,
            'receiver' => $receiver,
        ]);
    }

    // Process payment
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string',
        ]);

        $qr = QRCode::where('code', $validated['qr_code'])->firstOrFail();
        $payer = User::find(session('user_id'));

        if ($qr->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'QR code tidak aktif',
            ], 403);
        }

        if ($qr->expires_at && $qr->expires_at < now()) {
            $qr->update(['status' => 'expired']);
            return response()->json([
                'success' => false,
                'message' => 'QR code sudah kadaluarsa',
            ], 403);
        }

        if ($payer->balance < $qr->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo tidak cukup',
            ], 402);
        }

        try {
            // Deduct from payer
            $payer->balance -= $qr->amount;
            $payer->save();

            // Add to receiver
            $receiver = $qr->user;
            $receiver->balance += $qr->amount;
            $receiver->save();

            // Create transaction linked to QR code
            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                'user_id' => $payer->id,
                'qr_code_id' => $qr->id,
                'amount' => $qr->amount,
                'type' => 'payment',
                'status' => 'success',
                'description' => $qr->description,
                'completed_at' => now(),
            ]);

            // Single-use QR becomes used after one successful payment.
            if ($qr->qr_mode === 'single_use') {
                $qr->update(['status' => 'used']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => (float)$qr->amount,
                    'receiver' => $receiver->name,
                    'new_balance' => (float)$payer->balance,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Show transaction detail
    public function showTransactionDetail($transactionId)
    {
        $transaction = Transaction::where('transaction_id', $transactionId)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('user.transaction-detail', ['transaction' => $transaction]);
    }

    // Show profile
    public function profile()
    {
        $user = User::find(session('user_id'));
        return view('user.profile', ['user' => $user]);
    }

    // Show topup form
    public function showTopup()
    {
        $user = User::find(session('user_id'));
        return view('user.topup', ['user' => $user]);
    }

    // Process topup
    public function processTopup(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000|max:50000000',
        ], [
            'amount.required' => 'Jumlah top up harus diisi',
            'amount.numeric' => 'Jumlah top up harus berupa angka',
            'amount.min' => 'Minimum top up adalah Rp 1.000',
            'amount.max' => 'Maksimum top up adalah Rp 50.000.000',
        ]);

        try {
            $user = User::find(session('user_id'));
            $amount = (float)$validated['amount'];
            $verificationEnabled = SystemSetting::getValue('topup_verification_enabled', '0') === '1';

            if ($verificationEnabled) {
                // Create transaction with pending status - needs admin verification
                $transaction = Transaction::create([
                    'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'type' => 'topup',
                    'status' => 'pending',
                    'description' => 'Top Up Saldo (Menunggu Verifikasi)',
                    'completed_at' => null,
                ]);

                return redirect()->route('user.topup')->with('success', 'Top up Anda sedang menunggu verifikasi admin. Saldo akan bertambah setelah disetujui.');
            } else {
                // Auto-approve: update balance and create successful transaction
                $user->balance += $amount;
                $user->save();

                $transaction = Transaction::create([
                    'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'type' => 'topup',
                    'status' => 'success',
                    'description' => 'Top Up Saldo',
                    'completed_at' => now(),
                ]);

                return redirect()->route('user.topup')->with('success', 'Top up berhasil! Saldo Anda bertambah Rp ' . number_format($amount, 0));
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Top up gagal: ' . $e->getMessage()]);
        }
    }
}
