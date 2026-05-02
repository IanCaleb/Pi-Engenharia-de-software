<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationRequest extends Model
{
    protected $fillable = [
        'donation_id',
        'donatario_id',
        'status',
    ];

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    public function donatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donatario_id');
    }
}