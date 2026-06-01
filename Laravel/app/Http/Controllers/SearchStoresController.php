<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class SearchStoresController extends Controller
{
    /**
     * Exibir tela de buscar lojas com doações disponíveis
     * GET /user/buscar-lojas
     */
    public function index(Request $request)
    {
        // Busca todas as doações disponíveis com relacionamentos
        $doacoesQuery = Donation::where('status', 'disponivel')
            ->with(['store', 'batch.product'])
            ->orderBy('created_at', 'desc');

        // Aplica filtro de busca se existir
        if ($request->has('busca') && $request->busca) {
            $busca = $request->busca;
            $doacoesQuery->whereHas('batch.product', function ($query) use ($busca) {
                $query->where('name', 'like', '%' . $busca . '%');
            })
            ->orWhereHas('store', function ($query) use ($busca) {
                $query->where('name', 'like', '%' . $busca . '%');
            });
        }

        // Aplica filtro de cidade se existir
        if ($request->has('cidade') && $request->cidade) {
            $cidade = $request->cidade;
            $doacoesQuery->whereHas('store', function ($query) use ($cidade) {
                $query->where('city', 'like', '%' . $cidade . '%');
            });
        }

        $doacoes = $doacoesQuery->get();

        // Divide em lojas próximas (últimas 4) e últimas lojas
        $lojasProximas = $doacoes->take(4);
        $ultimasLojas = $doacoes->skip(4)->take(4);

        return view('user.buscar-lojas', compact('lojasProximas', 'ultimasLojas'));
    }
}
