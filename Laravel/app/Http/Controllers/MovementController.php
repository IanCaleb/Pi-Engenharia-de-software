<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = Movement::with('product')->get();

        $products = Product::all();

        return view('movements.index', compact(
            'movements',
            'products'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return view('movements.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',

            'movement_date' => 'required|date',

            'movement_type' => 'required|in:Compra,Venda,Doação,Expiração',

            'unit_price' => 'required|numeric|min:0',

            'moved_quantity' => 'required|integer|min:1',
        ]);

        Movement::create($validated);

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movement $movement)
    {
        return view('movements.show', compact('movement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movement $movement)
    {
        $products = Product::all();

        return view('movements.edit', compact(
            'movement',
            'products'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movement $movement)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',

            'movement_date' => 'required|date',

            'movement_type' => 'required|in:Compra,Venda,Doação,Expiração',

            'unit_price' => 'required|numeric|min:0',

            'moved_quantity' => 'required|integer|min:1',
        ]);

        $movement->update($validated);

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimento editado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movement deleted successfully.');
    }
}
