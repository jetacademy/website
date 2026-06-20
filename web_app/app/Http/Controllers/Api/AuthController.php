<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login with rate limiting (max 5 attempts per minute per IP+email)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Rate limiting: 5 attempts per minute per IP + email combo
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
                'retry_after' => $seconds,
            ], 429);
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $user = Auth::user();
            $user->role_names = $user->getRoleNames()->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => $user,
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $remaining = RateLimiter::remaining($throttleKey, 5);

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.',
            'attempts_remaining' => $remaining,
        ], 401);
    }

    /**
     * Logout and invalidate session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'user' => null,
                'authenticated' => false,
            ], 401);
        }

        $user->role_names = $user->getRoleNames()->toArray();

        return response()->json([
            'user' => $user,
            'authenticated' => true,
        ]);
    }
}
