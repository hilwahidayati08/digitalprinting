<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materials extends Model
{
    protected $primaryKey = 'material_id';

    // Tambahkan min_stock ke fillable agar bisa disimpan
    protected $fillable = [
        'material_name',
        'material_type',
        'width_cm',
        'height_cm',
        'spacing_mm',
        'stock',
        'min_stock', 
        'unit_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'material_id');
    }

    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLogs::class, 'material_id', 'material_id');
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO ACTIONS (BOOTED)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        // Saat material baru dibuat pertama kali
        static::created(function ($material) {
            if ($material->stock > 0) {
                StockLogs::create([
                    'material_id' => $material->material_id,
                    'type'        => 'in',
                    'amount'      => $material->stock,
                    'last_stock'  => $material->stock,
                    'description' => 'Stok awal material',
                ]);
            }
        });

        // Logika Notifikasi Stok Kritis
        static::updated(function ($material) {
            // Jika stok berubah dan nilainya menyentuh atau di bawah batas minimum
            if ($material->wasChanged('stock') && $material->stock <= $material->min_stock) {
                
                // Pastikan admin mendapatkan notifikasi (Sesuaikan user_id admin kamu)
                Notification::create([
                    'user_id' => 1, 
                    'title'   => '⚠️ Stok Kritis: ' . $material->material_name,
                    'message' => "Sisa bahan tinggal {$material->stock}, sudah mencapai batas aman ({$material->min_stock}).",
                    'url'     => '/admin/materials', // Ubah sesuai route menu material kamu
                    'is_read' => false,
                ]);
            }
        });
    }
}