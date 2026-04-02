<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class POrtofolios extends Model
{
    protected $table = 'portofolios';
    protected $primaryKey = 'portofolio_id';
    protected $fillable = [
        'title',
        'photo',
        'description',
        'slug',        // <-- TAMBAHKAN INI
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate slug dari title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            $portfolio->slug = Str::slug($portfolio->title);
        });

        static::updating(function ($portfolio) {
            $portfolio->slug = Str::slug($portfolio->title);
        });
    }
}