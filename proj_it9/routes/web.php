<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// =========================
// Authentication Routes
// =========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// Dashboard Routes
// =========================
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// =========================
// Dynamic Content Routes
// =========================
Route::middleware('auth')->get('/dashboard/content', function () {
    return view('partials.dashboard-content');
})->name('dashboard.content');

Route::middleware('auth')->get('/stock-in/content', function () {
    return view('partials.stock-in-content');
})->name('stock-in.content');

Route::middleware('auth')->get('/sales/content', function () {
    return view('partials.sales-content');
})->name('sales.content');

Route::middleware('auth')->get('/inventory/content', function () {
    return view('partials.inventory-content');
})->name('inventory.content');

// =========================
// Stock-In Routes
// =========================
Route::middleware('auth')->get('/stock-in', [StockController::class, 'index'])->name('stock-in');
Route::middleware('auth')->get('/stock-in-details/create', [StockController::class, 'create'])->name('stock-in-details.create');
Route::middleware('auth')->post('/stock-in-details', [StockController::class, 'store'])->name('stock-in-details.store');

// =========================
// Sales Routes
// =========================
Route::middleware('auth')->get('/sales', [SalesController::class, 'index'])->name('sales');

// =========================
// Inventory Routes
// =========================
Route::middleware('auth')->get('/inventory', [InventoryController::class, 'index'])->name('inventory');

// =========================
// Supplier Routes
// =========================
Route::middleware('auth')->get('/supplier/add', [SupplierController::class, 'create'])->name('supplier.add'); // Add New Supplier Form
Route::middleware('auth')->post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store'); // Store New Supplier

// =========================
// Search Routes
// =========================
Route::middleware('auth')->get('/search', function (Request $request) {
    $query = $request->query('query');
    return view('search.results', compact('query')); // Use a view for displaying search results
})->name('search');

// =========================
// Profile Settings Routes
// =========================
Route::middleware('auth')->get('/profile/settings', function () {
    return view('profile.settings'); // Profile settings page
})->name('profile.settings');

// =========================
// Register Routes
// =========================
Route::middleware('auth')->get('/register', function () {
    return view('auth.register'); // Register a new user
})->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// =========================
// Employee and User Routes
// =========================
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

// =========================
// Fallback Route for 404 Errors
// =========================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});