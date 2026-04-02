<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class IndonesiaController extends Controller
{
    public function cities($provinceId)
    {
        // 1. Cari dulu data provinsinya berdasarkan ID
        $province = Province::find($provinceId);
        
        if (!$province) return response()->json([]);

        // 2. Cari kota menggunakan 'province_code' (sesuai error database Anda)
        $cities = City::where('province_code', $province->code)->pluck('name', 'id');
        
        return response()->json($cities);
    }

    public function districts($cityId)
    {
        $city = City::find($cityId);
        if (!$city) return response()->json([]);

        // Gunakan 'city_code' bukan 'city_id'
        $districts = District::where('city_code', $city->code)->pluck('name', 'id');
        
        return response()->json($districts);
    }

    public function villages($districtId)
    {
        $district = District::find($districtId);
        if (!$district) return response()->json([]);

        // Gunakan 'district_code' bukan 'district_id'
        $villages = Village::where('district_code', $district->code)->pluck('name', 'id');
        
        return response()->json($villages);
    }
}