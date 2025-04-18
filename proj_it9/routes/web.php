<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Sales route
Route::middleware('auth')->get('/sales', [SalesController::class, 'index'])->name('sales');

// Inventory route
Route::middleware('auth')->get('/inventory', [InventoryController::class, 'index'])->name('inventory');

Route::middleware('auth')->get('/stock-in', [StockController::class, 'index'])->name('stock-in');

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



// Search route
Route::middleware('auth')->get('/search', function (Request $request) {
    // Add your search logic here
    return "Search results for: " . $request->query('query');
})->name('search');

// Profile settings route
Route::middleware('auth')->get('/profile/settings', function () {
    return view('profile.settings'); // Create a `profile/settings.blade.php` view
})->name('profile.settings');

// Register route
Route::middleware('auth')->get('/register', function () {
    return view('auth.register'); // Create an `auth/register.blade.php` view
})->name('register');
