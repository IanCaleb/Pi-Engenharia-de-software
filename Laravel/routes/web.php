<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;


Route::get('/', function () {
    return view('landingPage.landingPage');
});

Route::get('/landingPage', function () {
    return view('landingPage.landingPage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('batches', BatchController::class);
});

// Rotas do manager
// TODO: adicionar middleware ['auth', 'manager'] quando o frontend estiver pronto
Route::get('/manager/dashboard', [ProductController::class, 'dashboard'])->name('manager.dashboard');
Route::get('/manager/produtos', [ProductController::class, 'index'])->name('manager.produtos');
Route::get('/manager/doacoes', function () {
    return view('manager.doacoes');
})->name('manager.doacoes');

// Rotas do user
// TODO: adicionar middleware ['auth', 'user'] quando o frontend estiver pronto
Route::get('/user/dashboard', function () {
    return view('user.home');
})->name('user.dashboard');

Route::get('/user/home', function () {
    return view('user.home');
})->name('user.home');

Route::get('/user/doacoes', function () {
    return view('user.doacoes');
})->name('user.doacoes');

Route::get('/user/buscar-lojas', function () {
    return view('user.buscar-lojas');
})->name('user.buscar-lojas');

Route::get('/produtos', function () {
    return view('products.index');
})->name('products.index');

/*
 * Middlewares de proteção por role — desativados temporariamente a pedido do P.O
 * para facilitar o desenvolvimento do frontend.
 * Reativar quando o frontend estiver finalizado:
 *
 * Route::middleware(['auth', 'manager'])->group(function () {
 *     Route::get('/manager/dashboard', ...)->name('manager.dashboard');
 *     ...
 * });
 *
 * Route::middleware(['auth', 'user'])->group(function () {
 *     Route::get('/user/dashboard', ...)->name('user.dashboard');
 *     ...
 * });
 */

require __DIR__.'/auth.php';