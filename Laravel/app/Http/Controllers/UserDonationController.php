<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDonationController extends Controller
{
    /**
     * Exibir doações solicitadas pelo usuário (donatário)
     * GET /user/doacoes
     */
    public function index()
    {
        // Buscar todas as solicitações de doação do usuário autenticado
        $donationRequests = \App\Models\DonationRequest::where('donatario_id', Auth::id())
            ->with(['donation.store', 'donation.batch.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.doacoes', compact('donationRequests'));
    }
}
