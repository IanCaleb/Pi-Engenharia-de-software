<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landingPage.landingPage');
});

Route::get('/landingPage', function () {
    return view('landingPage.landingPage');
});

// ROTAS PROTEGIDAS POR LOGIN
Route::middleware('auth')->group(function () {
    
    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Produtos e Lotes
    Route::resource('products', ProductController::class);
    Route::resource('batches', BatchController::class);

    // ── ROTAS DE DOAÇÃO (Lógica do Manager) ──
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::patch('/donations/requests/{donationRequest}/status', [DonationController::class, 'updateStatus'])->name('donations.updateStatus');
    Route::patch('/donations/requests/{donationRequest}/concluir', [DonationController::class, 'concluir'])->name('donations.concluir');
// ── ROTAS DE DOAÇÃO (Lógica do Manager) ──
Route::post('/donations', [DonationController::class, 'store'])
    ->name('donations.store');

Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])
    ->name('donations.destroy');

Route::patch('/donations/requests/{donationRequest}/status',
    [DonationController::class, 'updateStatus'])
    ->name('donations.updateStatus');

Route::patch('/donations/requests/{donationRequest}/concluir',
    [DonationController::class, 'concluir'])
    ->name('donations.concluir');
    // ── ROTAS DE SOLICITAÇÃO DE DOAÇÃO (Lógica do Donatário) ──
    Route::post('/donation-requests', [DonationRequestController::class, 'store'])->name('donation-requests.store');
});

// --- VIEWS DO MANAGER ---
Route::get('manager/produtos', [ProductController::class, 'index'])->name('manager.produtos');
Route::post('/manager/produtos', [ProductController::class, 'store'])->name('manager.produtos.store');
// Rota para processar a edição do produto/lote
Route::put('/manager/produtos/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('manager.produtos.update');
// Rota de Doações do Manager - Integrada com os Models[cite: 2, 7]
Route::get('/manager/doacoes', [DonationController::class, 'index'])->name('manager.doacoes');

Route::resource(
    'manager/movements',
    MovementController::class
)->except(['edit', 'update']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- VIEWS DO USER (DONATÁRIO) ---

Route::get('/user/dashboard', function () {
    return view('user.home');
})->name('user.dashboard');

Route::get('/user/home', function () {
    return view('user.home');
})->name('user.home');

Route::get('/user/buscar-lojas', function () {
    return view('user.buscar-lojas');
})->name('user.buscar-lojas');

Route::get('/produtos', function () {
    return view('products.index');
})->name('products.index');

require __DIR__ . '/auth.php';