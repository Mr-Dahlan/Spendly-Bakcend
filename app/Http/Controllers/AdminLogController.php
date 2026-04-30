<?php

namespace App\Http\Controllers;

use App\Services\AdminLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function __construct(protected AdminLogService $adminLogService) {}

    // GET /api/admin/logs — semua log
    public function index(Request $request): JsonResponse
    {
        $filters = array_filter([
            'admin_id'       => $request->query('admin_id'),
            'target_user_id' => $request->query('target_user_id'),
            'action'         => $request->query('action'),
            'date'           => $request->query('date'),
            'month'          => $request->query('month'),
            'year'           => $request->query('year'),
        ]);

        $logs = $this->adminLogService->getAll($filters);

        return response()->json([
            'success' => true,
            'total'   => $logs->count(),
            'data'    => $logs,
        ]);
    }

    // GET /api/admin/logs/mine — log milik admin yang login
    public function myLogs(Request $request): JsonResponse
    {
        $filters = array_filter([
            'action' => $request->query('action'),
            'date'   => $request->query('date'),
            'month'  => $request->query('month'),
            'year'   => $request->query('year'),
        ]);

        $logs = $this->adminLogService->getMyLogs($filters);

        return response()->json([
            'success' => true,
            'total'   => $logs->count(),
            'data'    => $logs,
        ]);
    }
}