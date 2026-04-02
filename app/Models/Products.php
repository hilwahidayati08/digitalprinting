<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

protected $fillable = [
    'category_id',
    'unit_id',
    'material_id',
    'product_name',
    'slug',
    'description',
    'price',
    'is_active',
    'production_time',

    // ukuran default (untuk kartu nama dll)
    'default_width_cm',
    'default_height_cm',

    // apakah boleh custom ukuran
    'allow_custom_size'
];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Units::class, 'unit_id', 'unit_id');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
    public function ratings()
    {
        return $this->hasMany(Ratings::class, 'product_id', 'product_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItems::class, 'product_id', 'product_id');
    }
    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->product_name);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id');
    }

    // Ambil foto primary saja
    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id', 'product_id')
                    ->where('is_primary', true);
    }
    public function getRouteKeyName()
{
    return 'slug';
}
}
