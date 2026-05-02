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

    public function create() {}
    public function store(Request $request) {}
    public function show(Product $product) {}
    public function edit(Product $product) {}
    public function update(Request $request, Product $product) {}
    public function destroy(Product $product) {}
}