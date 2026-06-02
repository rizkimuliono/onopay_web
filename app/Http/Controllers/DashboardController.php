<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $totalBalance = User::sum('balance');
        $totalTransactions = Transaction::count();

        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $todayAmount = Transaction::whereDate('created_at', today())->sum('amount');

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->limit(10)
            ->get();

        $data = [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'totalBalance' => (float)$totalBalance,
            'totalTransactions' => $totalTransactions,
            'todayTransactions' => $todayTransactions,
            'todayAmount' => (float)$todayAmount,
            'recentTransactions' => $recentTransactions,
        ];

        return view('dashboard.index', $data);
    }
}
