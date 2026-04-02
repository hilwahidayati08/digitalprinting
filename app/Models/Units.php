<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Units extends Model
{
    protected $primaryKey = 'unit_id';

    protected $fillable = [
        'unit_name',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'unit_id');
    }
}

