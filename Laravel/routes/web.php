<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


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
});

//rotas provisórias sem middleware

//manager

Route::get('/manager/dashboard', function () {
    return view('manager.dashboard');
});

Route::get('/manager/doacoes', function () {
    return view('manager.doacoes');
});
Route::get('/manager/produtos', function () {
    return view('manager.produtos');
});
//user

Route::get('/user/home', function () {
    return view('user.home');
});

Route::get('/user/doacoes', function () {
    return view('user.doacoes');
});

Route::get('/user/buscar-lojas', function () {
    return view('user.buscar-lojas');
});


/*

// Rota protegida para Gerente
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
});

// Rota protegida para Donatário

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});
*/
require __DIR__.'/auth.php';

