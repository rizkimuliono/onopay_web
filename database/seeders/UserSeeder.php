<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use App\Models\QRCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed if no users exist
        if (User::count() > 0) {
            return;
        }

        // Create sample users
        $users = [
            [
                'phone_number' => '08123456789',
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'balance' => 5000000,
                'status' => 'active',
            ],
            [
                'phone_number' => '08987654321',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'balance' => 2500000,
                'status' => 'active',
            ],
            [
                'phone_number' => '08111222333',
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'balance' => 1000000,
                'status' => 'active',
            ],
            [
                'phone_number' => '08444555666',
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'balance' => 7500000,
                'status' => 'active',
            ],
            [
                'phone_number' => '08777888999',
                'name' => 'Roni Permana',
                'email' => 'roni@example.com',
                'balance' => 3000000,
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Create sample transactions
        $statuses = ['success', 'pending', 'failed', 'cancelled'];
        $types = ['payment', 'topup', 'transfer'];

        for ($i = 0; $i < 50; $i++) {
            Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . Str::random(6),
                'user_id' => rand(1, 5),
                'merchant_code' => rand(0, 1) ? 'MERCHANT-' . rand(100, 999) : null,
                'amount' => rand(100000, 5000000),
                'type' => $types[array_rand($types)],
                'status' => $statuses[array_rand($statuses)],
                'description' => 'Transaksi sampel',
                'completed_at' => now()->subDays(rand(0, 30)),
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        // Create sample QR codes
        for ($i = 0; $i < 10; $i++) {
            $qrCode = Str::upper('QR-' . Str::random(12));
            QRCode::create([
                'code' => $qrCode,
                'merchant_code' => 'MERCHANT-' . rand(100, 999),
                'user_id' => rand(1, 5),
                'amount' => rand(100000, 1000000),
                'description' => 'QR Code untuk pembayaran',
                'qr_data' => json_encode([
                    'code' => $qrCode,
                    'user_id' => rand(1, 5),
                    'timestamp' => now()->toIso8601String(),
                ]),
                'status' => ['active', 'used', 'expired'][array_rand(['active', 'used', 'expired'])],
                'expires_at' => now()->addMinutes(15),
            ]);
        }
    }
}

