<?php

use Illuminate\Support\Facades\Route;

// Custom API Routes
Route::prefix('api')->group(function () {
    // Auth (login has built-in rate limiting)
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:web');
    Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);

    // Public routes
    Route::post('/leads', [\App\Http\Controllers\Api\LeadController::class, 'store']);
    Route::post('/affiliate-click', [\App\Http\Controllers\Api\AffiliateController::class, 'trackClick']);

    // Protected routes (Admin & Affiliators)
    Route::middleware('auth:web')->group(function () {

        // === AFFILIATE ROUTES (accessible by all authenticated users) ===
        Route::get('/affiliates/dashboard', [\App\Http\Controllers\Api\AffiliateController::class, 'dashboard']);
        Route::put('/affiliates/referral-code', [\App\Http\Controllers\Api\AffiliateController::class, 'updateReferralCode']);

        // === ADMIN-ONLY ROUTES (Super Admin & Admin roles) ===
        Route::middleware('role:Super Admin,Admin')->group(function () {
            // Affiliate Management
            Route::get('/affiliates', [\App\Http\Controllers\Api\AffiliateController::class, 'index']);
            Route::post('/affiliates', [\App\Http\Controllers\Api\AffiliateController::class, 'store']);
            Route::put('/affiliates/{id}', [\App\Http\Controllers\Api\AffiliateController::class, 'update']);

            // Leads Management
            Route::get('/leads', [\App\Http\Controllers\Api\LeadController::class, 'index']);
            Route::put('/leads/{id}/status', [\App\Http\Controllers\Api\LeadController::class, 'updateStatus']);

            // Commission Management
            Route::get('/commissions', [\App\Http\Controllers\Api\CommissionController::class, 'index']);
            Route::put('/commissions/{id}/status', [\App\Http\Controllers\Api\CommissionController::class, 'updateStatus']);

            // Admin Blog Management
            Route::get('/admin/posts', [\App\Http\Controllers\PostController::class, 'indexAdmin']);
            Route::post('/admin/posts', [\App\Http\Controllers\PostController::class, 'store']);
            Route::get('/admin/posts/{id}', [\App\Http\Controllers\PostController::class, 'showAdmin']);
            Route::put('/admin/posts/{id}', [\App\Http\Controllers\PostController::class, 'update']);
            Route::delete('/admin/posts/{id}', [\App\Http\Controllers\PostController::class, 'destroy']);

            // Users & Roles Management (Super Admin only)
            Route::middleware('role:Super Admin')->group(function () {
                Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
                Route::post('/users', [\App\Http\Controllers\Api\UserController::class, 'store']);
                Route::put('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);
                Route::delete('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);
            });

            // Admin Dashboard Stats
            Route::get('/stats', [\App\Http\Controllers\Api\StatsController::class, 'index']);
        });
    });

    // Public Blog routes
    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
    Route::get('/posts/{slug}', [\App\Http\Controllers\PostController::class, 'show']);
    Route::post('/posts/{id}/react', [\App\Http\Controllers\PostController::class, 'react']);
});

Route::get('/blog/{slug}', function ($slug) {
    $post = \App\Models\Post::where('slug', $slug)->where('status', 'published')->first();
    return view('home', ['post' => $post]);
});

Route::get('/{any?}', function () {
    return view('home');
})->where('any', '^(?!build|api).*$');
