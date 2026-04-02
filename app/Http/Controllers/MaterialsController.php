<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materials;
use App\Models\Units;

class MaterialsController extends Controller
{

public function index(Request $request) {
    $query = Materials::with('unit');
    if ($request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('material_name', 'like', "%$search%")
              ->orWhereHas('unit', function($u) use ($search) {
                  $u->where('unit_name', 'like', "%$search%");
              });
        });
    }
    $materials = $query->orderBy('material_name', 'asc')->paginate(5)->withQueryString();
    return view('materials.index', compact('materials'));
}


    public function create()
    {
        $units = Units::orderBy('unit_name','asc')->get();

        return view('materials.create', compact('units'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'material_type' => 'required|in:roll,sheet,pcs',
            'width_cm'      => 'nullable|numeric|min:0',
            'height_cm'     => 'nullable|numeric|min:0',
            'spacing_mm'    => 'nullable|numeric|min:0',
            'stock'     => 'required|numeric|min:0',
            'unit_id'       => 'required|exists:units,unit_id',
        ]);

        Materials::create($request->all());

        return redirect()
                ->route('materials.index')
                ->with('success','Material berhasil ditambahkan');
    }


    public function edit($id)
    {
        $material = Materials::findOrFail($id);
        $units = Units::orderBy('unit_name','asc')->get();

        return view('materials.edit', compact('material','units'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'material_type' => 'required|in:roll,sheet,pcs',
            'width_cm'      => 'nullable|numeric|min:0',
            'height_cm'     => 'nullable|numeric|min:0',
            'spacing_mm'    => 'nullable|numeric|min:0',
            'stock'     => 'required|numeric|min:0',
            'unit_id'       => 'required|exists:units,unit_id',
        ]);

        $material = Materials::findOrFail($id);

        $material->update($request->all());

        return redirect()
                ->route('materials.index')
                ->with('success','Material berhasil diperbarui');
    }


    public function destroy($id)
    {
        $material = Materials::findOrFail($id);

        $material->delete();

        return redirect()
                ->route('materials.index')
                ->with('success','Material berhasil dihapus');
    }


    /*
    |--------------------------------------------------------------------------
    | RESTOCK
    |--------------------------------------------------------------------------
    */

public function updateStock(Request $request, $id)
{
    // 1. Validasi input
    $request->validate([
        'add_stock' => 'required|numeric|min:0.01',
    ]);

    // 2. Cari data bahannya
    $material = Materials::findOrFail($id);

    // 3. Tambahkan stoknya
    // Kita pakai increment agar lebih aman dari race condition
    $material->increment('stock', $request->add_stock);

    // 4. (Opsional) Catat ke log riwayat stok jika kamu punya tabelnya
    // StockLog::create([...]);

    return redirect()->back()->with('success', "Stok {$material->material_name} berhasil ditambah!");
}
}