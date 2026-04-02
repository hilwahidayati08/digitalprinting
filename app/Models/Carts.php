<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id'
    ];

public function items()
{
    return $this->hasMany(CartItems::class,'cart_id','cart_id');
}

    public function subtotal()
    {
        return $this->items->sum('subtotal');
    }

    public function total()
    {
        return $this->subtotal();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
