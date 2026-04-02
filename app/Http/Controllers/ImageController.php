<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // halaman upload
    public function create($id)
    {
        $product = Products::with('images')->findOrFail($id);
        return view('admin.products.images',compact('product'));
    }

    // simpan images
public function store(Request $request)
{
    $request->validate([
        'category_id'   => 'required|exists:categories,category_id',
        'unit_id'       => 'required|exists:units,unit_id',
        'product_name'  => 'required|string|max:255',
        'price'         => 'required|numeric|min:0',
        'photos'        => 'required|array|min:1', // Minimal harus upload 1 foto
        'photos.*'      => 'image|mimes:jpg,jpeg,png,webp|max:2048', 
    ]);

    try {
        DB::beginTransaction();

        // 1. Simpan Data Produk Utama
        $product = Products::create([
            'category_id'  => $request->category_id,
            'unit_id'      => $request->unit_id,
            'product_name' => $request->product_name,
            'slug'         => Str::slug($request->product_name),
            'price'        => $request->price,
            'description'  => $request->description,
            'is_active'    => $request->has('is_active'),
        ]);

        // 2. Simpan Banyak Foto ke Folder & Tabel Terpisah
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                // Penamaan file: timestamp-namaproduk-urutan.ekstensi
                $filename = time() . '-' . Str::slug($request->product_name) . '-' . $index . '.' . $file->getClientOriginalExtension();
                
                // Simpan fisik file ke storage/app/public/images/products
                $file->storeAs('images/products', $filename, 'public');

                // Simpan record ke tabel product_images
                ProductImages::create([
                    'product_id' => $product->product_id,
                    'photo'      => 'images/products/' . $filename, // Path yang akan dipanggil di view
                    'is_primary' => $index === 0, // Foto pertama otomatis jadi foto utama
                ]);
            }
        }

        DB::commit();
        return redirect()->route('products.index')->with('success', 'Produk dan foto berhasil disimpan!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    // delete image
    public function destroy($id)
    {
        $image = ProductImages::findOrFail($id);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success','Image deleted');
    }
}
