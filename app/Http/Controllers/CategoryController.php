<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
public function index(Request $request) {
    $query = Categories::withCount('products');
    if ($request->search) {
        $query->where('category_name', 'like', "%{$request->search}%");
            }
    $categories = $query->latest()->paginate(5)->withQueryString();
    return view('categories.index', compact('categories'));
}

    public function create()
    {
        return view('categories.create');
    }

public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'calc_type'     => 'required|in:luas,stiker,satuan', // Validasi enum
        ]);

        Categories::create([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
            'calc_type'     => $request->calc_type,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Categories $category)
    {
        return view('categories.edit', compact('category'));
    }

public function update(Request $request, Categories $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'calc_type'     => 'required|in:luas,stiker,satuan',
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
            'calc_type'     => $request->calc_type,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Categories $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
