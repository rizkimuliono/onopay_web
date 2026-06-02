<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Check user by phone number
     */
    public function checkUser(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
        ]);

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User ditemukan',
            'data' => [
                'id' => $user->id,
                'phone_number' => $user->phone_number,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
            ],
        ]);
    }

    /**
     * Check user balance
     */
    public function checkBalance(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
        ]);

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak aktif',
                'data' => null,
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Balance ditemukan',
            'data' => [
                'phone_number' => $user->phone_number,
                'name' => $user->name,
                'balance' => (float)$user->balance,
            ],
        ]);
    }

    /**
     * API Index method (not used for merchant API)
     */
    public function index()
    {
        //
    }

    /**
     * API Store method (not used for merchant API)
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * API Show method (not used for merchant API)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * API Update method (not used for merchant API)
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * API Destroy method (not used for merchant API)
     */
    public function destroy(string $id)
    {
        //
    }
}

