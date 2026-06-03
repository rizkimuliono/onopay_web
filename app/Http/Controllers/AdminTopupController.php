<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\BalanceAdjustment;
use Illuminate\Http\Request;

class AdminTopupController extends Controller
{
    /**
     * Show pending topups
     */
    public function showPending()
    {
        $pendingTopups = Transaction::where('type', 'topup')
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $pendingCount = $pendingTopups->count();
        $pendingAmount = $pendingTopups->sum('amount');

        return view('admin.topup-pending', [
            'pendingTopups' => $pendingTopups,
            'pendingCount' => $pendingCount,
            'pendingAmount' => $pendingAmount,
        ]);
    }

    /**
     * Approve topup
     */
    public function approve($topupId)
    {
        $topup = Transaction::findOrFail($topupId);

        if ($topup->type !== 'topup' || $topup->status !== 'pending') {
            return back()->withErrors(['error' => 'Topup tidak valid atau sudah diproses']);
        }

        try {
            // Update user balance
            $user = $topup->user;
            $user->balance += $topup->amount;
            $user->save();

            // Update transaction status
            $topup->update([
                'status' => 'success',
                'completed_at' => now(),
                'notes' => 'Approved by ' . auth()->user()->name,
            ]);

            return back()->with('success', 'Topup berhasil disetujui! Saldo user ditambah Rp ' . number_format($topup->amount, 0));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal approve topup: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject topup
     */
    public function reject($topupId)
    {
        $topup = Transaction::findOrFail($topupId);

        if ($topup->type !== 'topup' || $topup->status !== 'pending') {
            return back()->withErrors(['error' => 'Topup tidak valid atau sudah diproses']);
        }

        try {
            $topup->update([
                'status' => 'failed',
                'notes' => 'Rejected by ' . auth()->user()->name,
            ]);

            return back()->with('success', 'Topup ditolak');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal reject topup: ' . $e->getMessage()]);
        }
    }

    /**
     * Show settings page
     */
    public function showSettings()
    {
        $verificationEnabled = SystemSetting::getValue('topup_verification_enabled', '0') === '1';

        return view('admin.topup-settings', [
            'verificationEnabled' => $verificationEnabled,
        ]);
    }

    /**
     * Update verification setting
     */
    public function updateSettings(Request $request)
    {
        $value = $request->has('topup_verification_enabled') ? '1' : '0';

        SystemSetting::setValue('topup_verification_enabled', $value);

        $message = $value === '1'
            ? 'Verifikasi topup diaktifkan'
            : 'Verifikasi topup dinonaktifkan';

        return back()->with('success', $message);
    }

    /**
     * Show balance verification page
     */
    public function showBalanceVerification()
    {
        $users = User::orderBy('name')->get();
        $adjustments = BalanceAdjustment::with('user', 'admin')
            ->latest()
            ->limit(50)
            ->get();

        return view('admin.balance-verification', [
            'users' => $users,
            'adjustments' => $adjustments,
        ]);
    }

    /**
     * Get user balance info
     */
    public function getUserBalance($userId)
    {
        $user = User::findOrFail($userId);
        $adjustmentHistory = BalanceAdjustment::where('user_id', $userId)
            ->with('admin')
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'balance' => (float)$user->balance,
            ],
            'adjustment_history' => $adjustmentHistory,
        ]);
    }

    /**
     * Adjust user balance
     */
    public function adjustBalance(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:onopay_users,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:add,subtract',
            'reason' => 'required|string|max:255',
        ], [
            'user_id.required' => 'Pilih user terlebih dahulu',
            'amount.required' => 'Jumlah harus diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'amount.min' => 'Jumlah minimal 0.01',
            'type.required' => 'Tipe adjustment harus dipilih',
            'type.in' => 'Tipe adjustment tidak valid',
            'reason.required' => 'Alasan harus diisi',
        ]);

        try {
            $user = User::findOrFail($validated['user_id']);
            $amount = (float)$validated['amount'];
            $balanceBefore = $user->balance;

            // Calculate new balance
            if ($validated['type'] === 'add') {
                $user->balance += $amount;
            } else {
                if ($user->balance < $amount) {
                    return back()->withErrors(['error' => 'Saldo tidak cukup untuk dikurangi']);
                }
                $user->balance -= $amount;
            }

            $balanceAfter = $user->balance;
            $user->save();

            // Record adjustment
            BalanceAdjustment::create([
                'user_id' => $user->id,
                'admin_id' => auth()->user()->id,
                'amount' => $amount,
                'type' => $validated['type'],
                'reason' => $validated['reason'],
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
            ]);

            $action = $validated['type'] === 'add' ? 'ditambah' : 'dikurangi';
            $message = "Saldo user {$user->name} {$action} Rp " . number_format($amount, 0);

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal adjust balance: ' . $e->getMessage()]);
        }
    }
}
