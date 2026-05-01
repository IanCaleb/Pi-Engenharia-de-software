<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string|unique:batches,batch_number',
            'quantity' => 'required|integer|min:1',
            'entry_date' => 'required|date',
            'expiration_date' => 'required|date|after:entry_date',
        ];
    }
}
