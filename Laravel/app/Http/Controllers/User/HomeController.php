<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DonationRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Pegar a doação que o usuário logado solicitou e que foi APROVADA
        // Busca um DonationRequest do usuário logado com status 'aceito'
        $donationRequest = DonationRequest::with(['donation.store', 'donation.batch.product'])
            ->where('donatario_id', Auth::id())
            ->where('status', 'aceito')
            ->latest()
            ->first();

        // Se existe uma solicitação aceita, prepara a doação para exibição
        $doacaoAgendada = null;
        if ($donationRequest) {
            $doacaoAgendada = $donationRequest->donation;
            $doacaoAgendada->quantity = $donationRequest->quantity;
            $doacaoAgendada->updated_at = $donationRequest->updated_at;
        }

        // 2. Pegar todas as doações DISPONÍVEIS recentes no sistema para listar na sanfona
        // Mostraremos as últimas 5 doações que os gerentes disponibilizaram
        $doacoesRecentes = Donation::with(['store', 'batch.product'])
            ->whereIn('status', ['disponivel', 'em_processo'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Retornar a view da home passando as duas variáveis
        return view('user.home', compact('doacaoAgendada', 'doacoesRecentes'));
    }
}