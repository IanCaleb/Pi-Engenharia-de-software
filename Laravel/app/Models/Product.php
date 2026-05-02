<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'quantity',
        'expiration_date',
        'status'
    ];

    // Converte expiration_date automaticamente para objeto Carbon
    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    /**
     * Calcula os dias restantes até o vencimento
     * Negativo = já vencido
     */
    public function daysUntilExpiration(): int
    {
        return (int) Carbon::today()->diffInDays($this->expiration_date, false);
    }

    /**
     * "expired"  → já venceu (dias < 0)
     * "warning"  → vence em até 7 dias (0 <= dias <= 7)
     * "safe"     → vence em mais de 7 dias (dias > 7)
     */
    public function expirationStatus(): string
    {
        $days = $this->daysUntilExpiration();

        if ($days < 0) {
            return 'expired';
        }

        if ($days <= 7) {
            return 'warning';
        }

        return 'safe';
    }

    /**
     * Exemplo: "Vencido há 3 dias", "Vence hoje!", "Vence em 5 dias"
     */
    public function expirationMessage(): string
    {
        $days = $this->daysUntilExpiration();

        if ($days < 0) {
            return 'Vencido há ' . abs($days) . ' dia(s)';
        }

        if ($days === 0) {
            return 'Vence hoje!';
        }

        return 'Vence em ' . $days . ' dia(s)';
    }
}