<?php

use App\Http\Controllers\GalleryCategoryPageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::get('/php-version', function () {
    return PHP_VERSION;
});

// Category gallery page
Route::get('/gallery/{slug}', [GalleryCategoryPageController::class, 'show'])->name('gallery.category');

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();

        return response()->json([
            'status' => 'ok',
            'db' => 'connected'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
