<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationRequestController extends Controller
{
    /**
     * Solicitar uma doação (apenas donatário)
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
        ]);

        // Busca a doação
        $donation = Donation::findOrFail($request->donation_id);

        // Protege: só pode solicitar doações disponíveis
        if ($donation->status !== 'disponivel') {
            return redirect()->back()->with('error', 'Esta doação não está mais disponível.');
        }

        // Regra: donatário não pode solicitar a mesma doação duas vezes
        $jaExiste = DonationRequest::where('donation_id', $request->donation_id)
            ->where('donatario_id', Auth::id())
            ->exists();

        if ($jaExiste) {
           return redirect()->back()->with('error', 'Você já solicitou esta doação.');
        }

        // Cria a solicitação
        $donationRequest = DonationRequest::create([
            'donation_id'  => $request->donation_id,
            'donatario_id' => Auth::id(),
            'status'       => 'pendente',
        ]);

        return redirect()->back()->with('success', 'Solicitação enviada com sucesso!');
    }
}