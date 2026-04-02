<?php

// app/Http/Controllers/FinishingOptionController.php

namespace App\Http\Controllers;

use App\Models\FinishingOption;
use Illuminate\Http\Request;

class FinishingOptionController extends Controller
{
    // Mengambil semua data finishing untuk ditampilkan di halaman produk
    public function index()
    {
        $finishingOptions = FinishingOption::where('is_active', true)
                            ->get()
                            ->groupBy('category');

        return view('shop.product-detail', compact('finishingOptions'));
    }

    // Menyimpan pilihan finishing baru (untuk dashboard Admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'additional_price' => 'required|numeric',
            'price_type' => 'required|in:fixed,per_unit,per_meter',
        ]);

        FinishingOption::create($validated);

        return redirect()->back()->with('success', 'Opsi finishing berhasil ditambahkan!');
    }
}