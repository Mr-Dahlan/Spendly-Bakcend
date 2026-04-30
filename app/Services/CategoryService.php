<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    // AMBIL SEMUA DATA CATEGORY
    public function getAll()
    {
        return Category::where('user_id', Auth::user()->user_id)->get();
    }

    public function getCategoryFilter(array $filters = [])
    {
        $query = Category::where('user_id', Auth::user()->user_id);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->orderBy('nama', 'asc')->get();
    }

    public function create(array $data): Category
    {
        return Category::create([
            'user_id' => Auth::user()->user_id,       
            'nama'    => $data['nama'],    
            'type'    => $data['type'],    
            'icon'    => $data['icon'] ?? null, 
        ]);
    }

    public function findOrFail(int $id): Category
    {
        return Category::where('category_id', $id)
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->findOrFail($id);

        $category->update([
            'nama' => $data['nama'] ?? $category->nama,
            'type' => $data['type'] ?? $category->type,
            'icon' => $data['icon'] ?? $category->icon,
        ]);

        return $category->fresh();
    }

    public function delete(int $id): void
    {
        $category = $this->findOrFail($id);
        $category->delete();
    }
}