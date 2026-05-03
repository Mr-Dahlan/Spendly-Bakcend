<?php
namespace App\Http\Controllers;

use App\Services\AdminLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    // POST /api/admin/logs — buat log secara manual
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'target_user_id' => ['required', 'string'],
            'action'         => ['required', 'string', 'max:100'],
            'description'    => ['required', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $log = $this->adminLogService->create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Log berhasil dicatat.',
            'data'    => $log,
        ], 201);
    }
}