<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class Shippings extends Model
{
    protected $primaryKey = 'shipping_id';
    
    protected $fillable = [
        'user_id',
        'label',
        'address',
        'province_id', // 
        'city_id',     // 
        'district_id', // 
        'village_id',  // 
        'recipient_name',
        'recipient_phone',
        'postal_code',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ✅ RELASI DENGAN CODE!
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'code');
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address;
        $address .= ', ' . ($this->village->name ?? '');
        $address .= ', ' . ($this->district->name ?? '');
        $address .= ', ' . ($this->city->name ?? '');
        $address .= ', ' . ($this->province->name ?? '');
        
        if ($this->postal_code) {
            $address .= ' - ' . $this->postal_code;
        }
        
        return $address;
    }
}