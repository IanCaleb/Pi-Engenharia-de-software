<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MovimentacaoController extends Controller
{
    /**
     * Lista todas as movimentações do gerente logado
     */

    public function index()
    {
        $movimentacoes = Movimentacao::with(['product', 'batch'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($movimentacoes);
    }

    /**
     * Cria uma nova movimentação
     */

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_id'   => 'nullable|exists:batches,id',
            'tipo'       => 'required|in:entrada,saida,doacao,descarte',
            'quantidade' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:500',
        ]);

        // Protege: produto deve pertencer ao gerente logado
        $product = Product::where('id', $request->product_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Protege: lote deve pertencer ao produto se informado
        if ($request->batch_id) {
            Batch::where('id', $request->batch_id)
                ->where('product_id', $product->id)
                ->firstOrFail();
        }

        $movimentacao = Movimentacao::create([
            'product_id' => $request->product_id,
            'batch_id'   => $request->batch_id,
            'user_id'    => Auth::id(),
            'tipo'       => $request->tipo,
            'quantidade' => $request->quantidade,
            'observacao' => $request->observacao,
        ]);

        return response()->json([
            'message'      => 'Movimentação registrada com sucesso!',
            'movimentacao' => $movimentacao->load(['product', 'batch']),
        ], 201);
    }

    /**
     * Exibe uma movimentação específica
     */

    public function show(int $id)
    {
        $movimentacao = Movimentacao::with(['product', 'batch'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($movimentacao);
    }

    /**
     * Atualiza uma movimentação
     */

    public function update(Request $request, int $id)
    {
        $movimentacao = Movimentacao::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'tipo'       => 'sometimes|in:entrada,saida,doacao,descarte',
            'quantidade' => 'sometimes|integer|min:1',
            'observacao' => 'nullable|string|max:500',
        ]);

        $movimentacao->update($request->only(['tipo', 'quantidade', 'observacao']));

        return response()->json([
            'message'      => 'Movimentação atualizada com sucesso!',
            'movimentacao' => $movimentacao->load(['product', 'batch']),
        ]);
    }

    /**
     * Remove uma movimentação
     */

        public function destroy(int $id)
    {
        $movimentacao = Movimentacao::where('user_id', Auth::id())
            ->findOrFail($id);

        $movimentacao->delete();

        return response()->json([
            'message' => 'Movimentação removida com sucesso!',
        ]);
    }
}
