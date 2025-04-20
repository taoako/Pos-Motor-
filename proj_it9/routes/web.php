<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Sales route
Route::middleware('auth')->get('/sales', [SalesController::class, 'index'])->name('sales');

// Inventory route
Route::middleware('auth')->get('/inventory', [InventoryController::class, 'index'])->name('inventory');



use App\Http\Controllers\StockInController;

Route::get('/stock-in', [StockInController::class, 'index'])->name('stock-in');
Route::post('/stock-in/store', [StockInController::class, 'store'])->name('stock-in.store');


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

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/employee/store', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');


Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
