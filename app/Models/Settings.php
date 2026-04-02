<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table      = 'settings';
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'whatsapp',
        'email',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'time_open',
        'time_close',
        'address',

        // Syarat pengajuan member
        'member_min_orders',  // minimal jumlah order
        'member_min_spent',   // minimal total belanja

        // Rate diskon per tier
        'rate_regular',       // diskon % untuk tier Regular
        'rate_plus',          // diskon % untuk tier Plus
        'rate_premium',       // diskon % untuk tier Premium

        // Batas naik tier (total belanja kumulatif)
        'tier_plus_min',      // min. belanja untuk naik ke Plus
        'tier_premium_min',   // min. belanja untuk naik ke Premium
    ];

    protected $casts = [
        'member_min_spent' => 'decimal:2',
        'rate_regular'     => 'decimal:2',
        'rate_plus'        => 'decimal:2',
        'rate_premium'     => 'decimal:2',
        'tier_plus_min'    => 'decimal:2',
        'tier_premium_min' => 'decimal:2',
    ];

    
}