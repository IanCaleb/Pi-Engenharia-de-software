<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimentacao extends Model
{
    protected $table = 'movimentacoes';

    protected $fillable = [
        'product_id',
        'batch_id',
        'user_id',
        'tipo',
        'quantidade',
        'observacao',
    ];

    protected $casts = [
        'quantidade' => 'integer',
    ];

     // Relacionamento com o Produto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relacionamento com o Lote (opcional)
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    // Relacionamento com o Usuário (gerente que registrou)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
