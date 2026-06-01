<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\SearchStoresController;
use App\Http\Controllers\UserDonationController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimentacaoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
    Route::patch('/donations/requests/{donationRequest}/status', [DonationController::class, 'updateStatus'])->name('donations.updateStatus');
    Route::patch('/donations/requests/{donationRequest}/concluir', [DonationController::class, 'concluir'])->name('donations.concluir');

    // ── ROTAS DE SOLICITAÇÃO DE DOAÇÃO (Lógica do Donatário) ──
    Route::post('/donation-requests', [DonationRequestController::class, 'store'])->name('donation-requests.store');

    // ── ROTAS DE MOVIMENTAÇÕES ──
    Route::get('/movimentacoes', [MovimentacaoController::class, 'index'])->name('movimentacoes.index');
    Route::post('/movimentacoes', [MovimentacaoController::class, 'store'])->name('movimentacoes.store');
    Route::get('/movimentacoes/{id}', [MovimentacaoController::class, 'show'])->name('movimentacoes.show');
    Route::patch('/movimentacoes/{id}', [MovimentacaoController::class, 'update'])->name('movimentacoes.update');
    Route::delete('/movimentacoes/{id}', [MovimentacaoController::class, 'destroy'])->name('movimentacoes.destroy');
});

// --- VIEWS DO MANAGER ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Alias para manter compatibilidade
Route::get('/manager/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('manager.dashboard');

Route::get('manager/produtos', [ProductController::class, 'index'])->name('manager.produtos');
Route::post('/manager/produtos', [ProductController::class, 'store'])->name('manager.produtos.store');
Route::put('/manager/produtos/{id}', [ProductController::class, 'update'])->name('manager.produtos.update');
Route::get('/manager/doacoes', [DonationController::class, 'index'])->name('manager.doacoes');

Route::resource('manager/movements', MovementController::class)->except(['edit', 'update']);

// --- VIEWS DO USER (DONATÁRIO) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DonationController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/home', [DonationController::class, 'userDashboard'])->name('user.home');
});

Route::get('/user/buscar-lojas', [SearchStoresController::class, 'index'])->name('user.buscar-lojas');
Route::get('/user/doacoes', [UserDonationController::class, 'index'])->name('user.doacoes');

Route::get('/produtos', function () {
    return view('products.index');
})->name('products.index');

require __DIR__ . '/auth.php';