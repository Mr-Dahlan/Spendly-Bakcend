<?php

namespace App\Services;

use App\Models\User;
use App\Services\AdminLogService;
use App\Services\NotificationService;

class UserService
{
    public function __construct(
        protected AdminLogService    $adminLogService,
        protected NotificationService $notificationService
    ) {}

    public function getAllUsers(): array
    {
        $users = User::all();
        return ['data' => $users];
    }

    public function getUserById(int $id): array
    {
        $user = User::find($id);

        if (!$user) {
            return ['message' => 'User not found'];
        }

        return ['data' => $user];
    }

    public function updateUser(int $id, array $data): array
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return ['data' => $user->fresh()];
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->tokens()->delete();
        $user->delete();

        // Catat log
        $this->adminLogService->log(
            action: 'DELETE_USER',
            description: 'User ' . $user->name . ' (' . $user->email . ') telah dihapus.',
            targetUserId: $id
        );
    }

    public function updateStatus(int $id, bool $status): array
    {
        $user = User::where('user_id', $id)->firstOrFail();
        $user->update(['status' => $status]);

        $statusLabel = $status ? 'aktif' : 'nonaktif';

        // Catat log
        $this->adminLogService->log(
            action: 'UPDATE_USER_STATUS',
            description: 'Status user ' . $user->name . ' diubah menjadi ' . $statusLabel . '.',
            targetUserId: $id
        );

        // Kirim notifikasi ke user
        $this->notificationService->send(
            title: 'Status Akun Diperbarui',
            message: 'Status akun kamu telah diubah menjadi ' . $statusLabel . '.',
            userId: $id
        );

        return ['data' => $user->fresh()];
    }

    public function updateRole(int $id, string $role): array
    {
        $user = User::where('user_id', $id)->firstOrFail();
        $user->update(['role' => $role]);

        // Catat log
        $this->adminLogService->log(
            action: 'UPDATE_USER_ROLE',
            description: 'Role user ' . $user->name . ' diubah menjadi ' . $role . '.',
            targetUserId: $id
        );

        // Kirim notifikasi ke user
        $this->notificationService->send(
            title: 'Role Akun Diperbarui',
            message: 'Role akun kamu telah diubah menjadi ' . $role . '.',
            userId: $id
        );

        return ['data' => $user->fresh()];
    }
}