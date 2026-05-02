<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Importante adicionar isso

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
            
            // Regra corrigida para ignorar o próprio ID durante o Update
            'batch_number' => [
                'required',
                'string',
                Rule::unique('batches', 'batch_number')->ignore($this->batch)
            ],
            
            // min:0 garante que não seja negativa, mas permite zerar o estoque na correção
            'quantity' => 'required|integer|min:0', 
            
            'entry_date' => 'required|date',
            
            // Garante que seja no futuro E depois da data de entrada
            'expiration_date' => 'required|date|after:today|after:entry_date', 
        ];
    }
}