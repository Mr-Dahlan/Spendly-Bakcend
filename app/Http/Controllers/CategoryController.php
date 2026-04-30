<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    // GET /api/categories
    public function index(Request $request): JsonResponse
    {
        $filters = [];
    
        if ($request->query('type')) {
            $filters['type'] = $request->query('type');
        }
    
        return response()->json([
            'success' => true,
            'data'    => $this->categoryService->getCategoryFilter($filters),
        ]);
    }

        // POST /api/categories
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = $this->categoryService->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category berhasil dibuat.',
            'data'    => $category,
        ], 201);
    }

    // GET /api/categories/{id}
    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $category,
        ]);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:income,expense',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = $this->categoryService->update($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Category berhasil diupdate.',
            'data'    => $category,
        ]);
    }

    // DELETE /api/categories/{id}
    public function destroy(int $id): JsonResponse
    {
        $this->categoryService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Category berhasil dihapus.',
        ]);
    }
}