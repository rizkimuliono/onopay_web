<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Transaction;
use App\Models\QRCode;
use App\Models\SystemSetting;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    use ApiValidation;
    /**
     * Topup user balance
     */
    public function topup(Request $request)
    {
        try {
            $validated = $request->validate([
                'phone_number' => 'required|string',
                'amount' => 'required|numeric|min:1000',
            ], [
                'phone_number.required' => 'Phone number is required',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Amount must be a number',
                'amount.min' => 'Minimum amount is 1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak aktif',
            ], 403);
        }

        // Check if topup verification is enabled
        $verificationEnabled = SystemSetting::getValue('topup_verification_enabled', '0') === '1';

        if ($verificationEnabled) {
            // Create transaction with pending status
            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'type' => 'topup',
                'status' => 'pending',
                'description' => 'Topup saldo (Menunggu Verifikasi)',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Topup submitted for verification',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => (float)$validated['amount'],
                    'status' => 'pending',
                    'message' => 'Waiting for admin approval',
                ],
            ], 202); // 202 Accepted
        } else {
            // Auto-approve topup
            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'type' => 'topup',
                'status' => 'success',
                'description' => 'Topup saldo',
                'completed_at' => now(),
            ]);

            $user->balance += $validated['amount'];
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Topup berhasil',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => (float)$validated['amount'],
                    'new_balance' => (float)$user->balance,
                    'status' => 'success',
                ],
            ]);
        }
    }

    /**
     * Generate QR Code for payment
     */
    public function generateQR(Request $request)
    {
        try {
            $validated = $request->validate([
                'phone_number' => 'required|string',
                'amount' => 'required|numeric|min:100',
                'merchant_code' => 'nullable|string',
                'description' => 'nullable|string',
            ], [
                'phone_number.required' => 'Phone number is required',
                'amount.required' => 'Amount is required',
                'amount.numeric' => 'Amount must be a number',
                'amount.min' => 'Minimum amount is 100',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak aktif',
            ], 403);
        }

        // Generate QR data
        $qrCode = Str::upper('QR-' . Str::random(12));
        $qrData = json_encode([
            'code' => $qrCode,
            'user_id' => $user->id,
            'phone_number' => $user->phone_number,
            'amount' => (float)$validated['amount'],
            'merchant_code' => $validated['merchant_code'] ?? null,
            'timestamp' => now()->toIso8601String(),
        ]);

        // Create QR record
        $qr = QRCode::create([
            'code' => $qrCode,
            'merchant_code' => $validated['merchant_code'] ?? null,
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? 'Payment via QR Code',
            'qr_data' => $qrData,
            'status' => 'active',
            'expires_at' => now()->addMinutes(15),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'QR code berhasil dibuat',
            'data' => [
                'qr_code' => $qrCode,
                'amount' => (float)$validated['amount'],
                'merchant_code' => $validated['merchant_code'] ?? null,
                'expires_at' => $qr->expires_at->toIso8601String(),
                'description' => $qr->description,
            ],
        ]);
    }

    /**
     * Process payment via QR Code
     */
    public function paymentQR(Request $request)
    {
        try {
            $validated = $request->validate([
                'qr_code' => 'required|string',
                'payer_phone' => 'required|string',
            ], [
                'qr_code.required' => 'QR code is required',
                'payer_phone.required' => 'Payer phone number is required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        $qr = QRCode::where('code', $validated['qr_code'])->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR code tidak ditemukan',
            ], 404);
        }

        if ($qr->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'QR code tidak aktif atau sudah digunakan',
            ], 403);
        }

        if ($qr->expires_at < now()) {
            $qr->update(['status' => 'expired']);
            return response()->json([
                'success' => false,
                'message' => 'QR code sudah expired',
            ], 403);
        }

        // Get payer
        $payer = User::where('phone_number', $validated['payer_phone'])->first();

        if (!$payer) {
            return response()->json([
                'success' => false,
                'message' => 'Payer tidak ditemukan',
            ], 404);
        }

        if ($payer->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Payer tidak aktif',
            ], 403);
        }

        if ($payer->balance < $qr->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo tidak cukup',
            ], 402);
        }

        // Process payment
        try {
            // Deduct from payer
            $payer->balance -= $qr->amount;
            $payer->save();

            // Add to receiver
            $receiver = $qr->user;
            $receiver->balance += $qr->amount;
            $receiver->save();

            // Create transaction
            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                'user_id' => $payer->id,
                'merchant_code' => $qr->merchant_code,
                'amount' => $qr->amount,
                'type' => 'payment',
                'status' => 'success',
                'description' => $qr->description,
                'completed_at' => now(),
            ]);

            // Mark QR as used
            $qr->update(['status' => 'used']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => (float)$qr->amount,
                    'receiver' => $receiver->name,
                    'payer_new_balance' => (float)$payer->balance,
                    'status' => 'success',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API Index method (not used for payment API)
     */
    public function index()
    {
        //
    }

    /**
     * API Store method (not used for payment API)
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * API Show method (not used for payment API)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * API Update method (not used for payment API)
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * API Destroy method (not used for payment API)
     */
    public function destroy(string $id)
    {
        //
    }
}

