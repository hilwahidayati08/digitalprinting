<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Units;
use App\Models\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
public function indexAdmin(Request $request)
{
    // 1. Inisialisasi query dengan Eager Loading untuk performa
    $query = Products::with(['category', 'unit', 'material', 'images']);

    // 2. Logika Pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('product_name', 'like', "%$search%")
              ->orWhere('slug', 'like', "%$search%")
              // Cari berdasarkan nama kategori
              ->orWhereHas('category', function($cat) use ($search) {
                  $cat->where('category_name', 'like', "%$search%");
              });
        });
    }

    // 3. Gunakan paginate(5) dan withQueryString agar parameter 'search' tidak hilang saat pindah halaman
    $products = $query->latest()->paginate(5)->withQueryString();

    return view('products.index', compact('products'));
}
    public function index(Request $request)
    {
        $query = Products::with(['category', 'unit', 'images' => function($q) {
            $q->where('is_primary', 1);
        }])->where('is_active', 1);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($cat) use ($search) {
                      $cat->where('category_name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Category filter - ambil dari data yang ada
        if ($request->filled('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(8)->withQueryString(); // Ubah jadi 8 per halaman
        
        // Ambil semua kategori untuk filter
        $categories = Categories::orderBy('category_name')->get();
        
        // Untuk debugging - cek apakah produk ditemukan
        // dd($products->total()); // Uncomment untuk debug
        
        return view('frontend.products.products', compact('products', 'categories'));
    }




    public function create()
    {
        $categories = Categories::all();
        $units      = Units::all();
        $materials  = Materials::all();

        return view('products.create', compact('categories', 'units', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,category_id',
            'unit_id'           => 'required|exists:units,unit_id',
            'material_id'       => 'required|exists:materials,material_id',
            'product_name'      => 'required|string|max:100',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'is_active'         => 'nullable',
            'allow_custom_size' => 'nullable',
            // Input dari form dalam METER, validasi min 0
            'default_width_cm'  => 'nullable|numeric|min:0',
            'default_height_cm' => 'nullable|numeric|min:0',
            'photos'            => 'required|array|min:1|max:5',
            'photos.*'          => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'primary_photo'     => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // ✅ Konversi dari METER ke CM sebelum disimpan
            // Form admin input dalam meter (misal 1.6), DB simpan dalam cm (160)
            $widthCm  = $request->filled('default_width_cm')
                ? (float) $request->default_width_cm * 100
                : 100; // default 100cm jika kosong

            $heightCm = $request->filled('default_height_cm')
                ? (float) $request->default_height_cm * 100
                : 100; // default 100cm jika kosong

            $product = Products::create([
                'category_id'       => $request->category_id,
                'unit_id'           => $request->unit_id,
                'material_id'       => $request->material_id,
                'product_name'      => $request->product_name,
                'slug'              => Str::slug($request->product_name) . '-' . Str::random(5),
                'description'       => $request->description,
                'price'             => $request->price,
                'is_active'         => $request->has('is_active') ? true : false,
                'allow_custom_size' => $request->has('allow_custom_size') ? true : false,
                'default_width_cm'  => $widthCm,
                'default_height_cm' => $heightCm,
            ]);

            if ($request->hasFile('photos')) {
                $primaryIndex = $request->input('primary_photo', 0);

                foreach ($request->file('photos') as $index => $photo) {
                    $path = $photo->store("products/{$product->product_id}", 'public');

                    ProductImages::create([
                        'product_id' => $product->product_id,
                        'photo'      => $path,
                        'is_primary' => ($index == $primaryIndex),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal database: ' . $e->getMessage());
        }
    }

    public function show(string $product)
    {
        $product = Products::with(['category', 'unit','material', 'images'])
            ->where('slug', $product)
            ->orWhere('product_id', is_numeric($product) ? $product : 0)
            ->firstOrFail();

        $allImages = $product->images->sortByDesc('is_primary')->values();

        $relatedProducts = Products::with(['images', 'category'])
                        ->where('category_id', $product->category_id)
                        ->where('product_id', '!=', $product->product_id) // Jangan tampilkan produk yang sama
                        ->where('is_active', 1)
                        ->limit(4)
                        ->get();

        return view('frontend.products.show', compact('product', 'allImages', 'relatedProducts'));
    }

    public function edit($id)
    {
        $product    = Products::with('images')->findOrFail($id);
        $categories = Categories::all();
        $units      = Units::all();
        $materials  = Materials::all();

        // ✅ Konversi balik dari CM ke METER untuk ditampilkan di form edit
        // Agar form tetap tampilkan nilai dalam meter sesuai ekspektasi admin
        $product->default_width_m  = $product->default_width_cm  ? $product->default_width_cm  / 100 : null;
        $product->default_height_m = $product->default_height_cm ? $product->default_height_cm / 100 : null;

        return view('products.edit', compact('product', 'categories', 'units', 'materials'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,category_id',
            'unit_id'           => 'required|exists:units,unit_id',
            'material_id'       => 'required|exists:materials,material_id',
            'product_name'      => 'required|string|max:100',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'is_active'         => 'nullable|boolean',
            'allow_custom_size' => 'nullable|boolean',
            'default_width_cm'  => 'nullable|numeric|min:0',
            'default_height_cm' => 'nullable|numeric|min:0',
            'photos'            => 'nullable|array|max:5',
            'photos.*'          => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'primary_photo'     => 'nullable|integer|min:0',
            'delete_photos'     => 'nullable|array',
            'delete_photos.*'   => 'exists:product_images,image_id',
        ]);

        $product = Products::findOrFail($id);

        DB::beginTransaction();
        try {
            // ✅ Konversi dari METER ke CM sebelum disimpan
            $widthCm  = $request->filled('default_width_cm')
                ? (float) $request->default_width_cm * 100
                : $product->default_width_cm; // pertahankan nilai lama jika tidak diisi

            $heightCm = $request->filled('default_height_cm')
                ? (float) $request->default_height_cm * 100
                : $product->default_height_cm; // pertahankan nilai lama jika tidak diisi

            $product->update([
                'category_id'       => $request->category_id,
                'unit_id'           => $request->unit_id,
                'material_id'       => $request->material_id,
                'product_name'      => $request->product_name,
                'description'       => $request->description,
                'price'             => $request->price,
                'is_active'         => $request->boolean('is_active', true),
                'allow_custom_size' => $request->boolean('allow_custom_size', false),
                'default_width_cm'  => $widthCm,
                'default_height_cm' => $heightCm,
            ]);

            if ($request->filled('delete_photos')) {
                $toDelete = ProductImages::whereIn('image_id', $request->delete_photos)
                    ->where('product_id', $product->product_id)
                    ->get();

                foreach ($toDelete as $img) {
                    Storage::disk('public')->delete($img->photo);
                    $img->delete();
                }
            }

            if ($request->hasFile('photos')) {
                $primaryIndex = $request->input('primary_photo', 0);

                foreach ($request->file('photos') as $index => $photo) {
                    $path = $photo->store("products/{$product->product_id}", 'public');

                    ProductImages::create([
                        'product_id' => $product->product_id,
                        'photo'      => $path,
                        'is_primary' => ($index == $primaryIndex),
                    ]);
                }
            }

            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            if (!$hasPrimary) {
                $first = $product->images()->first();
                if ($first) $first->update(['is_primary' => true]);
            }

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Products $product)
    {
        DB::beginTransaction();
        try {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->photo);
            }

            $product->images()->delete();
            $product->delete();

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}   