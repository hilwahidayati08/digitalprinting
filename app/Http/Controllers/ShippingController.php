<?php

namespace App\Http\Controllers;

use App\Models\Shippings;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shippings::with(['province', 'city', 'district', 'village'])
            ->where('user_id', auth()->id())
            ->get();

        return view('shippings.index', compact('shippings'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get(); 
        return view('shippings.create', compact('provinces'));
    }

public function store(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'label'           => 'required|string',
        'recipient_name'  => 'required|string|max:255',
        'recipient_phone' => 'required|string|max:20',
        'address'         => 'required|string',
        'province_id'     => 'required|exists:indonesia_provinces,code',
        'city_id'         => 'required|exists:indonesia_cities,code',
        'district_id'     => 'required|exists:indonesia_districts,code',
        'village_id'      => 'required|exists:indonesia_villages,code',
        'postal_code'     => 'nullable|string|max:5',
    ]);

    if ($validator->fails()) {
        dd($validator->errors()->all()); // ← LIHAT ERROR VALIDASI DISINI
    }
    try {
        DB::beginTransaction();

        if ($request->has('is_default')) {
            Shippings::where('user_id', auth()->id())->update(['is_default' => 0]);
        }

        $shipping = Shippings::create([
            'user_id'         => auth()->id(),
            'label'           => $request->label,
            'recipient_name'  => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'address'         => $request->address,
            'province_id'     => $request->province_id,
            'city_id'         => $request->city_id,
            'district_id'     => $request->district_id,
            'village_id'      => $request->village_id,
            'postal_code'     => $request->postal_code,
            'is_default'      => $request->has('is_default') ? 1 : 0,
        ]);

        DB::commit();

        if ($request->filled('redirect_back')) {
            return redirect($request->redirect_back)
                ->with('success', 'Alamat baru berhasil ditambahkan!')
                ->with('new_address_id', $shipping->id);
        }

        return redirect()->route('shipping.index')->with('success', 'Alamat berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}

    // --- Sisanya (Edit, Destroy, API Methods) tetap sama ---
    /**
     * Method untuk Edit (Opsional)
     */
    public function edit($id)
    {
        $shipping = Shippings::where('user_id', auth()->id())->findOrFail($id);
        $provinces = Province::orderBy('name')->get();
        
        return view('shippings.edit', compact('shipping', 'provinces'));
    }

    /**
     * Hapus Alamat
     */
    public function destroy($id)
    {
        $shipping = Shippings::where('user_id', auth()->id())->findOrFail($id);
        $shipping->delete();

        return back()->with('success', 'Alamat berhasil dihapus');
    }

    // --- API Methods untuk Dropdown Bertingkat (AJAX) ---

    /**
     * Ambil data Kota berdasarkan ID Provinsi
     */
    public function getCities($provinceId)
    {
        // Pastikan menggunakan province_id (FK), bukan province_code
        $cities = City::where('province_id', $provinceId)
                      ->orderBy('name')
                      ->get();
        return response()->json($cities);
    }

    /**
     * Ambil data Kecamatan berdasarkan ID Kota
     */
    public function getDistricts($cityId)
    {
        $districts = District::where('city_id', $cityId)
                             ->orderBy('name')
                             ->get();
        return response()->json($districts);
    }

    /**
     * Ambil data Desa/Kelurahan berdasarkan ID Kecamatan
     */
    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)
                           ->orderBy('name')
                           ->get();
        return response()->json($villages);
    }
}