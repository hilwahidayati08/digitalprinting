<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\CartItems;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = Carts::with(['items.product.primaryImage', 'items.product.category', 'items.product.unit', 'items.product.material'])
            ->where('user_id', auth()->id())
            ->first();

        return view('carts.index', compact('cart'));
    }

public function add(Request $request)
{
    $request->validate([
        'product_id'      => 'required|exists:products,product_id',
        'qty'             => 'required|integer|min:1',
        'width_cm'        => 'nullable|numeric|min:0',
        'height_cm'       => 'nullable|numeric|min:0',
        'total_yield_pcs' => 'nullable|integer',
        'notes'           => 'nullable|string|max:1000',
    ]);

    DB::beginTransaction();

    try {

        $cart = Carts::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        // ← Tambah 'material' di eager load
        $product = Products::with(['category', 'material'])->findOrFail($request->product_id);

        $width    = (float) $request->width_cm;
        $height   = (float) $request->height_cm;
        $qty      = (int) $request->qty;
        $calcType = $product->category->calc_type;
        $material = $product->material;

        // ================================================
        // VALIDASI STOCK MATERIAL
        // ================================================
        if ($material) {
            if ($material->stock <= 0) {
                DB::rollBack();
                return back()->with('error', 'Stok material habis, produk tidak dapat dipesan.');
            }

            if ($calcType === 'stiker') {
                $matW    = (float) $material->width_cm;
                $matH    = (float) $material->height_cm;
                $spacing = ((float) ($material->spacing_mm ?? 0)) / 10;

                if ($matW > 0 && $matH > 0 && $width > 0 && $height > 0) {
                    if ($width <= $matW && $height <= $matH) {
                        // Hitung yield — cek orientasi normal vs rotasi
                        $cols1      = floor($matW / ($width  + $spacing));
                        $rows1      = floor($matH / ($height + $spacing));
                        $cols2      = floor($matW / ($height + $spacing));
                        $rows2      = floor($matH / ($width  + $spacing));
                        $yieldSheet = max($cols1 * $rows1, $cols2 * $rows2);
                        $maxQty     = $yieldSheet > 0 ? $material->stock * $yieldSheet : $material->stock;
                    } else {
                        // Ukuran melebihi material → 1 pcs = 1 lembar
                        $maxQty = $material->stock;
                    }
                } else {
                    $maxQty = $material->stock;
                }

                if ($qty > $maxQty) {
                    DB::rollBack();
                    return back()->with('error', "Jumlah melebihi stok tersedia. Maksimal {$maxQty} pcs.");
                }

            } else {
                // Untuk luas & satuan: qty tidak boleh melebihi stock lembar
                if ($qty > $material->stock) {
                    DB::rollBack();
                    return back()->with('error', "Jumlah melebihi stok tersedia. Tersedia {$material->stock} lembar.");
                }
            }
        }
        // ================================================

        $price    = $product->price;
        $subtotal = 0;

        if ($calcType === 'luas' && $width > 0 && $height > 0) {
            $luasM2      = ($width * $height) / 10000;
            $luasHitung  = max($luasM2, 1);
            $subtotal    = $luasHitung * $price * $qty;
        } else {
            $subtotal = $price * $qty;
        }

        $existingItem = CartItems::where('cart_id', $cart->cart_id)
            ->where('product_id', $product->product_id)
            ->where('width_cm', $width)
            ->where('height_cm', $height)
            ->first();

        if ($existingItem) {
            $newQty = $existingItem->qty + $qty;

            // Cek juga total setelah merge dengan existing cart
            if ($material && $calcType === 'stiker') {
                if (isset($maxQty) && $newQty > $maxQty) {
                    DB::rollBack();
                    return back()->with('error', "Total pesanan melebihi stok. Kamu sudah punya {$existingItem->qty} pcs di keranjang, maksimal {$maxQty} pcs.");
                }
            } elseif ($material && $newQty > $material->stock) {
                DB::rollBack();
                return back()->with('error', "Total pesanan melebihi stok. Kamu sudah punya {$existingItem->qty} di keranjang, tersedia {$material->stock} lembar.");
            }

            $existingItem->update([
                'qty'      => $newQty,
                'subtotal' => ($subtotal / $qty) * $newQty,
                'notes'    => $request->notes ?? $existingItem->notes,
            ]);

            $message = 'Jumlah pesanan diperbarui';

        } else {

            CartItems::create([
                'cart_id'         => $cart->cart_id,
                'product_id'      => $product->product_id,
                'width_cm'        => $width,
                'height_cm'       => $height,
                'qty'             => $qty,
                'price'           => $price,
                'total_yield_pcs' => $request->total_yield_pcs,
                'subtotal'        => $subtotal,
                'notes'           => $request->notes,
            ]);

            $message = 'Berhasil ditambahkan ke keranjang';
        }

        DB::commit();

        return redirect()->route('cart.index')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
public function buyNow(Request $request)
{
    $request->validate([
        'product_id'      => 'required|exists:products,product_id',
        'qty'             => 'required|integer|min:1',
        'width_cm'        => 'nullable|numeric|min:0',
        'height_cm'       => 'nullable|numeric|min:0',
        'total_yield_pcs' => 'nullable|integer',
        'notes'           => 'nullable|string|max:1000',
    ]);

    DB::beginTransaction();

    try {
        // Cari atau buat cart sementara (tapi nanti akan langsung di-checkout)
        $cart = Carts::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $product = Products::with(['category', 'material'])->findOrFail($request->product_id);

        $width    = (float) $request->width_cm;
        $height   = (float) $request->height_cm;
        $qty      = (int) $request->qty;
        $calcType = $product->category->calc_type;
        $material = $product->material;

        // Validasi stok (sama seperti di add())
        if ($material && $material->stock <= 0) {
            DB::rollBack();
            return back()->with('error', 'Stok material habis, produk tidak dapat dipesan.');
        }

        if ($material && $calcType === 'stiker') {
            $matW    = (float) $material->width_cm;
            $matH    = (float) $material->height_cm;
            $spacing = ((float) ($material->spacing_mm ?? 0)) / 10;

            if ($matW > 0 && $matH > 0 && $width > 0 && $height > 0) {
                if ($width <= $matW && $height <= $matH) {
                    $cols1      = floor($matW / ($width  + $spacing));
                    $rows1      = floor($matH / ($height + $spacing));
                    $cols2      = floor($matW / ($height + $spacing));
                    $rows2      = floor($matH / ($width  + $spacing));
                    $yieldSheet = max($cols1 * $rows1, $cols2 * $rows2);
                    $maxQty     = $yieldSheet > 0 ? $material->stock * $yieldSheet : $material->stock;
                } else {
                    $maxQty = $material->stock;
                }
            } else {
                $maxQty = $material->stock;
            }

            if ($qty > $maxQty) {
                DB::rollBack();
                return back()->with('error', "Jumlah melebihi stok tersedia. Maksimal {$maxQty} pcs.");
            }
        } elseif ($material && $qty > $material->stock) {
            DB::rollBack();
            return back()->with('error', "Jumlah melebihi stok tersedia. Tersedia {$material->stock} lembar.");
        }

        // Hitung subtotal
        $price    = $product->price;
        $subtotal = 0;

        if ($calcType === 'luas' && $width > 0 && $height > 0) {
            $luasM2      = ($width * $height) / 10000;
            $luasHitung  = max($luasM2, 1);
            $subtotal    = $luasHitung * $price * $qty;
        } else {
            $subtotal = $price * $qty;
        }

        // Hapus semua item di cart (biar cuma 1 item untuk buy now)
        CartItems::where('cart_id', $cart->cart_id)->delete();

        // Buat item baru
        CartItems::create([
            'cart_id'         => $cart->cart_id,
            'product_id'      => $product->product_id,
            'width_cm'        => $width,
            'height_cm'       => $height,
            'qty'             => $qty,
            'price'           => $price,
            'total_yield_pcs' => $request->total_yield_pcs,
            'subtotal'        => $subtotal,
            'notes'           => $request->notes,
        ]);

        DB::commit();

        // Langsung redirect ke halaman checkout
        return redirect()->route('checkout.index');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
public function update(Request $request, $id)
{
    $request->validate([
        'qty' => 'required|integer|min:1'
    ]);

    $item = CartItems::with(['cart', 'product.category'])->findOrFail($id);

    abort_if($item->cart->user_id !== auth()->id(), 403);

    $qty = (int) $request->qty;
    $price = $item->price;

    if ($item->product->category->calc_type === 'luas') {

        $luasM2 = ($item->width_cm * $item->height_cm) / 10000;

        $luasHitung = ($luasM2 < 1) ? 1 : $luasM2;

        $subtotal = $luasHitung * $price * $qty;

    } else {

        $subtotal = $price * $qty;

    }

    $item->update([
        'qty' => $qty,
        'subtotal' => $subtotal
    ]);

    return back()->with('success', 'Keranjang diperbarui');
}

    public function remove($id)
    {
        $item = CartItems::findOrFail($id);
        abort_if($item->cart->user_id !== auth()->id(), 403);
        $item->delete();
        return back()->with('success', 'Produk dihapus');
    }

    public function clear()
    {
        $cart = Carts::where('user_id', auth()->id())->first();
        if ($cart) {
            CartItems::where('cart_id', $cart->cart_id)->delete();
        }
        return back()->with('success', 'Keranjang dikosongkan');
    }
}