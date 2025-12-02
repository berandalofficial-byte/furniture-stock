<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Route CRUD produk (kalau sudah ada bisa pakai punyamu)
Route::resource('products', ProductController::class);

// 🔹 Route CRUD transaksi stok (index, create, store, edit, update, destroy)
Route::resource('stock-transactions', StockTransactionController::class)->except(['show']);
