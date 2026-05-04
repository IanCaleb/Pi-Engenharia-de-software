<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
 * Lista produtos do gerente logado com filtros de busca e status
 */
public function index(Request $request)
{
    $search = $request->get('search');
    $status = $request->get('status');

    $today = \Carbon\Carbon::today();

    $batches = \App\Models\Batch::with('product')
        ->whereHas('product', function ($q) use ($search) {
            $q->where('user_id', Auth::id());
            
            if ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('category', 'LIKE', "%{$search}%");
                });
            }
        })
        ->where('quantity', '>', 0)
        ->when($status, function ($query, $status) use ($today) {
            if ($status === 'expired') $query->where('expiration_date', '<', $today);
            elseif ($status === 'warning') $query->whereBetween('expiration_date', [$today, $today->copy()->addDays(7)]);
            elseif ($status === 'safe') $query->where('expiration_date', '>', $today->copy()->addDays(7));
        })
        ->get();

    //  OS CONTADORES DO TOPO DA TELA (Sem os filtros, para mostrar o total real da loja)
    $allBatches = \App\Models\Batch::whereHas('product', function ($q) {
        $q->where('user_id', Auth::id());
    })
    ->where('quantity', '>', 0) //Só pega o que tem mais de zero
    ->get();

    $expired = $allBatches->filter(fn($b) => $b->expirationStatus() === 'expired')->count();
    $warning = $allBatches->filter(fn($b) => $b->expirationStatus() === 'warning')->count();
    $safe    = $allBatches->filter(fn($b) => $b->expirationStatus() === 'safe')->count();

   
    return view('manager.produtos', compact('batches', 'expired', 'warning', 'safe', 'search', 'status'));
}

    /**
     * Retorna dados de vencimento para o dashboard
     */
    public function dashboard()
    {
        $batches = \App\Models\Batch::with('product')
            ->whereHas('product', function ($q) {
                $q->where('user_id', \Illuminate\Support\Facades\Auth::id());
            })->get();

        
        $expired = $batches->filter(fn($b) => $b->expirationStatus() === 'expired')->count();
        $warning = $batches->filter(fn($b) => $b->expirationStatus() === 'warning')->count();
        $safe    = $batches->filter(fn($b) => $b->expirationStatus() === 'safe')->count();

        
        return view('manager.dashboard', compact('batches', 'expired', 'warning', 'safe'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'quantity'        => 'required|integer|min:1',
            'expiration_date' => 'required|date',
        ]);

        // 1. ACHA ou CRIA o produto base (Ex: "Leite Integral" dos Laticínios)
        $product = \App\Models\Product::firstOrCreate(
            ['user_id' => Auth::id(), 'name' => $request->name],
            ['category' => $request->category, 'status' => 'ativo']
        );

        // 2. Cria O LOTE com a quantidade e validade específica
        \App\Models\Batch::create([
            'product_id'      => $product->id,
            'batch_number'    => strtoupper(uniqid('LOTE-')), // gerador automatico de lote
            'quantity'        => $request->quantity,
            'expiration_date' => $request->expiration_date,
            'entry_date'      => now(),
            'status'          => 'disponivel', 
    ]);

        return redirect()->back()->with('success', 'Lote do produto adicionado com sucesso!');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->back()->with('success', 'Produto removido com sucesso!');    
    }

    public function create() {}
    public function show(Product $product) {}
    public function edit(Product $product) {}
    public function update(Request $request, Product $product) {}
}