<?php

namespace App\Services;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;

class AdminLogService
{
    /**
     * Catat aksi admin — dipanggil otomatis dari service lain
     */
    public function log(string $action, string $description, int|string $targetUserId): void
    {
        AdminLog::create([
            'admin_id'       => Auth::id(),
            'target_user_id' => $targetUserId,
            'action'         => $action,
            'description'    => $description,
        ]);
    }

    /**
     * Buat log secara manual via request (dari controller store)
     */
    public function create(array $data): AdminLog
    {
        return AdminLog::create([
            'admin_id'       => Auth::id(),
            'target_user_id' => $data['target_user_id'],
            'action'         => $data['action'],
            'description'    => $data['description'],
        ]);
    }

    /**
     * Ambil semua log dengan filter opsional
     */
    public function getAll(array $filters = [])
    {
        $query = AdminLog::with('admin')
            ->orderBy('created_at', 'desc');

        if (!empty($filters['admin_id'])) {
            $query->where('admin_id', $filters['admin_id']);
        }

        if (!empty($filters['target_user_id'])) {
            $query->where('target_user_id', $filters['target_user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', 'like', '%' . $filters['action'] . '%');
        }

        if (!empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('created_at', $filters['month'])
                  ->whereYear('created_at', $filters['year']);
        }

        return $query->get();
    }

    /**
     * Ambil log milik admin yang sedang login
     */
    public function getMyLogs(array $filters = [])
    {
        $filters['admin_id'] = Auth::id();
        return $this->getAll($filters);
    }
}