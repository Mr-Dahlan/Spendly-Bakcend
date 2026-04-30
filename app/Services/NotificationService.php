<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Ambil semua notifikasi milik user yang login
     * Optional filter: is_read (true/false)
     */
    public function getAll(array $filters = [])
    {
        $query = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if (isset($filters['is_read']) && $filters['is_read'] !== '') {
            $query->where('is_read', filter_var($filters['is_read'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->get();
    }

    /**
     * Hitung notifikasi yang belum dibaca
     */
    public function countUnread(): int
    {
        return Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    /**
     * Kirim notifikasi — bisa dari sistem atau admin
     * Jika user_id null = kirim ke semua user
     */
    public function send(string $title, string $message, ?int $userId = null): void
    {
        if ($userId) {
            // Kirim ke user spesifik
            Notification::create([
                'user_id' => $userId,
                'title'   => $title,
                'message' => $message,
                'is_read' => false,
            ]);
        } else {
            // Kirim ke semua user (broadcast)
            $userIds = User::pluck('user_id');

            $notifications = $userIds->map(fn($id) => [
                'user_id'    => $id,
                'title'      => $title,
                'message'    => $message,
                'is_read'    => false,
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            Notification::insert($notifications);
        }
    }

    /**
     * Mark 1 notifikasi sebagai sudah dibaca
     */
    public function markAsRead(int $id): Notification
    {
        $notif = Notification::where('notif_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return $notif->fresh();
    }

    /**
     * Hapus 1 notifikasi
     */
    public function delete(int $id): void
    {
        $notif = Notification::where('notif_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->delete();
    }
}