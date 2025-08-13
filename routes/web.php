<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\laporankeuanganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::get('/transaksi/{id}/detail', [TransactionController::class, 'transactionDetail'])->name('transaksi.detail');
    Route::post('/transaksi/{id}/bayar', [TransactionController::class, 'showPayForm'])->name('transaksi.showPayForm');
    Route::patch('/transaksi/{id}/bayar', [TransactionController::class, 'payOffKasbon'])->name('transaksi.payOffKasbon');
});

Route::middleware('auth')->group(function () {
    Route::get('/laporan-keuangan', [laporankeuanganController::class, 'index'])->name('laporan-keuangan');
    Route::get('/laporan-keuangan/pemasukan-harian', [laporankeuanganController::class, 'pemasukanHarian'])->name('laporan-keuangan.pemasukanHarian');
    Route::get('/laporan-keuangan/create', [laporankeuanganController::class, 'create'])->name('laporan-keuangan.create');
    Route::post('/laporan-keuangan', [laporankeuanganController::class, 'store'])->name('laporan-keuangan.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
    Route::post('/kasir/add', [KasirController::class, 'addToChart'])->name('kasir.add');
    Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    Route::patch('/kasir/{cart}/quantity', [KasirController::class, 'editQuantity'])->name('kasir.quantity');
    Route::delete('/kasir/{id}', [KasirController::class, 'removeToChart'])->name('kasir.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/produk', [ProductController::class, 'index'])->name('produk');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::post('/produk', [ProductController::class, 'store'])->name('product.store');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/user', [UsersController::class, 'index'])->name('user');
    Route::get('/user/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::patch('/user/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::put('/user/{user}', [UsersController::class, 'passwordUpdate'])->name('users.passwordUpdate');
    Route::delete('/user/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('/user/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
});

require __DIR__.'/auth.php';
