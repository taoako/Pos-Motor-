<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockInDetailsController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\CustomerController;



// =========================
// Authentication Routes
// =========================
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// Register Routes
// =========================
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// =========================
// Protected Routes
// =========================
Route::middleware('auth')->group(function () {
    // All routes inside this middleware block

    // Dashboard
    Route::get('/dashboard', function () {

        return view('dashboard');
    })->name('dashboard');





    Route::get('/dashboard/content', function () {
        return view('partials.dashboard-content');
    })->name('dashboard.content');

    // =========================
    // Stock-In Routes
    // =========================
    Route::prefix('stock-in')->name('stock-in.')->group(function () {
        Route::get('/content', [StockInDetailsController::class, 'content'])->name('content');
        Route::get('/details', [StockInDetailsController::class, 'index'])->name('index');
        Route::get('/details/create', [StockInDetailsController::class, 'create'])->name('create');
        Route::post('/details', [StockInDetailsController::class, 'store'])->name('store');
    });


    // =========================
    // Sales Routes
    // =========================
    Route::prefix('sales')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('sales');
        Route::get('/content', function () {
            return view('partials.sales-content');
        })->name('sales.content');
    });

    Route::get('/sales', function () {
        return view('partials.sales-content'); // Ensure this view exists
    })->name('sales.content');

    // =========================
    // Inventory Routes
    // =========================
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index'); // Main inventory page
        Route::get('/content', [InventoryController::class, 'content'])->name('content'); // Partial content
    });

    // =========================
    // Supplier Routes
    // =========================
    Route::get('/suppliers/content', [SupplierController::class, 'content'])->name('suppliers.content');
    Route::get('/suppliers/list', [SupplierController::class, 'list'])->name('suppliers.list');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');


    Route::get('/test-pagination', function () {
        $products = \App\Models\Product::latest()->paginate(10);
        return view('partials.inventory-content', compact('products'));
    });


    // =========================
    // Product Routes
    // =========================
    // Route for dynamically loading product content
    Route::get('/products/content', [ProductController::class, 'content'])->name('products.content');

    // Other product-related routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // =========================
    // Category Routes
    // =========================
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // =========================
    // Employee Routes
    // =========================
    Route::prefix('employees')->group(function () {
        Route::get('/content', [EmployeeController::class, 'content'])->name('employees.content'); // New route for partial content
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
    });
    // =========================
    // User Routes
    // =========================
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

    // =========================
    // Profile Routes
    // =========================
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // =========================
    // Search Route
    // =========================
    Route::get('/search', function (Request $request) {
        $query = $request->query('query');
        return view('search.results', compact('query'));
    })->name('search');

    // =========================
    // POS Routes
    // =========================


    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/add-to-cart', [POSController::class, 'addToCart'])->name('pos.addToCart');
    Route::post('/pos/remove-from-cart', [POSController::class, 'removeFromCart'])->name('pos.removeFromCart');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');

    // Customer routes
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

    // =========================
    // Fallback 404 Error Page
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
}); // Close the middleware group);
