<?php

namespace App\Http\Controllers;

use App\Models\Shippings;
use App\Models\User;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Log;
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
        try {
            $request->validate([
                'recipient_name'  => 'required|string|max:255',
                'recipient_phone' => 'required|string|max:20',
                'address'         => 'required|string',
                'province_id'     => 'required',
                'city_id'         => 'required',
                'district_id'     => 'required',
                'village_id'      => 'required',
                'label'           => 'nullable|string|max:30',
                'is_default'      => 'nullable|boolean',
                'postal_code'     => 'nullable|string|max:5',
            ]);

            // ── Tentukan user_id ──────────────────────────────────────────────
            // Kalau request datang dari admin (ada user_id di payload), pakai itu.
            // Kalau tidak (user biasa simpan alamat sendiri), pakai auth()->id().
            $isAdminRequest = auth()->check()
                && auth()->user()->role === 'admin'
                && $request->filled('user_id');

            $userId = $isAdminRequest
                ? (int) $request->user_id
                : auth()->id();

            if (!$userId) {
                $msg = 'User tidak ditemukan.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 422);
                }
                return redirect()->back()->withErrors(['error' => $msg]);
            }

            // Pastikan user target memang ada
            if (!User::find($userId)) {
                $msg = 'User dengan ID ' . $userId . ' tidak ditemukan.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 404);
                }
                return redirect()->back()->withErrors(['error' => $msg]);
            }

            // Jika jadikan utama, unset yang lain dulu
            if ($request->boolean('is_default')) {
                Shippings::where('user_id', $userId)->update(['is_default' => false]);
            }

            $shipping = Shippings::create([
                'user_id'         => $userId,
                'recipient_name'  => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'address'         => $request->address,
                'province_id'     => $request->province_id,
                'city_id'         => $request->city_id,
                'district_id'     => $request->district_id,
                'village_id'      => $request->village_id,
                'label'           => $request->label,
                'is_default'      => $request->boolean('is_default'),
                'postal_code'     => $request->postal_code,
            ]);

            // Load relasi supaya frontend bisa langsung render kartu alamat
            $shipping->load(['village', 'district', 'city', 'province']);

            // AJAX / JSON request (dari modal admin create order)
            if ($request->expectsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Alamat berhasil ditambahkan.',
                    'shipping' => $shipping,
                ]);
            }

            return redirect()->route('shippings.index')->with('success', 'Alamat berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors'  => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Shipping store error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan alamat: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan alamat: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $shipping  = Shippings::where('user_id', auth()->id())->findOrFail($id);
        $provinces = Province::orderBy('name')->get();
        return view('shippings.edit', compact('shipping', 'provinces'));
    }

    public function destroy($id)
    {
        $shipping = Shippings::where('user_id', auth()->id())->findOrFail($id);
        $shipping->delete();
        return back()->with('success', 'Alamat berhasil dihapus');
    }

    // ── API Dropdown Bertingkat ───────────────────────────────────────────────

    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->orderBy('name')->get();
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = District::where('city_id', $cityId)->orderBy('name')->get();
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->orderBy('name')->get();
        return response()->json($villages);
    }
}