<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Orders;
use App\Models\OrderItems;
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
$cart = Carts::with(['items.product', 'items.product.unit', 'items.product.images', 'items.product.category'])
    ->where('user_id', auth()->id())
    ->first();
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $cart = Carts::with(['items.product', 'items.product.unit'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // AMBIL DURASI TERLAMA
        $maxProductionDays = $cart->items->max(function ($item) {
            return $item->product->production_time ?? 1;
        });

        // HITUNG ANTREAN
        $pendingOrders = \App\Models\Orders::whereIn('status', ['pending', 'processing'])->count();
        if ($pendingOrders > 20) {
            $maxProductionDays += 1;
        }

        // --- PERBAIKAN DI SINI ---
        // 1. Tambahkan orderBy agar yang terbaru (ID terbesar) muncul di atas
        $shippings = Shippings::with(['province', 'city', 'district', 'village'])
            ->where('user_id', auth()->id())
            ->orderBy('shipping_id', 'desc') // Memastikan alamat baru di posisi paling atas
            ->get();

        $defaultShipping = $shippings->where('is_default', true)->first();
        $subtotal = $cart->items->sum('subtotal');
        $tax = $subtotal * 0.11;

        // Logika Member & Diskon
        $user = auth()->user();
$commissionEarned = 0;

if ($user->is_member) {
    $rate = $user->getCommissionRate();
    $commissionEarned = round($subtotal * ($rate / 100), 2);
}

$total = $subtotal + $tax; // ← tidak ada diskon, bayar penuh

        // Pastikan nama di compact adalah 'shippings'
        return view('checkout.index', compact(
            'cart',
            'shippings',
            'defaultShipping',
            'subtotal',
            'tax',
            'total',
            'maxProductionDays',
            'commissionEarned',
            'myProvinceId',
            'myCityId',
            'provinces'
        ));
    }
    public function store(Request $request)
    {
        $shippingMethod = $request->input('shipping_method');
        $request->validate([
            'shipping_method' => 'required|in:pickup,gojek,ekspedisi',
            'shipping_id' => $shippingMethod === 'pickup' ? 'nullable' : 'required|exists:shippings,shipping_id',
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();

            $cart = Carts::where('user_id', auth()->id())
                ->with(['items.product'])
                ->lockForUpdate()
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return response()->json([
                    'message' => 'Keranjang kosong atau sudah diproses.'
                ], 422);
            }

            $maxProductionDays = $cart->items->max(fn($item) => $item->product->production_time ?? 1);
            $prepDays = $maxProductionDays + (now()->hour >= 16 ? 1 : 0);

            // ── Logika Alamat & Ongkir ────────────────────────────────────────────
            $shippingCost = 0;
            $deliveryExtra = 0;
            $fullAddressText = "Ambil di Toko (Self Pickup)";

            if ($request->shipping_method !== 'pickup') {
                $address = Shippings::with(['city'])
                    ->where('shipping_id', $request->shipping_id)
                    ->first();

                if (!$address) {
                    return response()->json(['message' => 'Alamat pengiriman tidak ditemukan.'], 422);
                }

                $fullAddressText = $address->address . ", " . ($address->city->name ?? '');

                if (isset($address->city_id) && $address->city_id == $this->myCityId) {
                    $shippingCost = ($request->shipping_method === 'gojek') ? 15000 : 25000;
                    $deliveryExtra = 1;
                } else {
                    $shippingCost = 200000;
                    $deliveryExtra = 4;
                }
            }

            // ── Hitung Total ──────────────────────────────────────────────────────
            $subtotal = $cart->items->sum('subtotal');
            $tax = round($subtotal * 0.11);

            // ── Hitung Komisi & Diskon Member ─────────────────────────────────────
$commissionEarned = 0;

if ($user->is_member) {
    $rate = $user->getCommissionRate();
    $commissionEarned = round($subtotal * ($rate / 100), 2);
}


            $total = $subtotal  + $tax + $shippingCost;

            // ── Simpan Order ──────────────────────────────────────────────────────
            $order = Orders::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => $user->user_id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $request->shipping_method,
                'shipping_address' => $fullAddressText,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => 'midtrans',
                'estimated_arrival' => now()->addDays($prepDays + $deliveryExtra),
                'commission_earned' => $commissionEarned, // ← DITAMBAHKAN
            ]);

Notification::create([
    'user_id'  => null,            // null = notif admin global
    'type'     => 'order',
    'title'    => 'Pesanan Baru Masuk',
    'message'  => 'Pesanan #' . $order->order_number
                 . ' dari ' . $user->username
                 . ' menunggu pembayaran.',
'url' => '/ordersadmin',
    'is_read'  => false,
]);

Notification::create([
    'user_id'  => $user->user_id,  // ✅ hanya untuk user ini
    'type'     => 'order',
    'title'    => 'Pesanan Diterima',
    'message'  => 'Pesanan #' . $order->order_number . ' berhasil dibuat. Segera selesaikan pembayaran.',
    'url'      => '/orders/' . $order->order_number, // ✅ fix typo
    'is_read'  => false,
]);

            // ── Simpan Items ──────────────────────────────────────────────────────
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'unit_price' => $item->product->price ?? 0,
                    'subtotal' => $item->subtotal,
                    'notes' => $item->notes,
                    'width_cm' => $item->width_cm ?? null,
                    'height_cm' => $item->height_cm ?? null,
                ]);
            }

            // ── Midtrans Token ────────────────────────────────────────────────────
            try {
                $snapToken = $this->generateMidtransToken($order, $user);
                if (!$snapToken) {
                    throw new \Exception("Gagal mendapatkan token dari Midtrans.");
                }
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                \Log::error('Midtrans Error: ' . $e->getMessage());
                return response()->json(['message' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage()], 500);
            }

            // ── Hapus Keranjang ───────────────────────────────────────────────────
            $cart->items()->delete();
            $cart->delete();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_number' => $order->order_number,
            ]);
        });
    }

    // Pastikan fungsi ini ada di bawah store()
    private function generateMidtransToken($order, $user)
    {

        // Setting Midtrans (sesuaikan dengan config kamu)
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $user->username,
                'email' => $user->useremail,
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }




    public function success(Request $request)
    {
        $orderNumber = $request->query('order_id');
        if (!$orderNumber)
            return redirect()->route('orders.index');

        $order = Orders::where('order_number', $orderNumber)->first();
        if (!$order)
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');

        if ($order->status === 'pending') {

            // Fallback: hitung ulang commission_earned jika belum ada
            if ($order->commission_earned <= 0) {
                $order->load('user');
                if ($order->user && $order->user->is_member) {
                    $settings = \App\Models\Settings::first();
                    if ($settings) {
                        $rate = match ($order->user->member_tier) {
                            'premium' => (float) $settings->rate_premium,
                            'plus' => (float) $settings->rate_plus,
                            default => (float) $settings->rate_regular,
                        };
                        $order->update([
                            'commission_earned' => round((float) $order->subtotal * ($rate / 100), 2),
                        ]);
                    }
                }
            }

            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            $order->refresh();

            $order->prosesKomisi();
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

        if (!$order || $order->fresh()->stock_reduced)
            return;

        try {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $material = $item->product?->material;
                    if (!$material) {
                        \Log::warning("reduceStock: material NULL untuk product_id={$item->product_id}");
                        continue;
                    }

                    $qty = intval($item->qty);
                    if ($qty <= 0)
                        continue;

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

                    if ($used <= 0)
                        continue;

                    $oldStock = (float) $material->stock;
                    $newStock = max(0, $oldStock - $used);

                    DB::table('materials')
                        ->where('material_id', $material->material_id)
                        ->update(['stock' => $newStock, 'updated_at' => now()]);

                    DB::table('stock_logs')->insert([
                        'material_id' => $material->material_id,
                        'type' => 'out',
                        'amount' => $used,
                        'last_stock' => $newStock,
                        'description' => "Order #{$order->order_number} — {$desc}",
                        'created_at' => now(),
                        'updated_at' => now(),
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