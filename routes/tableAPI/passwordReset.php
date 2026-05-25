<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

// Forgot Password - send reset link
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Password reset link has been sent to your email!'])
        : response()->json(['message' => 'Email not found.'], 400);
});

// Reset Password - update new password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Password successfully reset! Please login.'])
        : response()->json(['message' => 'Token is invalid or has expired.'], 400);
});