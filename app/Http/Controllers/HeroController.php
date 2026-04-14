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
    $hero  = Heros::where('section', 'hero')->first();
    $about = Heros::where('section', 'about')->first();
    return view('heros.index', compact('hero', 'about'));
}

public function update(Request $request, Heros $hero)
{
    $request->validate([
        'label'       => 'required|string|max:255',
        'headline'    => 'required|string|max:255',
        'subheadline' => 'nullable|string',
        'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data              = $request->only(['label', 'headline', 'subheadline', 'button_link']);
    $data['is_active'] = $request->has('is_active');

    if ($request->hasFile('photo')) {
        if ($hero->photo && Storage::disk('public')->exists('heros/' . $hero->photo)) {
            Storage::disk('public')->delete('heros/' . $hero->photo);
        }
        $file     = $request->file('photo');
        $filename = time() . '_' . Str::slug($request->label) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('heros', $filename, 'public');
        $data['photo'] = $filename;
    }

    $hero->update($data);

    // Redirect ke index (bukan edit) dengan tab aktif
    return redirect()
        ->route('heros.index')
        ->with('success', 'Data berhasil disimpan!')
        ->with('active_tab', $request->input('active_tab', 'hero'));
}
}