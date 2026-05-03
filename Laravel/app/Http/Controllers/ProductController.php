<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Lista produtos do gerente logado com status de vencimento
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();

        // Conta produtos por nível de urgência para o dashboard
        $expired = $products->filter(fn($p) => $p->expirationStatus() === 'expired')->count();
        $warning = $products->filter(fn($p) => $p->expirationStatus() === 'warning')->count();
        $safe    = $products->filter(fn($p) => $p->expirationStatus() === 'safe')->count();

        return view('manager.produtos', compact('products', 'expired', 'warning', 'safe'));
    }

    /**
     * Retorna dados de vencimento para o dashboard
     */
    public function dashboard()
    {
        $products = Product::where('user_id', Auth::id())->get();

        $expired = $products->filter(fn($p) => $p->expirationStatus() === 'expired')->count();
        $warning = $products->filter(fn($p) => $p->expirationStatus() === 'warning')->count();
        $safe    = $products->filter(fn($p) => $p->expirationStatus() === 'safe')->count();

        return view('manager.dashboard', compact('products', 'expired', 'warning', 'safe'));
    }

    public function store(Request $request)
    {
        // 1. Valida os dados que vieram do modal em inglês
        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'expiration_date' => 'required|date',
        ]);

        // 2. Cria o produto vinculando obrigatoriamente ao gerente logado
        \App\Models\Product::create([
            'user_id'         => \Illuminate\Support\Facades\Auth::id(), // Pega o ID de quem está usando o sistema
            'name'            => $request->name,
            'category'        => $request->category,
            'quantity'        => $request->quantity,
            'expiration_date' => $request->expiration_date,
            'status'          => 'safe', // Todo produto novo nasce com status safe
        ]);

        // 3. Redirecionamento de volta para a tela
        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
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