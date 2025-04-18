<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Sales Route
Route::middleware('auth')->get('/sales', [SalesController::class, 'index'])->name('sales');

// Inventory Route
Route::middleware('auth')->get('/inventory', [InventoryController::class, 'index'])->name('inventory');

// Stock-In Routes
Route::middleware('auth')->get('/stock-in', [StockController::class, 'index'])->name('stock-in');

// Stock-In Details Create Route (GET)
Route::middleware('auth')->get('/stock-in-details/create', [StockController::class, 'create'])->name('stock-in-details.create');

// Stock-In Details Store Route (POST)
Route::middleware('auth')->post('/stock-in-details', [StockController::class, 'store'])->name('stock-in-details.store');

// Dashboard Route
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Search Route
Route::middleware('auth')->get('/search', function (Request $request) {
    $query = $request->query('query');
    return view('search.results', compact('query'));  // Use a view for displaying search results
})->name('search');

// Profile Settings Route
Route::middleware('auth')->get('/profile/settings', function () {
    return view('profile.settings'); // Profile settings page
})->name('profile.settings');

// Register Route (ensure only accessible to admin)
Route::middleware('auth')->get('/register', function () {
    return view('auth.register'); // Register a new user
})->name('register');

// Optional: If you want a fallback route for 404 errors
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
