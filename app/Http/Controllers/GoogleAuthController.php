<?php
// app/Http/Controllers/Auth/GoogleAuthController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GoogleAuthController extends Controller
{
    public function __construct(
        protected GoogleAuthService $googleAuthService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'access_token' => 'required|string',
        ]);

        try {
            // 1. Ambil data dari Google
            $googleUser = $this->googleAuthService->getGoogleUser(
                $request->access_token
            );

            // 2. Cari atau buat user
            $user = $this->googleAuthService->findOrCreateUser($googleUser);

            // 3. Update last_login
            $user->update(['last_login' => now()]);

            // 4. Buat token Sanctum
            $token = $this->googleAuthService->createToken($user);

            return response()->json([
                'message' => 'Login berhasil.',
                'token'   => $token,
                'user'    => [
                    'id'     => $user->user_id,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'role'   => $user->role,
                    'avatar' => $user->avatar,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}