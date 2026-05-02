<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatchRequest;
use App\Models\Batch;

class BatchController extends Controller
{
    public function store(BatchRequest $request)
    {
        Batch::create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Lote cadastrado com sucesso!');
    }

    public function update(BatchRequest $request, Batch $batch)
    {
        $batch->update($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Lote atualizado com sucesso!');
    }
}