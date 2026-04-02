<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review',
                'order_id',   // tambahan

    ];

public function user()
{
    // Pastikan 'user_id' adalah foreign key di tabel ratings
    return $this->belongsTo(User::class, 'user_id');
}

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
