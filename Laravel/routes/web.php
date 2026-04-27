<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//rotas provisórias sem middleware

Route::get('/manager/dashboard', function () {
    return view('manager.dashboard');
});

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
});

Route::get('/produtos', function () {
    // Isso aponta para resources/views/products/index.blade.php
    return view('products.index'); 
})->name('products.index');


require __DIR__.'/auth.php';
