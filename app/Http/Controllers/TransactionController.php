<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $transactionService) {}

    // GET /api/transactions
public function index(Request $request): JsonResponse
{
    $filters = array_filter([
        'type'        => $request->query('type'),
        'category_id' => $request->query('category_id'),
        'date'        => $request->query('date'),
        'month'       => $request->query('month'),
        'year'        => $request->query('year'),
        'start_date'  => $request->query('start_date'),
        'end_date'    => $request->query('end_date'),
    ]);

    $transactions = $this->transactionService->getAll($filters);
    $summary      = $this->transactionService->getSummary($filters);

    return response()->json([
        'success' => true,
        'summary' => $summary,
        'data'    => $transactions,
    ]);
}

    // POST /api/transactions
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id'      => 'required|integer|exists:categories,category_id',
            'type'             => 'required|in:income,expense',
            'amount'           => 'required|numeric|min:0',
            'description'      => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = $this->transactionService->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat.',
            'data'    => $transaction,
        ], 201);
    }

    // GET /api/transactions/{id}
    public function show(int $id): JsonResponse
    {
        $transaction = $this->transactionService->findOrFail($id);
    
        if (is_array($transaction) && !$transaction['found']) {
            return response()->json([
                'success' => false,
                'message' => $transaction['message'],
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data'    => $transaction,
        ]);
    }
    
    // PUT /api/transactions/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $check = $this->transactionService->findOrFail($id);
    
        if (is_array($check) && !$check['found']) {
            return response()->json([
                'success' => false,
                'message' => $check['message'],
            ], 404);
        }
    
        $validated = $request->validate([
            'category_id'      => 'sometimes|required|integer|exists:categories,category_id',
            'type'             => 'sometimes|required|in:income,expense',
            'amount'           => 'sometimes|required|numeric|min:0',
            'description'      => 'sometimes|required|string',
            'transaction_date' => 'sometimes|required|date',
        ]);
    
        $transaction = $this->transactionService->update($id, $validated);
    
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diupdate.',
            'data'    => $transaction,
        ]);
    }
    
    // DELETE /api/transactions/{id}
    public function destroy(int $id): JsonResponse
    {
        $check = $this->transactionService->findOrFail($id);
    
        if (is_array($check) && !$check['found']) {
            return response()->json([
                'success' => false,
                'message' => $check['message'],
            ], 404);
        }
    
        $this->transactionService->delete($id);
    
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus.',
        ]);
    }
}