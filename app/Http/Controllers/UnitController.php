<?php

namespace App\Http\Controllers;

use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
public function index(Request $request) {
    $query = Units::query();
    if ($request->search) {
        $query->where('unit_name', 'like', "%{$request->search}%");
    }
    $units = $query->latest()->paginate(5)->withQueryString();
    return view('units.index', compact('units'));
}

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
        ]);

        Units::create([
            'unit_name' => $request->unit_name,
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Unit berhasil ditambahkan!');
    }

    public function edit(Units $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Units $unit)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
        ]);

        $unit->update([
            'unit_name' => $request->unit_name,
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Unit berhasil diupdate!');
    }

    public function destroy(Units $unit)
    {
        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'Unit berhasil dihapus!');
    }
}