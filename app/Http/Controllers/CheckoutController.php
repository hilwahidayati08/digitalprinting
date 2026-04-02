<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Log;
use App\Models\Shippings;
use App\Models\Settings;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
class CheckoutController extends Controller
{
    
private $myCityId = 3276; // ID Kota Toko (Contoh: Depok)
private $myProvinceId = 32; // ID Provinsi Toko (Contoh: Jawa Barat)
    public function index()
    {
                $provinces = Province::orderBy('name')->get(); 

        $myCityId = 3276;
        $myProvinceId = 32;
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $cart = Carts::with(['items.product', 'items.product.unit'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
// AMBIL DURASI TERLAMA DARI KERANJANG UNTUK JS
    $maxProductionDays = $cart->items->max(function($item) {
        return $item->product->production_time ?? 1;
    });

    // HITUNG ANTREAN SEKARANG
    $pendingOrders = \App\Models\Orders::whereIn('status', ['pending', 'processing'])->count();
    if ($pendingOrders > 20) {
        $maxProductionDays += 1;
    }
        $shippings = Shippings::with(['province', 'city', 'district', 'village'])
            ->where('user_id', auth()->id())
            ->get();

        $defaultShipping = $shippings->where('is_default', true)->first();
        $subtotal        = $cart->items->sum('subtotal');
        $tax             = $subtotal * 0.11;
        $total           = $subtotal + $tax;

        // === KOMISI: hitung preview diskon jika user adalah member ===
        $user             = auth()->user();
        $discountMember   = 0;
        $commissionEarned = 0;

        if ($user->is_member) {
            // ✅ Pakai active_commission_rate — otomatis ambil rate sesuai tier member
            $hasil            = Orders::hitungKomisi($subtotal, $user->active_commission_rate);
            $discountMember   = $hasil['discount'];
            $commissionEarned = $hasil['commission'];
            $total            = ($subtotal - $discountMember) + $tax;
        }

        return view('frontend.checkout.index', compact(
            'cart', 'shippings', 'defaultShipping',
            'subtotal', 'tax', 'total', 'maxProductionDays',
            'discountMember', 'commissionEarned', 'myProvinceId', 'myCityId', 'provinces'
        ));
    }

public function store(Request $request)
{
    // Validasi
    $request->validate([
        'shipping_method' => 'required',
        'shipping_id'     => 'required_unless:shipping_method,pickup',
    ]);

    return DB::transaction(function () use ($request) {
        $user = auth()->user();
        $cart = Carts::where('user_id', $user->user_id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong'], 422);
        }

        // Kalkulasi Total (Sederhana)
        $subtotal = $cart->items->sum('subtotal');
        $tax = round($subtotal * 0.11);
        $total = $subtotal + $tax;

        // Buat Order (Status PENDING)
        $order = Orders::create([
            'order_number'      => 'ORD-' . strtoupper(Str::random(10)),
            'user_id'           => $user->user_id,
            'subtotal'          => $subtotal,
            'tax'               => $tax,
            'total'             => $total,
            'status'            => 'pending',
            'status_detail'     => 'Menunggu Pembayaran',
            'shipping_method'   => $request->shipping_method,
            'shipping_address'  => $request->shipping_method == 'pickup' ? 'Ambil di Toko' : 'Alamat Pengiriman',
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'unit_price' => $item->unit_price,
                'subtotal'   => $item->subtotal,
            ]);
        }

        // Hapus Keranjang
        $cart->items()->delete();
        $cart->delete();

        return response()->json([
            'status'       => 'success',
            'redirect_url' => route('orders.index') 
        ]);
    });
}
    
    public function success(Request $request)
    {
        $orderNumber = $request->query('order_id');
        if (!$orderNumber) return redirect()->route('orders.index');

        $order = Orders::where('order_number', $orderNumber)->first();
        if (!$order) return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');

        if ($order->status === 'pending') {
            $order->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);
            $order->refresh();

            // Proses komisi masuk ke saldo member
            $order->prosesKomisi();

            // ✅ Update tier otomatis setelah order paid
            $order->user->updateTierOtomatis();
        }

        if (!$order->stock_reduced) {
            $this->reduceStock($order->order_id);
        }

        return redirect()->route('checkout.success')
            ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    private function reduceStock(int $order_id): void
    {
        $order = Orders::with(['items.product.material.unit'])->find($order_id);

        if (!$order || $order->fresh()->stock_reduced) return;

        try {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $material = $item->product?->material;
                    if (!$material) {
                        \Log::warning("reduceStock: material NULL untuk product_id={$item->product_id}");
                        continue;
                    }

                    $qty = intval($item->qty);
                    if ($qty <= 0) continue;

                    $unitName = strtoupper(optional($material->unit)->unit_name ?? '');

                    $w = floatval($item->width_cm ?? 0);
                    $h = floatval($item->height_cm ?? 0);

                    if (in_array($unitName, ['M²', 'M2', 'METER', 'METER PERSEGI'])) {
                        if ($w > 0 && $h > 0) {
                            $used = ($w / 100) * ($h / 100) * $qty;
                            $desc = "{$w}cm × {$h}cm × {$qty}pcs = " . round($used, 4) . " m²";
                        } else {
                            $used = $qty;
                            $desc = "Qty: {$qty} (dimensi tidak tersedia)";
                        }
                    } else {
                        $used = $qty;
                        $desc = "Qty: {$qty} {$unitName}";
                    }

                    if ($used <= 0) continue;

                    $oldStock = (float) $material->stock_qty;
                    $newStock = max(0, $oldStock - $used);

                    DB::table('materials')
                        ->where('material_id', $material->material_id)
                        ->update(['stock_qty' => $newStock, 'updated_at' => now()]);

                    DB::table('stock_logs')->insert([
                        'material_id' => $material->material_id,
                        'order_id'    => $order->order_id,
                        'type'        => 'out',
                        'amount'      => $used,
                        'last_stock'  => $newStock,
                        'description' => "Order #{$order->order_number} — {$desc}",
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    \Log::info("✅ Stok berkurang: {$material->material_name} | {$oldStock} → {$newStock} | {$desc}");
                }

                $order->update(['stock_reduced' => 1]);
            });

        } catch (\Exception $e) {
            \Log::error("❌ reduceStock GAGAL order_id={$order_id}: " . $e->getMessage() . " | Line: " . $e->getLine());
        }
    }
}