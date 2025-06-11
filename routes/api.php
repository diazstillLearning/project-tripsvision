<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\CulinaryController;
use App\Http\Controllers\Api\StayController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Destination (CRUD + custom)
    Route::apiResource('destination', DestinationController::class);
    Route::get('destination/{id}/image', [DestinationController::class, 'getImage']);

    // Culinary (CRUD + custom)
    Route::apiResource('culinaries', CulinaryController::class);
    Route::get('culinary/{id}/image', [CulinaryController::class, 'getImage']);

    // Stay (CRUD + custom)
    Route::apiResource('stay', StayController::class);
    Route::get('stay/{id}/image', [StayController::class, 'getImage']);
});



