<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Disponibilizar um lote para doação (apenas manager)
     * POST /donations
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'batch_id'  => 'required|exists:batches,id',
            'quantity'  => 'required|integer|min:1',
        ]);

        // Busca o lote e verifica se pertence ao gerente logado
        $batch = Batch::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($request->batch_id);

        // Regra: quantidade a doar não pode ultrapassar a quantidade do lote
        if ($request->quantity > $batch->quantity) {
            return response()->json([
                'message' => 'A quantidade a ser doada não pode ultrapassar a quantidade do lote.',
            ], 400);
        }

        // Cria a doação com status 'disponivel'
        $donation = Donation::create([
            'store_id' => Auth::id(),
            'batch_id' => $request->batch_id,
            'quantity' => $request->quantity,
            'status'   => 'disponivel',
        ]);

        return redirect()->back()->with('success', 'Doação disponibilizada com sucesso!');
    }

    /**
     * Aprovar ou recusar uma solicitação de doação (apenas manager)
     * PATCH /donations/requests/{donationRequest}/status
     */
    public function updateStatus(Request $request, int $donationRequestId)
    {
        $request->validate([
            'status' => 'required|in:aceito,recusado',
        ]);

        // Busca o donation_request
        $donationRequest = \App\Models\DonationRequest::findOrFail($donationRequestId);
        $donation        = $donationRequest->donation;

        // Protege: apenas o dono da doação pode aprovar/recusar
        if ($donation->store_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        // Protege: só pode agir em requests pendentes
        if ($donationRequest->status !== 'pendente') {
            return redirect()->back()->with('error', 'Este pedido já foi processado.');
        }

        // Protege: só pode agir em doações disponíveis
        if ($donation->status !== 'disponivel') {
            return redirect()->back()->with('error', 'Esta doação não está mais disponível.');
        }

        if ($request->status === 'recusado') {
            // Apenas recusa este request
            $donationRequest->update(['status' => 'recusado']);

           return redirect()->back()->with('success', 'Solicitação recusada.');
        }

        // Se aceito:
        // 1. Aceita este request
        $donationRequest->update(['status' => 'aceito']);

        // 2. Muda a doação para 'em_processo'
        $donation->update(['status' => 'em_processo']);

        // 3. Recusa automaticamente todos os outros requests pendentes
        $donation->requests()
            ->where('id', '!=', $donationRequest->id)
            ->where('status', 'pendente')
            ->update(['status' => 'recusado']);

        return redirect()->back()->with('success', 'Solicitação aceita! Outros pedidos foram recusados automaticamente.');
    }
    /**
     * Marcar doação como concluída/retirada (apenas manager)
     * PATCH /donations/requests/{donationRequest}/concluir
     */
    public function concluir(int $donationRequestId)
    {
        $donationRequest = \App\Models\DonationRequest::findOrFail($donationRequestId);
        $donation        = $donationRequest->donation;

        // Protege: apenas o dono da doação pode concluir
        if ($donation->store_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        // Protege: só pode concluir se o request estiver aceito
        if ($donationRequest->status !== 'aceito') {
            return redirect()->back()->with('error', 'Este pedido não está aceito.');
        }

        // Protege: só pode concluir se a doação estiver em_processo
        if ($donation->status !== 'em_processo') {
            return redirect()->back()->with('error', 'Esta doação não está em processo.');
        }

        // 1. Conclui o request
        $donationRequest->update(['status' => 'concluido']);

        // 2. Finaliza a doação
        $donation->update(['status' => 'finalizada']);

        // 3. Subtrai a quantidade do lote físico
        $batch = $donation->batch;
        $batch->decrement('quantity', $donation->quantity);

        return redirect()->back()->with('success', 'Doação concluída! Estoque atualizado.');
    }
}