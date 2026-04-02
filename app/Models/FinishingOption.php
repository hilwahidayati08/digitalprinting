<?php

// app/Models/FinishingOption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinishingOption extends Model
{
    protected $fillable = [
        'name', 
        'category', 
        'description', 
        'additional_price', 
        'price_type', 
        'is_active'
    ];

    // Relasi ke Produk (Many-to-Many)
    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_finishing');
    }
}
