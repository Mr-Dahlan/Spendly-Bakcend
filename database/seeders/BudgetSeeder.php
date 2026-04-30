<?php

namespace Database\Seeders;

use App\Models\Budget;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $userId     = 1; // Hamim
        $categoryId = 1; // Category milik Hamim

        $budgets = [
            [
                'amount_limit' => 500000,
                'due_date'     => '2026-05-31',
            ],
            [
                'amount_limit' => 1000000,
                'due_date'     => '2026-05-31',
            ],
            [
                'amount_limit' => 300000,
                'due_date'     => '2026-04-30',
            ],
        ];

        foreach ($budgets as $budget) {
            Budget::create([
                'user_id'      => $userId,
                'category_id'  => $categoryId,
                'amount_limit' => $budget['amount_limit'],
                'due_date'     => $budget['due_date'],
            ]);
        }

        $this->command->info('BudgetSeeder berhasil! ' . count($budgets) . ' budget untuk Hamim dibuat.');
    }
}