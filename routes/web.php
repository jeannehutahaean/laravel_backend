<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\ShipmentRouteController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect('/login'));

// Guest User Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated User
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Admin Authenticated Area
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Vehicle Management
        Route::resource('vehicles', VehicleController::class);

        // Shipment Route Management (with map)
        Route::resource('routes', ShipmentRouteController::class);

        // Report Page
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');

        // ✅ Tambahan: Update status langsung dari halaman report
        // Ganti PATCH → POST agar lebih aman untuk browser biasa
        Route::post('/reports/{shipment}/update-status', [ReportController::class, 'updateStatus'])->name('report.updateStatus');


        // Notifications (Delay / Deviation)
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    });
});
