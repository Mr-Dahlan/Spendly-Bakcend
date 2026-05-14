<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    // GET /api/notifications
    // Optional: ?is_read=false untuk filter belum dibaca
    public function index(Request $request): JsonResponse
    {
        $filters = [];

        if ($request->query('is_read') !== null) {
            $filters['is_read'] = $request->query('is_read');
        }

        $notifications = $this->notificationService->getAll($filters);
        $unreadCount   = $this->notificationService->countUnread();

        return response()->json([
            'success'      => true,
            'unread_count' => $unreadCount,
            'data'         => $notifications,
        ]);
    }

    // PATCH /api/notifications/{id}/read
    public function markAsRead(int $id): JsonResponse
    {
        $notif = $this->notificationService->markAsRead($id);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca.',
            'data'    => $notif,
        ]);
    }

    // DELETE /api/notifications/{id}
    public function destroy(int $id): JsonResponse
    {
        $this->notificationService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }

    // POST /api/admin/notifications/send (khusus admin)
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|integer|exists:users,user_id',
        ]);

        $this->notificationService->send(
            $validated['title'],
            $validated['message'],
            $validated['user_id'] ?? null
        );

        $isSpecific = !empty($validated['user_id']);

        return response()->json([
            'success' => true,
            'message' => $isSpecific
                ? 'Notifikasi berhasil dikirim ke user.'
                : 'Notifikasi berhasil dikirim ke semua user.',
        ], 201);
    }
}