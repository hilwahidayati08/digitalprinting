<?php

namespace App\Http\Controllers;

use App\Models\Heros;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heros = Heros::all();
        return view('heros.index', compact('heros'));
    }

    public function create()
    {
        return view('heros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'headline' => 'required|string|max:255',
            'subheadline' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->label) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/heros
            $file->storeAs('heros', $filename, 'public');
            $data['photo'] = $filename;
        }

        Heros::create($data);

        return redirect()->route('heros.index')->with('success', 'Hero berhasil ditambahkan!');
    }

    // --- INI FUNGSI YANG TADI HILANG ---
    public function edit(Heros $hero)
    {
        return view('heros.edit', compact('hero'));
    }

    public function update(Request $request, Heros $hero)
    {
$request->validate([
    'label' => 'required|string|max:255',
    'headline' => 'required|string|max:255',
    'subheadline' => 'nullable|string',
    'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($hero->photo && Storage::disk('public')->exists('heros/' . $hero->photo)) {
                Storage::disk('public')->delete('heros/' . $hero->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->label) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('heros', $filename, 'public');
            $data['photo'] = $filename;
        }

        $hero->update($data);

        return redirect()->route('heros.index')->with('success', 'Hero diperbarui!');
    }

    public function destroy(Heros $hero)
    {
        if ($hero->photo && Storage::disk('public')->exists('heros/' . $hero->photo)) {
            Storage::disk('public')->delete('heros/' . $hero->photo);
        }

        $hero->delete();

        return redirect()->route('heros.index')->with('success', 'Hero berhasil dihapus!');
    }
}