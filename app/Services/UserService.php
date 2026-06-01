<?php

namespace App\Services;

use App\Models\User;
use App\Services\AdminLogService;
use App\Services\NotificationService;

class UserService
{
    public function __construct(
        protected AdminLogService $adminLogService,
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
    }

    public function deleteUserByAdmin(int $id): void
    {
        $user = User::findOrFail($id);

        $user->tokens()->delete();
        $user->delete();

        // Record admin log
        $this->adminLogService->log(
            action: 'DELETE_USER',
            description: 'User ' . $user->name . ' (' . $user->email . ') has been deleted.',
            targetUserId: $id
        );
    }

    public function updateStatus(int $id, bool $status): array
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $user->update(['status' => $status]);

        $statusLabel = $status ? 'active' : 'inactive';

        // Record admin log
        $this->adminLogService->log(
            action: 'UPDATE_USER_STATUS',
            description: 'User status for ' . $user->name . ' has been changed to ' . $statusLabel . '.',
            targetUserId: $id
        );

        // Send notification to user
        $this->notificationService->send(
            title: 'Account Status Updated',
            message: 'Your account status has been changed to ' . $statusLabel . '.',
            userId: $id
        );

        return ['data' => $user->fresh()];
    }

    public function updateRole(int $id, string $role): array
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $user->update(['role' => $role]);

        // Record admin log
        $this->adminLogService->log(
            action: 'UPDATE_USER_ROLE',
            description: 'User role for ' . $user->name . ' has been changed to ' . $role . '.',
            targetUserId: $id
        );

        // Send notification to user
        $this->notificationService->send(
            title: 'Account Role Updated',
            message: 'Your account role has been changed to ' . $role . '.',
            userId: $id
        );

        return ['data' => $user->fresh()];
    }
}