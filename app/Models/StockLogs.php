<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLogs extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'material_id',
        'type',
        'amount',
        'last_stock',
        'description'
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Materials::class, 'material_id', 'material_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}