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

    $products = Product::where('user_id', Auth::id())
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        })
        ->when($status, function ($query, $status) use ($today) {
            if ($status === 'expired') {
                $query->where('expiration_date', '<', $today);
            } elseif ($status === 'warning') {
                $query->where('expiration_date', '>=', $today)
                      ->where('expiration_date', '<=', $today->copy()->addDays(7));
            } elseif ($status === 'safe') {
                $query->where('expiration_date', '>', $today->copy()->addDays(7));
            }
        })
        ->get();

    // Sempre conta com base em TODOS os produtos (sem filtro) para o resumo
    $allProducts = Product::where('user_id', Auth::id())->get();
    $expired = $allProducts->filter(fn($p) => $p->expirationStatus() === 'expired')->count();
    $warning = $allProducts->filter(fn($p) => $p->expirationStatus() === 'warning')->count();
    $safe    = $allProducts->filter(fn($p) => $p->expirationStatus() === 'safe')->count();

    return view('manager.produtos', compact('products', 'expired', 'warning', 'safe', 'search', 'status'));
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