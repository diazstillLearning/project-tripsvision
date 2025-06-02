<?php

// routes/web.php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;        
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\StayController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CulinaryController;
use App\Http\Controllers\TravelPackageController;

// --- Guest Routes ---

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('Admin')->name('Admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Culinary
    Route::get('culinaries', [CulinaryController::class, 'index'])->name('culinaries.index');
    Route::get('culinaries/create', [CulinaryController::class, 'create'])->name('culinaries.create');
    Route::post('culinaries/store', [CulinaryController::class, 'store'])->name('culinaries.store');
    Route::get('culinaries/edit/{id}', [CulinaryController::class, 'edit'])->name('culinaries.edit');
    Route::put('culinaries/update/{id}', [CulinaryController::class, 'update'])->name('culinaries.update');
    Route::delete('culinaries/destroy/{id}', [CulinaryController::class, 'destroy'])->name('culinaries.destroy');

    // Destination
    Route::get('destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
    Route::post('destinations/store', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('destinations/edit/{id}', [DestinationController::class, 'edit'])->name('destinations.edit');
    Route::put('destinations/update/{id}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('destinations/destroy/{id}', [DestinationController::class, 'destroy'])->name('destinations.destroy');

    // Stays
    Route::get('stays', [StayController::class, 'index'])->name('stays.index');
    Route::get('stays/create', [StayController::class, 'create'])->name('stays.create');
    Route::post('stays/store', [StayController::class, 'store'])->name('stays.store');
    Route::get('stays/edit/{id}', [StayController::class, 'edit'])->name('stays.edit');
    Route::put('stays/update/{id}', [StayController::class, 'update'])->name('stays.update');
    Route::delete('stays/destroy/{id}', [StayController::class, 'destroy'])->name('stays.destroy');
});
    });
    // Stay routes (CRUD) – accessible only by admin
    Route::prefix('Admin')->name('Admin.')->group(function () {
        Route::get('stays', [StayController::class, 'index'])->name('stays.index');
        Route::get('stays/create', [StayController::class, 'create'])->name('stays.create');
        Route::post('stays/store', [StayController::class, 'store'])->name('stays.store');
        Route::get('stays/edit/{id}', [StayController::class, 'edit'])->name('stays.edit');
        Route::put('stays/update/{id}', [StayController::class, 'update'])->name('stays.update');
        Route::delete('stays/destroy/{id}', [StayController::class, 'destroy'])->name('stays.destroy');
    });



Route::get('/dashboard', [TravelPackageController::class, 'index'])->name('dashboard');
Route::get('/recommendations', [TravelPackageController::class, 'recommendations'])->name('recommendations');

