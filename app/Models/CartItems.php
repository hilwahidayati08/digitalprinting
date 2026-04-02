<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $table = 'cart_items';

    protected $primaryKey = 'cart_item_id';

    protected $fillable = [
        'cart_id',
        'product_id',
        'width_cm',
        'height_cm',
        'used_material_qty',
        'qty',
        'total_yield_pcs',
        'price',
        'subtotal',
        'notes',
    ];

    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}