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
        $movements = Movement::with('product')
            ->whereHas('product', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->get();

        $products = Product::with('batch')
            ->where('user_id', auth()->id())
            ->get();

        return view('movements.index', compact('movements', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with('batch')->get();

        return view('movements.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'      => 'required|exists:products,id',
            'movement_type'   => 'required|in:Compra,Venda',
            'moved_quantity'  => 'required|integer|min:1',
            'unit_price'      => 'required|numeric|min:0',
            'movement_date'   => 'required|date',
        ]);

        $product = Product::with('batch')
            ->where('user_id', auth()->id())
            ->findOrFail($validated['product_id']);

        $batch = $product->batch;

        if (!$batch) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Não foi possível fazer essa movimentação. Este produto não possui lote cadastrado.'
                );
        }

        // Guarda qual lote foi movimentado
        $validated['batch_id'] = $batch->id;

        // Venda diminui estoque
        if ($validated['movement_type'] === 'Venda') {

            if ($batch->quantity < $validated['moved_quantity']) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Não foi possível fazer essa movimentação. Quantidade insuficiente em estoque.'
                    );
            }

            $batch->quantity -= $validated['moved_quantity'];
        }

        // Compra aumenta estoque
        if ($validated['movement_type'] === 'Compra') {
            $batch->quantity += $validated['moved_quantity'];
        }

        $batch->save(); 

        Movement::create($validated);

        return redirect()
            ->route('movements.index')
            ->with(
                'success',
                'Movimentação cadastrada com sucesso.'
            );
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
        $batch = $movement->batch;

        if (!$batch) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não foi possível remover a movimentação. Lote não encontrado.'
                );
        }

        if ($movement->movement_type === 'Compra') {

            if ($batch->quantity < $movement->moved_quantity) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Não foi possível remover a movimentação.'
                    );
            }

            $batch->quantity -= $movement->moved_quantity;
        } else {

            $batch->quantity += $movement->moved_quantity;
        }

        $batch->save();

        $movement->delete();

        return redirect()
            ->route('movements.index')
            ->with(
                'success',
                'Movimentação removida com sucesso.'
            );
    }
}
