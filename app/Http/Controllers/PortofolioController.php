<?php

namespace App\Http\Controllers;

use App\Models\Portofolios;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortofolioController extends Controller
{
    
        public function index(Request $request)
    {
        $query = Portofolios::where('is_active', true);
 
        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
 
        // Sort
        match ($request->get('sort', 'newest')) {
            'oldest' => $query->oldest(),
            'az'     => $query->orderBy('title', 'asc'),
            'za'     => $query->orderBy('title', 'desc'),
            default  => $query->latest(),
        };
 
        // Pagination 12 per halaman (sama dengan products page)
        $portofolios = $query->paginate(12);
 
        return view('portofolios', compact('portofolios'));
    }
    public function indexAdmin()
    {
        $portofolios = Portofolios::all();
        return view('portofolios.index', compact('portofolios'));
    }

    public function create()
    {
        return view('portofolios.create');
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'description' => 'required',
        'is_active' => 'nullable|boolean'
    ]);

    // 1. Ambil file foto
    $photo = $request->file('photo');
    
    // 2. Buat nama file unik
    $photoName = time() . '-' . Str::slug($request->title) . '.' . $photo->getClientOriginalExtension();

    // 3. Pindahkan ke public_path agar sama dengan fungsi UPDATE yang sudah jalan
    $photo->move(public_path('storage/portofolios'), $photoName);

    // 4. Simpan ke Database
    Portofolios::create([
        'title' => $request->title,
        'slug' => Str::slug($request->title), // Tambahkan ini agar link detail tidak error
        'photo' => $photoName,
        'description' => $request->description,
        'is_active' => $request->is_active ?? 0,
    ]);

    return redirect()->route('portofolios.index')
        ->with('success', 'Portofolio berhasil ditambahkan');
}

    public function edit($id)
    {
        $portofolio = Portofolios::findOrFail($id);
        return view('portofolios.edit', compact('portofolio'));
    }

    public function update(Request $request, $id)
    {
        $portofolio = Portofolios::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($portofolio->photo && file_exists(public_path('storage/portofolios/'.$portofolio->photo))) {
                unlink(public_path('storage/portofolios/'.$portofolio->photo));
            }

            $imageName = time() . '-' . Str::slug($request->title) . '.' .
                        $request->photo->extension();

            $request->photo->move(public_path('storage/portofolios'), $imageName);
            $portofolio->photo = $imageName;
        }

        $portofolio->title = $request->title;
        $portofolio->description = $request->description;
        $portofolio->is_active = $request->is_active ?? 0;
        $portofolio->save();

        return redirect()->route('portofolios.index')
            ->with('success', 'Portofolio berhasil diupdate');
    }

    public function show($slug)
    {
        // Ambil data portfolio berdasarkan slug
        $portfolio = Portofolios::where('slug', $slug)
                              ->where('is_active', true)
                              ->firstOrFail();
        
        // Ambil portfolio terkait (3 random portfolio lain)
        $relatedPortfolios = Portofolios::where('is_active', true)
                                      ->where('portofolio_id', '!=', $portfolio->portofolio_id)
                                      ->inRandomOrder()
                                      ->limit(3)
                                      ->get();
        
        return view('portofolios.show', compact('portfolio', 'relatedPortfolios'));
    }

    public function destroy($id)
    {
        Portofolios::findOrFail($id)->delete();
        return redirect()->route('portofolios.index')
            ->with('success', 'Portofolio berhasil dihapus');
    }
}
