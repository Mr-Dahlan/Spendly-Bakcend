<?php
namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUsers(): array
    {
        $users = User::all();

        return [
            'data' => $users,
        ];
    }

    public function getUserById(int $id): array
    {
        $user = User::find($id);
        if (!$user) {
            return [
                'message' => 'User not found',
            ];
        }

        return [
            'data' => $user,
        ];
    }

    public function updateUser(int $id, array $data): array
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return [
            'data' => $user->fresh(),
        ];
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->tokens()->delete(); // ✅ tokens() bukan token()
        $user->delete();
    }
}