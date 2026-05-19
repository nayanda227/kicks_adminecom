<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// Ganti route '/products' agar memanggil ProductController
// Ini adalah "Resource Route", dia otomatis membuat SEMUA rute CRUD:
// - GET /products (untuk halaman index) -> name('products.index')
// - GET /products/create (untuk halaman form tambah) -> name('products.create')
// - POST /products (untuk menyimpan data baru) -> name('products.store')
// - GET /products/{id}/edit (untuk halaman form edit) -> name('products.edit')
// dll...
Route::resource('products', ProductController::class);