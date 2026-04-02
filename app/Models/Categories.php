<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'slug',
        'calc_type'
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id', 'category_id');
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->category_name);
            }
        });
    }
}

