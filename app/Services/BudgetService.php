<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class BudgetService
{
    // Batas warning — 80% dari budget terpakai
    const WARNING_THRESHOLD = 80;

    /**
     * Hitung detail pemakaian budget
     */
    private function calculateUsage(Budget $budget): array
    {
        // Total expense pada kategori ini sampai due_date
        $spent = Transaction::where('user_id', Auth::id())
            ->where('category_id', $budget->category_id)
            ->where('type', 'expense')
            ->whereDate('transaction_date', '<=', $budget->due_date)
            ->sum('amount');

        $limit      = (float) $budget->amount_limit;
        $spent      = (float) $spent;
        $remaining  = $limit - $spent;
        $percentage = $limit > 0 ? round(($spent / $limit) * 100, 2) : 0;

        return [
            'amount_limit' => $limit,
            'spent'        => $spent,
            'remaining'    => max(0, $remaining),
            'percentage'   => $percentage,
            'is_exceeded'  => $spent > $limit,
            'is_warning'   => !($spent > $limit) && $percentage >= self::WARNING_THRESHOLD,
            'status'       => $spent > $limit
                ? 'exceeded'
                : ($percentage >= self::WARNING_THRESHOLD ? 'warning' : 'safe'),
        ];
    }

    /**
     * Ambil semua budget milik user
     */
    public function getAll(): array
    {
        $budgets = Budget::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('due_date', 'asc')
            ->get();

        return $budgets->map(function ($budget) {
            return array_merge(
                $budget->toArray(),
                ['usage' => $this->calculateUsage($budget)]
            );
        })->toArray();
    }

    /**
     * Ambil 1 budget milik user
     */
    public function find(int $id): ?Budget
    {
        return Budget::with('category')
            ->where('budget_id', $id)
            ->where('user_id', Auth::id())
            ->first();
    }

    /**
     * Detail 1 budget + usage
     */
    public function getDetail(int $id): ?array
    {
        $budget = $this->find($id);

        if (!$budget) return null;

        return array_merge(
            $budget->toArray(),
            ['usage' => $this->calculateUsage($budget)]
        );
    }

    /**
     * Buat budget baru
     */
    public function create(array $data): array
    {
        $budget = Budget::create([
            'user_id'      => Auth::id(),
            'category_id'  => $data['category_id'],
            'amount_limit' => $data['amount_limit'],
            'due_date'     => $data['due_date'],
        ]);

        $budget->load('category');

        return array_merge(
            $budget->toArray(),
            ['usage' => $this->calculateUsage($budget)]
        );
    }

    /**
     * Update budget (PATCH — sebagian field)
     */
    public function update(int $id, array $data): ?array
    {
        $budget = $this->find($id);

        if (!$budget) return null;

        $budget->update([
            'category_id'  => $data['category_id']  ?? $budget->category_id,
            'amount_limit' => $data['amount_limit']  ?? $budget->amount_limit,
            'due_date'     => $data['due_date']      ?? $budget->due_date,
        ]);

        $budget = $budget->fresh('category');

        return array_merge(
            $budget->toArray(),
            ['usage' => $this->calculateUsage($budget)]
        );
    }

    /**
     * Hapus budget
     */
    public function delete(int $id): bool
    {
        $budget = $this->find($id);

        if (!$budget) return false;

        $budget->delete();
        return true;
    }
}