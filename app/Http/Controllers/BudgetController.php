<?php

namespace App\Http\Controllers;

use App\Services\BudgetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct(protected BudgetService $budgetService) {}

    // GET /api/budgets
    public function index(): JsonResponse
    {
        $budgets = $this->budgetService->getAll();

        return response()->json([
            'success' => true,
            'data'    => $budgets,
        ]);
    }

    // POST /api/budgets
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id'  => 'required|integer|exists:categories,category_id',
            'amount_limit' => 'required|numeric|min:1',
            'due_date'     => 'required|date|after_or_equal:today',
        ]);

        $budget = $this->budgetService->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Budget berhasil dibuat.',
            'data'    => $budget,
        ], 201);
    }

    // GET /api/budgets/{id}
    public function show(int $id): JsonResponse
    {
        $budget = $this->budgetService->getDetail($id);

        if (!$budget) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $budget,
        ]);
    }

    // PATCH /api/budgets/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'category_id'  => 'sometimes|required|integer|exists:categories,category_id',
            'amount_limit' => 'sometimes|required|numeric|min:1',
            'due_date'     => 'sometimes|required|date',
        ]);

        $budget = $this->budgetService->update($id, $validated);

        if (!$budget) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Budget berhasil diupdate.',
            'data'    => $budget,
        ]);
    }

    // DELETE /api/budgets/{id}
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->budgetService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Budget berhasil dihapus.',
        ]);
    }
}