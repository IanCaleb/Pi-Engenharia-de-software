<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = ['product_id','batch_number', 'quantity', 'expiration_date', 'entry_date', 'status'];

    protected $casts = [
        'entry_date' => 'date',
        'expiration_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function daysUntilExpiration(): int
    {
        return (int) Carbon::today()->diffInDays($this->expiration_date, false);
    }

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