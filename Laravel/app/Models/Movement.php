<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'product_id',
        'batch_id',
        'movement_date',
        'movement_type',
        'unit_price',
        'moved_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
}