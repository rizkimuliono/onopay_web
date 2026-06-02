<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class TransactionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('phone_number', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(20);

        return view('transaction.index', [
            'transactions' => $transactions,
            'status' => $request->status,
            'type' => $request->type,
            'search' => $request->search,
        ]);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user');
        return view('transaction.show', ['transaction' => $transaction]);
    }

    public function edit(Transaction $transaction)
    {
        $transaction->load('user');
        return view('transaction.edit', ['transaction' => $transaction]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,success,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transaction.show', $transaction)
            ->with('success', 'Transaksi berhasil diperbarui');
    }
}
