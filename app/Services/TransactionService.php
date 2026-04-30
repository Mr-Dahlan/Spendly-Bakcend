<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    /**
     * Ambil semua transaksi dengan filter opsional
     */
    public function getAll(array $filters = [])
    {
        $query = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('transaction_date', 'desc');

        // Filter by type (income/expense)
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Filter by category_id
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by tanggal spesifik
        if (!empty($filters['date'])) {
            $query->whereDate('transaction_date', $filters['date']);
        }

        // Filter by bulan & tahun (contoh: month=4&year=2026)
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('transaction_date', $filters['month'])
                  ->whereYear('transaction_date', $filters['year']);
        }

        // Filter by range tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('transaction_date', [
                $filters['start_date'],
                $filters['end_date'],
            ]);
        }

        return $query->get();
    }

    /**
     * Summary: total income, expense, balance
     */
    public function getSummary(array $filters = []): array
    {
        $query = Transaction::where('user_id', Auth::id());

        // Filter by bulan & tahun
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('transaction_date', $filters['month'])
                  ->whereYear('transaction_date', $filters['year']);
        }

        // Filter by range tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('transaction_date', [
                $filters['start_date'],
                $filters['end_date'],
            ]);
        }

        $income  = (clone $query)->where('type', 'income')->sum('amount');
        $expense = (clone $query)->where('type', 'expense')->sum('amount');

        return [
            'total_income'  => (float) $income,
            'total_expense' => (float) $expense,
            'balance'       => (float) ($income - $expense),
        ];
    }

    /**
     * Buat transaksi baru
     */
    public function create(array $data): Transaction
    {
        return Transaction::create([
            'user_id'          => Auth::id(),
            'category_id'      => $data['category_id'],
            'type'             => $data['type'],
            'amount'           => $data['amount'],
            'description'      => $data['description'],
            'transaction_date' => $data['transaction_date'],
        ]);
    }

    /**
     * Ambil 1 transaksi milik user
     */
/**
 * Ambil 1 transaksi milik user
 */
    public function findOrFail(int $id): array|Transaction
    {
        $transaction = Transaction::with('category')
            ->where('transaction_id', $id)
            ->where('user_id', Auth::id())
            ->first();
    
        if (!$transaction) {
            return [
                'found'   => false,
                'message' => 'Data tidak ditemukan.',
            ];
        }
    
        return $transaction;
    }

    /**
     * Update transaksi
     */
    public function update(int $id, array $data): Transaction
    {
        $transaction = $this->findOrFail($id);

        $transaction->update([
            'category_id'      => $data['category_id']      ?? $transaction->category_id,
            'type'             => $data['type']             ?? $transaction->type,
            'amount'           => $data['amount']           ?? $transaction->amount,
            'description'      => $data['description']      ?? $transaction->description,
            'transaction_date' => $data['transaction_date'] ?? $transaction->transaction_date,
        ]);

        return $transaction->fresh('category');
    }

    /**
     * Hapus transaksi
     */
    public function delete(int $id): void
    {
        $transaction = $this->findOrFail($id);
        $transaction->delete();
    }
}