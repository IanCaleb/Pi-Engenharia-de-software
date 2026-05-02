<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
    'entry_date' => 'date',
    'expiration_date' => 'date',
    ];

    // Cria o relacionamento com o Produto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function donations(): HasMany
    {
    return $this->hasMany(Donation::class);
    }
}