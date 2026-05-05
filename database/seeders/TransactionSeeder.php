<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $userId     = 2; // Hamim
        $categoryId = 1; // Category milik Hamim

        $transactions = [
            // ── April 2026 ──
            [
                'type'             => 'income',
                'amount'           => 5000000,
                'description'      => 'Gaji bulan April',
                'transaction_date' => '2026-04-01',
            ],
            [
                'type'             => 'expense',
                'amount'           => 150000,
                'description'      => 'Makan siang',
                'transaction_date' => '2026-04-03',
            ],
            [
                'type'             => 'expense',
                'amount'           => 50000,
                'description'      => 'Bensin motor',
                'transaction_date' => '2026-04-05',
            ],
            [
                'type'             => 'income',
                'amount'           => 750000,
                'description'      => 'Freelance desain logo',
                'transaction_date' => '2026-04-10',
            ],
            [
                'type'             => 'expense',
                'amount'           => 300000,
                'description'      => 'Belanja bulanan',
                'transaction_date' => '2026-04-12',
            ],
        ];

        foreach ($transactions as $trx) {
            Transaction::create([
                'user_id'          => $userId,
                'category_id'      => $categoryId,
                'type'             => $trx['type'],
                'amount'           => $trx['amount'],
                'description'      => $trx['description'],
                'transaction_date' => $trx['transaction_date'],
            ]);
        }

        $this->command->info('TransactionSeeder berhasil! 12 transaksi untuk Hamim dibuat.');
    }
}