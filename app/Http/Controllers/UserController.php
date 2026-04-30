<?php
namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // ===== ADMIN ONLY =====

    public function index()
    {
        $result = $this->userService->getAllUsers();

        return response()->json([
            'message' => 'Berhasil mengambil semua user',
            ...$result,
        ]);
    }

    public function show(int $id)
    {
        $result = $this->userService->getUserById($id);

        return response()->json([
            'message' => 'Berhasil mengambil user',
            ...$result,
        ]);
    }

    public function adminUpdate(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|string|max:100',
            'password' => 'sometimes|string|min:8|confirmed',
            'status'   => 'sometimes|boolean',
        ]);

        $result = $this->userService->updateUser($id, $validated);

        return response()->json([
            'message' => 'Berhasil update user',
            ...$result,
        ]);
    }

    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);

        return response()->json([
            'message' => 'Berhasil menghapus user',
        ]);
    }

    // ===== USER SENDIRI =====

    public function userUpdate(Request $request)
    {
        // ambil id dari token yang login, bukan dari parameter
        $id = $request->user()->user_id;

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:100',
            'password' => 'sometimes|string|min:8|confirmed',
            'mode'     => 'sometimes|in:light,dark',
        ]);

        $result = $this->userService->updateUser($id, $validated);

        return response()->json([
            'message' => 'Berhasil update profil',
            ...$result,
        ]);
    }
}