<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Check if the authenticated user has one of the required roles.
     *
     * Usage: ->middleware('role:Super Admin,Admin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login terlebih dahulu.',
            ], 401);
        }

        if (empty($roles)) {
            return $next($request);
        }

        $userRoles = $request->user()->getRoleNames();

        foreach ($roles as $role) {
            if ($userRoles->contains(trim($role))) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak. Anda tidak memiliki izin untuk melakukan aksi ini.',
        ], 403);
    }
}
