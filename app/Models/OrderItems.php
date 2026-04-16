<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $primaryKey = 'order_item_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'finishing_id',
        'qty',
        'width_cm',
        'height_cm',
        'total_yield_pcs',
        'used_material_qty',
        'unit_price',
        'subtotal',
        'design_file',
        'design_link',
        'notes',
    ];

    protected $casts = [
        'width_cm'          => 'decimal:2',
        'height_cm'         => 'decimal:2',
        'used_material_qty' => 'decimal:2',
        'unit_price'        => 'decimal:2',
        'subtotal'          => 'decimal:2',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }


}