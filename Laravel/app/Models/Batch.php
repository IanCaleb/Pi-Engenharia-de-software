<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batch extends Model
{
    // Permite que essas colunas sejam salvas em massa
    protected $fillable = [
        'product_id', 
        'batch_number', 
        'quantity', 
        'entry_date', 
        'expiration_date'
    ];

    // Cria o relacionamento com o Produto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}