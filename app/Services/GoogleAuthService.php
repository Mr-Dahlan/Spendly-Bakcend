<?php
// app/Services/Auth/GoogleAuthService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthService
{
    // Step 1: Ambil data user dari Google pakai access_token dari frontend
    public function getGoogleUser(string $accessToken): array
    {
        $response = Http::get('https://www.googleapis.com/oauth2/v1/userinfo', [
            'access_token' => $accessToken,
        ]);

        if ($response->failed()) {
            throw new \Exception('Gagal mengambil data dari Google.');
        }

        return $response->json();
    }

    // Step 2: Cari user di DB, kalau tidak ada buat baru
    public function findOrCreateUser(array $googleUser): User
    {
        $user = User::where('email', $googleUser['email'])->first();

        if ($user) {
            // User sudah ada, update google_id kalau belum diisi
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser['id']]);
            }
            return $user;
        }

        // User belum ada, buat baru
        return User::create([
            'name'       => $googleUser['name'],
            'email'      => $googleUser['email'],
            'google_id'  => $googleUser['id'],
            'avatar'     => $googleUser['picture'] ?? null,
            'password'   => bcrypt(Str::random(24)), // random karena tidak pakai password
            'role'       => 'user',
            'status'     => true,
            'mode'       => 'light',
            'last_login' => now(),
        ]);
    }

    // Step 3: Buat Sanctum token
    public function createToken(User $user): string
    {
        $user->tokens()->delete(); // hapus token lama
        return $user->createToken('google-auth')->plainTextToken;
    }
}