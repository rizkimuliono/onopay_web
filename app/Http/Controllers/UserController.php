<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20);

        return view('user.index', [
            'users' => $users,
            'search' => $request->search,
            'status' => $request->status,
        ]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|unique:onopay_users,phone_number|regex:/^08[0-9]{8,11}$/',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|unique:onopay_users,email|email',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,blocked',
        ]);

            $validated = $request->validate([
                'phone_number' => 'required|unique:onopay_users,phone_number|regex:/^08[0-9]{8,11}$/',
                'name' => 'required|string|min:3|max:100',
                'email' => 'required|unique:onopay_users,email|email',
                'password' => 'required|string|min:8',
                'balance' => 'required|numeric|min:0',
                'status' => 'required|in:active,inactive,blocked',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^08[0-9]{8,11}$/|unique:onopay_users,phone_number,' . $user->id,
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:onopay_users,email,' . $user->id,
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,blocked',
        ]);

            $validated = $request->validate([
                'phone_number' => 'required|regex:/^08[0-9]{8,11}$/|unique:onopay_users,phone_number,' . $user->id,
                'name' => 'required|string|min:3|max:100',
                'email' => 'required|email|unique:onopay_users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'balance' => 'required|numeric|min:0',
                'status' => 'required|in:active,inactive,blocked',
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

        return redirect()->route('user.show', $user)
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
