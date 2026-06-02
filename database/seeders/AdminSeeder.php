<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::count() === 0) {
            Admin::create([
                'name' => 'Admin OnoPay',
                'email' => 'admin@onopay.local',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]);

            Admin::create([
                'name' => 'Admin Support',
                'email' => 'support@onopay.local',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }
    }
}
