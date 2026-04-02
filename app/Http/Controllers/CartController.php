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
    // Tambahkan 'product.productImages' (sesuaikan nama relasi di model Product)
$cart = Carts::with(['items.product.primaryImage', 'items.product.category', 'items.product.unit'])
    ->where('user_id', auth()->id())
    ->first();

    return view('frontend.carts.index', compact('cart'));
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

        $product = Products::with(['category'])->findOrFail($request->product_id);

        $width = (float) $request->width_cm;
        $height = (float) $request->height_cm;
        $qty = (int) $request->qty;

        $price = $product->price;
        $subtotal = 0;

        $calcType = $product->category->calc_type;

        if ($calcType === 'luas' && $width > 0 && $height > 0) {

            $luasM2 = ($width * $height) / 10000;

            $luasHitung = max($luasM2, 1);

            $subtotal = $luasHitung * $price * $qty;

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

            $existingItem->update([
                'qty' => $newQty,
                'subtotal' => ($subtotal / $qty) * $newQty,
                'notes' => $request->notes ?? $existingItem->notes,
            ]);

            $message = 'Jumlah pesanan diperbarui';

        } else {

            CartItems::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $product->product_id,
                'width_cm' => $width,
                'height_cm' => $height,
                'qty' => $qty,
                'price' => $price,
                'total_yield_pcs' => $request->total_yield_pcs,
                'subtotal' => $subtotal,
                'notes' => $request->notes,
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