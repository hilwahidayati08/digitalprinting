<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\StockLogs;
use App\Models\Products;
use App\Models\Ratings;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shippings;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /* ======================================================
        ADMIN - REPORT SECTION
    ====================================================== */

    public function report(Request $request)
    {
        if (auth()->user()->role !== 'admin')
            abort(403);

        $dateFrom = $request->filled('date_from')
            ? \Carbon\Carbon::parse($request->date_from)->startOfDay()
            : \Carbon\Carbon::now()->startOfMonth();

        $dateTo = $request->filled('date_to')
            ? \Carbon\Carbon::parse($request->date_to)->endOfDay()
            : \Carbon\Carbon::now()->endOfDay();

        $status = $request->input('status', '');
        $search = $request->input('search', '');

        $query = Orders::with(['user', 'items.product.category', 'items.product.images', 'items.product.unit'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status !== '')
            $query->where('status', $status);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('username', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }

        $orders = $query->latest()->paginate(10)->appends($request->query());

        $summaryQuery = Orders::with('items')
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status !== '')
            $summaryQuery->where('status', $status);
        if ($search !== '') {
            $summaryQuery->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('username', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }

        $allOrders = $summaryQuery->get();

        $summary = [
            'total_orders'  => $allOrders->count(),
            'total_revenue' => $allOrders->whereIn('status', ['processing', 'shipped', 'completed'])->sum('total'),
            'total_items'   => $allOrders->flatMap->items->sum('qty'),
            'avg_order'     => $allOrders->count()
                ? $allOrders->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->avg('total')
                : 0,
        ];

        $statusBreakdown = $allOrders->groupBy('status')->map(fn($g) => [
            'count'   => $g->count(),
            'revenue' => $g->sum('total'),
        ]);

        $topProducts = OrderItems::with('product.category', 'product.images', 'product.unit')
            ->whereHas('order', function ($q) use ($dateFrom, $dateTo, $status, $search) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                if ($status !== '')
                    $q->where('status', $status);
                if ($search !== '') {
                    $q->where('order_number', 'like', "%$search%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('username', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        });
                }
            })
            ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('orders.report', compact(
            'orders',
            'summary',
            'statusBreakdown',
            'topProducts',
            'dateFrom',
            'dateTo',
            'status',
            'search'
        ));
    }

    public function reportPdf(Request $request)
    {
        if (auth()->user()->role !== 'admin')
            abort(403);

        $dateFrom = $request->filled('date_from')
            ? \Carbon\Carbon::parse($request->date_from)->startOfDay()
            : \Carbon\Carbon::now()->startOfMonth();
        $dateTo = $request->filled('date_to')
            ? \Carbon\Carbon::parse($request->date_to)->endOfDay()
            : \Carbon\Carbon::now()->endOfDay();
        $status = $request->input('status', '');
        $search = $request->input('search', '');

        $query = Orders::with([
            'user',
            'items.product.category',
            'items.product.material.unit',
            'items.finishing'
        ])->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status !== '')
            $query->where('status', $status);
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('username', 'like', "%$search%")
                            ->orWhere('useremail', 'like', "%$search%");
                    });
            });
        }

        $orders = $query->latest()->get();

        $summary = [
            'total_orders'  => $orders->count(),
            'total_revenue' => $orders->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->sum('total'),
            'total_items'   => $orders->flatMap->items->sum('qty'),
            'avg_order'     => $orders->count()
                ? $orders->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->avg('total')
                : 0,
        ];

        $settings = Settings::first();
        $pdf = Pdf::loadView('orders.report_pdf', compact('orders', 'summary', 'dateFrom', 'dateTo', 'status', 'settings', 'search'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Penjualan-' . $dateFrom->format('d-m-Y') . '.pdf');
    }

    /* ======================================================
        USER SECTION
    ====================================================== */

    public function index(Request $request)
    {
        $this->autoCancel();

        $query = Orders::where('user_id', Auth::id())
            ->with(['items.product.images'])
            ->latest();

        if ($request->filled('search'))
            $query->where('order_number', 'like', '%' . $request->search . '%');
        if ($request->filled('status'))
            $query->where('status', $request->status);
        if ($request->filled('date_from'))
            $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to'))
            $query->whereDate('created_at', '<=', $request->date_to);

        $orders = $query->paginate(5);

        $statusLabel = [
            'pending'      => 'Menunggu Pembayaran',
            'paid'         => 'Pembayaran Dikonfirmasi',
            'processing'   => 'Sedang Diproses',
            'ready_pickup' => 'Siap Diambil',
            'shipped'      => 'Dikirim',
            'completed'    => 'Selesai',
            'cancelled'    => 'Dibatalkan',
        ];

        $statusClass = [
            'pending'      => 'bg-amber-50 text-amber-700 border-amber-200',
            'paid'         => 'bg-blue-50 text-blue-700 border-blue-200',
            'processing'   => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'ready_pickup' => 'bg-teal-50 text-teal-700 border-teal-200',
            'shipped'      => 'bg-purple-50 text-purple-700 border-purple-200',
            'completed'    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'cancelled'    => 'bg-red-50 text-red-500 border-red-100',
        ];

        return view('orders.index', compact('orders', 'statusLabel', 'statusClass'));
    }

    private function autoCancel(): void
    {
        $expired = Orders::where('status', 'pending')
            ->where('payment_method', 'midtrans')
            ->where('created_at', '<', now()->subHours(24))
            ->get();

        foreach ($expired as $order) {
            $order->update([
                'status'     => 'cancelled',
                'snap_token' => null,
            ]);

            Notification::create([
                'user_id'  => $order->user_id,
                'type'     => 'order',
                'title'    => 'Pesanan Dibatalkan Otomatis',
                'message'  => 'Pesanan #' . $order->order_number
                             . ' dibatalkan karena tidak dibayar dalam 24 jam.',
                'url'      => '/orders',
                'is_read'  => false,
            ]);
        }
    }

    public function show($orderNumber)
    {
        $order = Orders::where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->with(['items.product.images'])
            ->firstOrFail();

        $expiredAt = $order->created_at->addHours(24);
        $sisaDetik = max(0, now()->diffInSeconds($expiredAt, false));
        $isExpired = $sisaDetik <= 0;

        $statusLabel = [
            'pending'      => 'Menunggu Pembayaran',
            'paid'         => 'Pembayaran Dikonfirmasi',
            'processing'   => 'Sedang Diproses',
            'ready_pickup' => 'Siap Diambil',
            'shipped'      => 'Dikirim',
            'completed'    => 'Selesai',
            'cancelled'    => 'Dibatalkan',
        ];

        $statusClass = [
            'pending'      => 'bg-amber-50 text-amber-700 border-amber-200',
            'paid'         => 'bg-blue-50 text-blue-700 border-blue-200',
            'processing'   => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'ready_pickup' => 'bg-teal-50 text-teal-700 border-teal-200',
            'shipped'      => 'bg-purple-50 text-purple-700 border-purple-200',
            'completed'    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'cancelled'    => 'bg-red-50 text-red-500 border-red-100',
        ];

        $metodeLbl = [
            'pickup'    => 'Ambil di Toko',
            'gojek'     => 'Gojek / Grab',
            'ekspedisi' => 'Ekspedisi',
        ];

        return view('orders.show', compact('order', 'sisaDetik', 'isExpired', 'statusLabel', 'statusClass', 'metodeLbl'));
    }

    /* ======================================================
        MIDTRANS SNAP TOKEN (AJAX)
    ====================================================== */

    public function getSnapToken($orderNumber)
    {
        try {
            $order = Orders::where('order_number', $orderNumber)->firstOrFail();

            \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');

            if (!\Midtrans\Config::$serverKey) {
                return response()->json(['status' => 'error', 'message' => 'Server Key kosong.'], 500);
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->order_number . '-' . time(),
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->user->full_name ?? $order->user->username,
                    'email'      => $order->user->useremail ?? 'customer@example.com',
                    'phone'      => $order->user->no_telp ?? '',
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            return response()->json(['status' => 'success', 'snap_token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /* ======================================================
        ADMIN - ORDER MANAGEMENT
    ====================================================== */

    public function adminIndex(Request $request)
    {
        $query = Orders::with(['user', 'items.product.category', 'items.product.unit']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('username', 'like', "%$search%")
                            ->orWhere('useremail', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled('status'))
            $query->where('status', $request->status);

        $orders = $query->latest()->paginate(5);
        return view('orders.admin_index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order     = Orders::with(['items', 'user'])->findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;

            if (!in_array($newStatus, $order->next_statuses) && auth()->user()->role !== 'admin') {
                return response()->json(['status' => 'error', 'message' => 'Transisi status tidak valid.'], 422);
            }

            $updateData = ['status' => $newStatus, 'status_detail' => $request->status_detail ?? null];

            // Set timestamp sesuai status
            match ($newStatus) {
                'paid'         => $updateData['paid_at']      = now(),
                'shipped'      => $updateData['shipped_at']   = now(),
                'completed'    => $updateData['completed_at'] = now(),
                'ready_pickup' => $updateData['ready_at']     = now(),
                default        => null,
            };

            // Tracking number saat shipped (ekspedisi)
            if ($newStatus === 'shipped' && $request->filled('tracking_number')) {
                $updateData['tracking_number'] = $request->tracking_number;
                $updateData['kurir_name']      = $request->kurir_name ?? null;
            }

            // Kurir name saat shipped (dari confirmStatusUpdate di index)
            if ($newStatus === 'shipped' && $request->filled('kurir_name')) {
                $updateData['kurir_name'] = $request->kurir_name;
            }

            $order->update($updateData);

            // Proses komisi + notifikasi + potong stok saat paid
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                $order->prosesKomisi();

                Notification::create([
                    'user_id'  => $order->user_id,
                    'type'     => 'payment',
                    'title'    => 'Pembayaran Berhasil',
                    'message'  => 'Pembayaran pesanan #' . $order->order_number
                                 . ' dikonfirmasi. Pesanan sedang diproses.',
                    'url'      => '/orders/' . $order->order_number,
                    'is_read'  => false,
                ]);

                $this->reduceStock($order->order_id);
            }

            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                Notification::create([
                    'user_id'  => null,
                    'type'     => 'order',
                    'title'    => 'Pesanan Selesai',
                    'message'  => 'Order #' . $order->order_number . ' telah diselesaikan.',
                    'url'      => '/ordersadmin',
                    'is_read'  => false,
                ]);

                Notification::create([
                    'user_id'  => $order->user_id,
                    'type'     => 'order',
                    'title'    => 'Pesanan Selesai',
                    'message'  => 'Pesanan #' . $order->order_number
                                 . ' telah selesai. Yuk kasih ulasan produknya!',
                    'url'      => '/orders/' . $order->order_number,
                    'is_read'  => false,
                ]);
            }

            if ($newStatus === 'ready_pickup') {
                Notification::create([
                    'user_id'  => null,
                    'type'     => 'order',
                    'title'    => 'Pesanan Siap Diambil',
                    'message'  => 'Pesanan #' . $order->order_number . ' selesai diproduksi.',
                    'url'      => '/ordersadmin/' . $order->order_number,
                    'is_read'  => false,
                ]);

                Notification::create([
                    'user_id'  => $order->user_id,
                    'type'     => 'order',
                    'title'    => 'Pesanan Siap Diambil',
                    'message'  => 'Pesanan #' . $order->order_number
                                 . ' siap diambil di toko. Bawa bukti pesanan ya!',
                    'url'      => '/orders/' . $order->order_number,
                    'is_read'  => false,
                ]);
            }

            if ($newStatus === 'shipped' && $oldStatus !== 'shipped') {
                $resiMsg = $order->tracking_number
                    ? ' No. resi: ' . $order->tracking_number
                      . ($order->kurir_name ? ' (' . $order->kurir_name . ')' : '')
                    : '';

                Notification::create([
                    'user_id'  => $order->user_id,
                    'type'     => 'order',
                    'title'    => 'Pesanan Sedang Dikirim',
                    'message'  => 'Pesanan #' . $order->order_number
                                 . ' sudah dikirim.' . $resiMsg,
                    'url'      => '/orders/' . $order->order_number,
                    'is_read'  => false,
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Status diperbarui ke ' . strtoupper($newStatus),
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function confirmCash(Request $request, $id)
    {
        try {
            $order = Orders::findOrFail($id);

            if ($order->status !== 'pending') {
                return response()->json(['status' => 'error', 'message' => 'Order bukan pending.'], 422);
            }

            $amountReceived = (float) ($request->cash_amount_received ?? $order->total);
            $change         = max(0, $amountReceived - $order->total);

            $order->update([
                'status'               => 'processing',
                'paid_at'              => now(),
                'payment_method'       => 'cash',
                'cash_amount_received' => $amountReceived,
                'cash_change'          => $change,
                'status_detail'        => 'Dibayar tunai, dikonfirmasi admin',
            ]);

            $order->prosesKomisi();

            return response()->json([
                'status'  => 'success',
                'message' => 'Pembayaran tunai dikonfirmasi.',
                'change'  => $change,
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /* ======================================================
        LOGIC: STOCK REDUCTION
    ====================================================== */

    private function reduceStock($order_id)
    {
        Log::info("🔍 reduceStock dipanggil untuk order_id={$order_id}");

        $order = Orders::with([
            'items.product.category',
            'items.product.material'
        ])->find($order_id);

        if (!$order) {
            Log::warning("reduceStock: order_id={$order_id} tidak ditemukan.");
            return;
        }

        if ($order->stock_reduced) {
            Log::info("reduceStock: order_id={$order_id} sudah diproses, skip.");
            return;
        }

        try {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $material = $item->product?->material;
                    $calcType = $item->product?->category?->calc_type ?? 'satuan';

                    if (!$material) {
                        Log::warning("reduceStock: material NULL untuk product_id={$item->product_id}");
                        continue;
                    }

                    $qty  = (int) $item->qty;
                    $used = 0;

                    if ($calcType === 'luas') {
                        $w    = (float) ($item->width_cm ?? 100) / 100;
                        $h    = (float) ($item->height_cm ?? 100) / 100;
                        $used = $w * $h * $qty;

                    } elseif ($calcType === 'stiker') {
                        $matW    = (float) $material->width_cm;
                        $matH    = (float) $material->height_cm;
                        $spacing = (float) ($material->spacing_mm ?? 0) / 10;
                        $stickerW = (float) ($item->width_cm ?? 0);
                        $stickerH = (float) ($item->height_cm ?? 0);

                        if ($matW > 0 && $matH > 0 && $stickerW > 0 && $stickerH > 0) {
                            $fw     = $stickerW + $spacing;
                            $fh     = $stickerH + $spacing;
                            $yield1 = floor($matW / $fw) * floor($matH / $fh);
                            $yield2 = floor($matW / $fh) * floor($matH / $fw);
                            $yield  = max($yield1, $yield2, 1);
                        } else {
                            $yield = 1;
                        }

                        $used = ceil($qty / $yield);

                    } else {
                        $used = $qty;
                    }

                    if ($used <= 0) continue;

                    $currentStock = (float) DB::table('materials')
                        ->where('material_id', $material->material_id)
                        ->value('stock');

                    $newStock = max(0, $currentStock - $used);

                    DB::table('materials')
                        ->where('material_id', $material->material_id)
                        ->update(['stock' => $newStock, 'updated_at' => now()]);

                    StockLogs::create([
                        'material_id' => $material->material_id,
                        'type'        => 'out',
                        'amount'      => round($used, 4),
                        'last_stock'  => $newStock,
                        'description' => "Order #{$order->order_number} — {$calcType} — qty:{$qty}",
                    ]);

                    Log::info("✅ Stok berkurang: {$material->material_name} | {$currentStock} → {$newStock} | used={$used}");

                    if ($newStock <= (float) $material->min_stock) {
                        $title = $newStock == 0 ? 'Stok Habis!' : 'Stok Material Menipis';
                        $msg   = $newStock == 0
                            ? "Material {$material->material_name} habis! Segera restock."
                            : "Material {$material->material_name} tersisa {$newStock} (Min: {$material->min_stock}). Segera restock!";

                        Notification::create([
                            'user_id'  => null,
                            'type'     => 'stock',
                            'title'    => $title,
                            'message'  => $msg,
                            'url'      => route('materials.index'),
                            'is_read'  => false,
                        ]);
                    }
                }

                $order->update(['stock_reduced' => 1]);
            });

        } catch (\Exception $e) {
            Log::error("❌ reduceStock GAGAL order_id={$order->order_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /* ======================================================
        ADMIN - CREATE ORDER MANUAL
    ====================================================== */

    public function create()
    {
        $users = User::whereIn('role', ['user', 'guest'])->orderBy('full_name')->get();
        $products = Products::with(['material', 'category'])->where('is_active', true)->get();
        $provinces = Province::orderBy('name')->get();

        $myCityId     = 3276;
        $myProvinceId = 32;

        $allShippings = Shippings::with(['village', 'district', 'city'])
            ->get()
            ->map(function ($s) {
                $s->user_id = (int) $s->user_id;
                return $s;
            });

        $maxProductionDays = 3;
        $cutOffHour        = 16;

        return view('orders.create', compact(
            'users',
            'products',
            'allShippings',
            'provinces',
            'myCityId',
            'myProvinceId',
            'maxProductionDays',
            'cutOffHour'
        ));
    }

    public function store(Request $request)
    {
        Log::info('Order store request:', $request->all());

        try {
            $request->validate([
                'shipping_method'       => 'required|in:pickup,gojek,ekspedisi',
                'payment_method'        => 'required|in:cash,midtrans',
                'products'              => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,product_id',
                'products.*.qty'        => 'required|integer|min:1',
                'subtotal'              => 'required|numeric|min:0',
                'tax'                   => 'required|numeric|min:0',
                'shipping_cost'         => 'required|numeric|min:0',
                'total'                 => 'required|numeric|min:0',
                'shipping_id'           => ($request->shipping_method !== 'pickup' && !$request->filled('guest_name') && !$request->filled('new_customer_name'))
                    ? 'required|exists:shippings,shipping_id'
                    : 'nullable',
                'cash_amount_received'  => $request->payment_method === 'cash'
                    ? 'nullable|numeric|min:0'
                    : 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }

        return DB::transaction(function () use ($request) {

            // ── 1. Resolve User ───────────────────────────────────────────────────
            if ($request->filled('new_customer_name')) {
                if (empty($request->new_customer_phone))
                    throw new \Exception('Nomor WhatsApp member baru wajib diisi.');

                $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->new_customer_name));
                $username     = $baseUsername . '_' . time();
                $counter      = 1;
                while (User::where('username', $username)->exists())
                    $username = $baseUsername . '_' . time() . '_' . $counter++;

                $user = User::create([
                    'full_name'   => $request->new_customer_name,
                    'useremail'   => $request->new_customer_email ?? null,
                    'no_telp'     => $request->new_customer_phone,
                    'username'    => $username,
                    'password'    => bcrypt('customer123'),
                    'role'        => 'user',
                    'is_member'   => true,
                    'member_tier' => 'regular',
                ]);

                if ($request->shipping_method !== 'pickup' && $request->filled('new_address')) {
                    Shippings::create([
                        'user_id'         => $user->user_id,
                        'recipient_name'  => $request->new_recipient_name ?? $request->new_customer_name,
                        'recipient_phone' => $request->new_recipient_phone ?? $request->new_customer_phone,
                        'address'         => $request->new_address,
                        'province_id'     => $request->new_province_id,
                        'city_id'         => $request->new_city_id,
                        'district_id'     => $request->new_district_id,
                        'village_id'      => $request->new_village_id,
                        'postal_code'     => $request->new_postal_code ?? '',
                        'label'           => 'Rumah',
                        'is_default'      => true,
                    ]);
                }

            } elseif ($request->filled('guest_name')) {
                if (empty($request->guest_phone))
                    throw new \Exception('Nomor HP pelanggan umum wajib diisi.');

                $baseUsername = 'guest_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->guest_name));
                $username     = $baseUsername . '_' . time();
                $counter      = 1;
                while (User::where('username', $username)->exists())
                    $username = $baseUsername . '_' . time() . '_' . $counter++;

                $user = User::create([
                    'full_name' => $request->guest_name,
                    'useremail' => $request->guest_email ?? null,
                    'no_telp'   => $request->guest_phone,
                    'username'  => $username,
                    'password'  => bcrypt(Str::random(16)),
                    'role'      => 'guest',
                ]);

                if ($request->shipping_method !== 'pickup' && $request->filled('guest_address')) {
                    Shippings::create([
                        'user_id'         => $user->user_id,
                        'recipient_name'  => $request->guest_recipient_name ?? $request->guest_name,
                        'recipient_phone' => $request->guest_recipient_phone ?? $request->guest_phone,
                        'address'         => $request->guest_address,
                        'province_id'     => $request->guest_province_id,
                        'city_id'         => $request->guest_city_id,
                        'district_id'     => $request->guest_district_id ?? null,
                        'village_id'      => $request->guest_village_id ?? null,
                        'postal_code'     => $request->guest_postal_code ?? '',
                        'label'           => 'Pengiriman',
                        'is_default'      => true,
                    ]);
                }

            } elseif ($request->filled('user_id')) {
                $user = User::find($request->user_id);
                if (!$user) throw new \Exception('User tidak ditemukan.');
            } else {
                throw new \Exception('Pilih user atau daftarkan member baru.');
            }

            if (!$user || !$user->user_id)
                throw new \Exception('User tidak valid.');

            // ── 2. Resolve Alamat ─────────────────────────────────────────────────
            $fullAddressText = 'Ambil di Toko';

            if ($request->shipping_method !== 'pickup') {
                if ($request->filled('shipping_id')) {
                    $address = Shippings::with(['village', 'district', 'city'])->find($request->shipping_id);
                    if ($address) {
                        $fullAddressText = implode(', ', array_filter([
                            $address->address,
                            $address->village->name ?? null,
                            $address->district->name ?? null,
                            $address->city->name ?? null,
                        ]));
                    }
                } elseif ($request->filled('guest_address')) {
                    $fullAddressText = $request->guest_address;
                } elseif ($request->filled('new_address')) {
                    $fullAddressText = $request->new_address;
                }
            }

            // ── 3. Estimasi tiba ──────────────────────────────────────────────────
            $productionDays = match ($request->shipping_method) {
                'pickup'    => 2,
                'gojek'     => 3,
                'ekspedisi' => 5,
                default     => 3,
            };

            // ── 4. Status awal ────────────────────────────────────────────────────
            // cash  → langsung 'processing' (sudah bayar di tempat)
            // midtrans → 'pending' (menunggu pembayaran via Midtrans)
            $initialStatus = $request->payment_method === 'cash' ? 'processing' : 'pending';

            // ── 4.5 Hitung commission_earned ──────────────────────────────────────
            $commissionEarned = 0;
            if ($user->is_member) {
                $settings = \App\Models\Settings::first();
                if ($settings) {
                    $commissionEarned = round((float) $request->subtotal * ($user->getCommissionRate() / 100), 2);
                }
            }

            // ── 4.6 Hitung kembalian jika cash ────────────────────────────────────
            $cashReceived = null;
            $cashChange   = null;
            if ($request->payment_method === 'cash') {
                if (!$request->filled('cash_amount_received') || (float) $request->cash_amount_received <= 0)
                    throw new \Exception('Nominal uang yang diterima wajib diisi untuk pembayaran tunai.');

                $cashReceived = (float) $request->cash_amount_received;
                if ($cashReceived < (float) $request->total)
                    throw new \Exception('Nominal yang diterima kurang dari total pembayaran.');

                $cashChange = $cashReceived - (float) $request->total;
            }

            // ── 5. Simpan Order ───────────────────────────────────────────────────
            $order = Orders::create([
                'order_number'         => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id'              => $user->user_id,
                'subtotal'             => (float) $request->subtotal,
                'tax'                  => (float) $request->tax,
                'shipping_cost'        => (float) $request->shipping_cost,
                'total'                => (float) $request->total,
                'shipping_method'      => $request->shipping_method,
                'shipping_address'     => $fullAddressText,
                'payment_method'       => $request->payment_method,
                'status'               => $initialStatus,
                'status_detail'        => $request->payment_method === 'cash'
                                            ? 'Pesanan dibuat oleh Admin (Tunai)'
                                            : 'Menunggu pembayaran Midtrans',
                'estimated_arrival'    => now()->addDays($productionDays),
                'created_by'           => auth()->id(),
                'paid_at'              => $request->payment_method === 'cash' ? now() : null,
                'cash_amount_received' => $cashReceived,
                'cash_change'          => $cashChange,
                'commission_earned'    => $commissionEarned,
            ]);

            // ── 6. Simpan Item ────────────────────────────────────────────────────
            foreach ($request->products as $index => $item) {
                $product = Products::find($item['product_id']);
                if (!$product) continue;

                $price = (float) $product->price;

                if ($product->allow_custom_size && !empty($item['width_cm']) && !empty($item['height_cm'])) {
                    $defaultArea = (float) ($product->default_width_cm ?? 1) * (float) ($product->default_height_cm ?? 1);
                    $customArea  = (float) $item['width_cm'] * (float) $item['height_cm'];
                    if ($defaultArea > 0)
                        $price = ($product->price / $defaultArea) * $customArea;
                }

                $qty = (int) $item['qty'];

                $designFilePath = null;
                $fileKey        = "products.{$index}.design_file";
                if ($request->hasFile($fileKey))
                    $designFilePath = $request->file($fileKey)->store('designs/' . date('Y-m'), 'public');

                $order->items()->create([
                    'product_id'  => $item['product_id'],
                    'qty'         => $qty,
                    'unit_price'  => round($price, 2),
                    'subtotal'    => round($price * $qty, 2),
                    'notes'       => $item['notes'] ?? null,
                    'width_cm'    => $item['width_cm'] ?? $product->default_width_cm ?? null,
                    'height_cm'   => $item['height_cm'] ?? $product->default_height_cm ?? null,
                    'design_file' => $designFilePath,
                ]);
            }

            // ── 7. Proses komisi + potong stok jika cash ──────────────────────────
            if ($request->payment_method === 'cash') {
                $order->load('user');
                $order->prosesKomisi();
                $this->reduceStock($order->order_id);
            }

            // ── 8. Generate Midtrans Snap Token ───────────────────────────────────
            $snapToken = null;
            if ($request->payment_method === 'midtrans') {
                try {
                    if (class_exists('\Midtrans\Config')) {
                        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
                        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction', false);
                        \Midtrans\Config::$isSanitized  = true;
                        \Midtrans\Config::$is3ds        = true;

                        $snapToken = \Midtrans\Snap::getSnapToken([
                            'transaction_details' => [
                                'order_id'     => $order->order_number,
                                'gross_amount' => (int) round($order->total),
                            ],
                            'customer_details' => [
                                'first_name' => $user->full_name ?? $user->username,
                                'email'      => $user->useremail ?? '',
                                'phone'      => $user->no_telp ?? '',
                            ],
                            'item_details' => $this->getItemDetails($order),
                        ]);

                        $order->update(['snap_token' => $snapToken]);
                    }
                } catch (\Exception $e) {
                    Log::error('Midtrans Error: ' . $e->getMessage());
                    // Tetap lanjut, order sudah tersimpan dengan status pending
                }
            }

            return response()->json([
                'status'     => 'success',
                'message'    => 'Pesanan berhasil dibuat.',
                'order_id'   => $order->order_id,
                'snap_token' => $snapToken,
            ]);
        });
    }

    /* ======================================================
        OTHERS
    ====================================================== */

    public function downloadInvoice($order_number)
    {
        $order = Orders::where('order_number', $order_number)->firstOrFail();
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin')
            abort(403);
        return Pdf::loadView('orders.invoice', compact('order'))
            ->download('Invoice-' . $order->order_number . '.pdf');
    }

    public function downloadResi($order_number)
    {
        $order    = Orders::with(['items.product.unit', 'user', 'shipping.province', 'shipping.city'])
            ->where('order_number', $order_number)->firstOrFail();
        $settings = Settings::first();
        return Pdf::loadView('orders.resi', compact('order', 'settings'))
            ->setPaper([0, 0, 283.46, 425.20])
            ->download('Resi-' . $order_number . '.pdf');
    }

    public function uploadDesign(Request $request, $order_item_id)
    {
        $item = OrderItems::findOrFail($order_item_id);
        $request->validate(['design_file' => 'required|file|max:51200']);
        if ($request->hasFile('design_file')) {
            $path = $request->file('design_file')->store('designs/' . date('Y-m'), 'public');
            $item->update(['design_file' => $path]);
        }
        return back()->with('success', 'Desain diupload!');
    }

    public function storeRating(Request $request)
    {
        $request->validate([
            'order_id'      => 'required|exists:orders,order_id',
            'order_item_id' => 'required|exists:order_items,order_item_id',
            'product_id'    => 'required|exists:products,product_id',
            'rating'        => 'required|integer|min:1|max:5',
            'review'        => 'nullable|string|max:1000'
        ]);

        $existing = Ratings::where('user_id', Auth::id())
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($existing) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda sudah memberikan rating untuk produk ini di pesanan ini'
            ], 400);
        }

        $order = Orders::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->first();

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan belum selesai atau tidak ditemukan'
            ], 404);
        }

        $orderItem = OrderItems::where('order_item_id', $request->order_item_id)
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$orderItem) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan dalam pesanan'
            ], 404);
        }

        $rating = Ratings::create([
            'user_id'    => Auth::id(),
            'order_id'   => $request->order_id,
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
            'review'     => $request->review
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Terima kasih atas rating dan ulasannya!',
                'data'    => $rating
            ]);
        }

        return back()->with('success', 'Rating tersimpan!');
    }

    public function cancel($id)
    {
        $order = Orders::where('order_id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled', 'snap_token' => null]);

            Notification::create([
                'type'    => 'order',
                'title'   => '❌ Pesanan Dibatalkan',
                'message' => 'Pelanggan ' . auth()->user()->username . ' membatalkan pesanan #' . $order->order_number,
                'url'     => '/ordersadmin',
                'is_read' => 0,
            ]);

            Notification::create([
                'user_id'  => $order->user_id,
                'type'     => 'order',
                'title'    => 'Pesanan Dibatalkan',
                'message'  => 'Pesanan #' . $order->order_number . ' berhasil dibatalkan.',
                'url'      => '/orders',
                'is_read'  => false,
            ]);

            return back()->with('success', 'Pesanan dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    public function updateNotes(Request $request, $id)
    {
        $order = Orders::where('order_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($order->status, ['pending', 'paid'])) {
            return redirect()->route('orders.index')->with('error', 'Catatan sudah terkunci.');
        }

        $request->validate(['notes' => 'required|string|max:500']);
        $order->items()->update(['notes' => $request->notes]);

        return redirect()->route('orders.index')->with('success', 'Catatan berhasil disimpan!');
    }

    public function getUserAddresses($userId)
    {
        $addresses = Shippings::where('user_id', $userId)->get();
        return response()->json($addresses);
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        $users  = User::where('role', 'user')
            ->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    public function searchProducts(Request $request)
    {
        $search   = $request->get('q');
        $products = Products::where('product_name', 'like', "%{$search}%")->limit(20)->get();
        return response()->json($products);
    }

    /* ======================================================
        PRIVATE HELPERS
    ====================================================== */

    private function getItemDetails($order)
    {
        $items = [];
        foreach ($order->items as $item) {
            $name = $item->product->product_name ?? 'Product';
            if ($item->width_cm && $item->height_cm)
                $name .= " ({$item->width_cm}x{$item->height_cm} cm)";

            $items[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) round($item->unit_price),
                'quantity' => (int) $item->qty,
                'name'     => substr($name, 0, 50),
            ];
        }

        if ($order->shipping_cost > 0) {
            $items[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) round($order->shipping_cost),
                'quantity' => 1,
                'name'     => 'Ongkir (' . strtoupper($order->shipping_method) . ')',
            ];
        }

        return $items;
    }

    /* ======================================================
        MIDTRANS WEBHOOK / NOTIFICATION
    ====================================================== */

    public function handleNotification(Request $request)
    {
        Log::info('🔔 Midtrans notification masuk:', $request->all());

        try {
            \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $notif       = new \Midtrans\Notification();
            $transaction = $notif->transaction_status;
            $fraud       = $notif->fraud_status;
            $orderId     = $notif->order_id;

            $orderNumber = preg_replace('/-\d{10}$/', '', $orderId);

            Log::info("Midtrans: order_number={$orderNumber}, transaction={$transaction}, fraud={$fraud}");

            $order = Orders::where('order_number', $orderNumber)->first();

            if (!$order) {
                Log::warning("Midtrans: order tidak ditemukan untuk={$orderNumber}");
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Skip jika sudah melewati tahap paid
            if (in_array($order->status, ['paid', 'processing', 'shipped', 'completed'])) {
                Log::info("Midtrans: sudah diproses, skip. status={$order->status}");
                return response()->json(['message' => 'Already processed'], 200);
            }

            if ($transaction === 'capture' || $transaction === 'settlement') {
                if ($fraud === 'challenge') {
                    $order->update([
                        'status'        => 'pending',
                        'status_detail' => 'Flagged by Midtrans, menunggu review',
                    ]);
                } else {
                    if ($order->commission_earned <= 0) {
                        $order->load('user');
                        if ($order->user && $order->user->is_member) {
                            $rate = $order->user->getCommissionRate();
                            $order->update([
                                'commission_earned' => round((float) $order->subtotal * ($rate / 100), 2),
                            ]);
                        }
                    }

                    // Webhook Midtrans → set paid dulu, admin konfirmasi → processing
                    $order->update([
                        'status'        => 'paid',
                        'paid_at'       => now(),
                        'status_detail' => 'Dibayar via Midtrans (' . $transaction . ')',
                    ]);

                    $order->prosesKomisi();

                    Notification::create([
                        'user_id'  => $order->user_id,
                        'type'     => 'payment',
                        'title'    => 'Pembayaran Berhasil',
                        'message'  => 'Pembayaran #' . $order->order_number
                                     . ' via Midtrans berhasil. Pesanan sedang dikonfirmasi.',
                        'url'      => '/orders/' . $order->order_number,
                        'is_read'  => false,
                    ]);

                    // Notif admin ada pembayaran masuk
                    Notification::create([
                        'user_id'  => null,
                        'type'     => 'payment',
                        'title'    => 'Pembayaran Midtrans Masuk',
                        'message'  => 'Order #' . $order->order_number . ' telah dibayar via Midtrans. Konfirmasi untuk mulai produksi.',
                        'url'      => '/ordersadmin',
                        'is_read'  => false,
                    ]);

                    $this->reduceStock($order->order_id);

                    Log::info("✅ Midtrans: order {$orderNumber} → paid");
                }

            } elseif ($transaction === 'pending') {
                $order->update([
                    'status'        => 'pending',
                    'status_detail' => 'Menunggu pembayaran Midtrans',
                ]);

            } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'status'        => 'cancelled',
                    'snap_token'    => null,
                    'status_detail' => 'Dibatalkan via Midtrans (' . $transaction . ')',
                ]);

                Notification::create([
                    'user_id'  => $order->user_id,
                    'type'     => 'payment',
                    'title'    => 'Pembayaran Gagal',
                    'message'  => 'Pembayaran pesanan #' . $order->order_number
                                 . ' gagal (' . $transaction . "). Pesanan dibatalkan.",
                    'url'      => '/orders',
                    'is_read'  => false,
                ]);

                Log::info("❌ Midtrans: order {$orderNumber} → {$transaction}");
            }

            return response()->json(['message' => 'OK'], 200);

        } catch (\Exception $e) {
            Log::error('❌ Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}