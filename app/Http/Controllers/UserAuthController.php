<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.user-login');
    }

    // Process login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ], [
            'phone_number.required' => 'Nomor telepon harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return redirect()->back()->withErrors(['login' => 'Nomor telepon atau password salah']);
        }

        if ($user->status !== 'active') {
            return redirect()->back()->withErrors(['login' => 'Akun Anda tidak aktif']);
        }

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_phone' => $user->phone_number,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Selamat datang, ' . $user->name);
    }

    // Show register form
    public function showRegister()
    {
        if (session()->has('user_id')) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.user-register');
    }

    // Process register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:onopay_users,email',
            'phone_number' => 'required|string|unique:onopay_users,phone_number',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone_number.required' => 'Nomor telepon harus diisi',
            'phone_number.unique' => 'Nomor telepon sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'balance' => 0,
            'status' => 'active',
        ]);

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_phone' => $user->phone_number,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di OnoPay');
    }

    // Logout
    public function logout()
    {
        session()->forget(['user_id', 'user_name', 'user_phone']);
        return redirect()->route('user.login')->with('success', 'Anda telah logout');
    }
}
