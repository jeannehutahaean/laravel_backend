<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Api\DriverAuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\DriverHistoryController;
use App\Http\Controllers\Api\DriverHistoryDetailController;
use App\Http\Controllers\Api\DriverDeliveryController;
use App\Http\Controllers\Api\DriverOnDeliveryController;
use App\Http\Controllers\Api\DriverTrackingMapController;
use App\Http\Controllers\Api\DriverCompleteDeliveryController;


Route::get('/test-controller', [TestController::class, 'test']);

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/driver/login', [DriverAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/driver/logout', [DriverAuthController::class, 'logout']);

Route::post('/driver/register', [DriverAuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/driver/profile', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/driver/shipments/history', [DriverHistoryController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/driver/shipments/history/{id}', [DriverHistoryDetailController::class, 'show']);
});

Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('tracking-map/current', [DriverTrackingMapController::class, 'currentRoute']);
});

Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::post('/shipments/{id}/complete', [DriverCompleteDeliveryController::class, 'complete']);
});

Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('/routes', [DriverDeliveryController::class, 'getRoutes']);
    Route::get('/vehicles', [DriverDeliveryController::class, 'getVehicles']);
    Route::post('/shipments', [DriverDeliveryController::class, 'storeShipment']);
});

Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('/shipments/current', [DriverDeliveryController::class, 'current']);
});

Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('/shipments/current', [DriverOnDeliveryController::class, 'current']);
    Route::post('/shipments/{id}/start', [DriverOnDeliveryController::class, 'start']);
    Route::post('/shipments/{id}/pause', [DriverOnDeliveryController::class, 'pause']);
    Route::post('/shipments/{id}/cancel', [DriverOnDeliveryController::class, 'cancel']);
    Route::post('/shipments/{id}/location', [DriverOnDeliveryController::class, 'updateLocation']);
});


Route::middleware('auth:api')->group(function () {
    Route::post('/shipments/start', [ShipmentController::class, 'start']);
    Route::post('/trackings', [TrackingController::class, 'store']);
    Route::get('/driver/history', [ShipmentController::class, 'history']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/driver/test', function () {
    return \App\Http\Controllers\Api\DriverAuthController::class;
});

Route::options('/{any}', function () {
    return response()->json(['status' => 'OK'], 200);
})->where('any', '.*');
