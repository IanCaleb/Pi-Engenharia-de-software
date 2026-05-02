<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationRequestController;

// Rota de login para gerar token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciais inválidas.'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user,
    ]);
});

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function () {

    // Rota de logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    });

    // Rotas de doação (manager)
    Route::post('/donations', [DonationController::class, 'store']);
    Route::patch('/donations/requests/{donationRequest}/status', [DonationController::class, 'updateStatus']);
    Route::patch('/donations/requests/{donationRequest}/concluir', [DonationController::class, 'concluir']);

    // Rotas de solicitação de doação (donatário)
    Route::post('/donation-requests', [DonationRequestController::class, 'store']);
});