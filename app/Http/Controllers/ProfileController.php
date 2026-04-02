<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profiles;
use App\Models\User;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil profile beserta relasi wilayahnya
        // Pastikan 'user_id' sesuai dengan nama kolom di tabel profiles
        $profile = Profiles::with(['province', 'city', 'district', 'village'])
                    ->where('user_id', $user->user_id) 
                    ->first();

        $provinces = Province::all();

        // Logika agar dropdown tidak kosong saat refresh
        // Kita menggunakan Code dari relasi untuk memfilter wilayah
        $regencies = [];
        $districts = [];
        $villages  = [];

        if ($profile) {
            // Cek apakah relasi province ada, jika ada ambil code-nya
            if ($profile->province) {
                $regencies = City::where('province_code', $profile->province->code)->get();
            }
            if ($profile->city) {
                $districts = District::where('city_code', $profile->city->code)->get();
            }
            if ($profile->district) {
                $villages  = Village::where('district_code', $profile->district->code)->get();
            }
        }

        return view('profiles.index', compact('profile', 'provinces', 'regencies', 'districts', 'villages'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'username'    => 'required|string|max:255',
            'full_name'   => 'required|string|max:255',
            'alamat'      => 'required',
            'province_id' => 'required', // Ini CODE (32)
            'city_id'     => 'required',     // Ini CODE (3201)
            'district_id' => 'required',
            'village_id'  => 'required',
        ]);

        // 2. KONVERSI KODE KE ID (SOLUSI SUMBAR JADI CILACAP)
        // Kita cari baris di tabel wilayah yang punya code tersebut
        $provinceData = Province::where('code', $request->province_id)->first();
        $cityData     = City::where('code', $request->city_id)->first();
        $districtData = District::where('code', $request->district_id)->first();
        $villageData  = Village::where('code', $request->village_id)->first();

        // Pastikan data wilayah ditemukan
        if (!$provinceData || !$cityData || !$districtData || !$villageData) {
            return back()->with('error', 'Data wilayah tidak valid!');
        }

        $user = Auth::user();

        // 3. Update User (Username & Password)
        $user->username = $request->username;
        
        // Cek jika password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // SAVE USER (Ini yang bikin password tersimpan)
        $user->save();

        // 4. Update Profile
        // Gunakan ID asli dari hasil pencarian di atas ($provinceData->id, dst)
        Profiles::updateOrCreate(
            ['user_id' => $user->user_id], // Kunci pencarian
            [
                'full_name'   => $request->full_name,
                'no_telp'     => $request->no_telp,
                'alamat'      => $request->alamat,
                'province_id' => $provinceData->id, // Simpan ID (1, 2, 3...)
                'city_id'     => $cityData->id,
                'district_id' => $districtData->id,
                'village_id'  => $villageData->id,
            ]
        );

        return back()->with('success', 'Profil dan Password berhasil diperbarui!');
    }
}