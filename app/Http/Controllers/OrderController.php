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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Penting: Untuk memperbaiki error "Class Log not found"

class OrderController extends Controller
{
    /* ======================================================
        ADMIN - REPORT SECTION
    ====================================================== */

    public function report(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $dateFrom = $request->filled('date_from')
            ? \Carbon\Carbon::parse($request->date_from)->startOfDay()
            : \Carbon\Carbon::now()->startOfMonth();

        $dateTo = $request->filled('date_to')
            ? \Carbon\Carbon::parse($request->date_to)->endOfDay()
            : \Carbon\Carbon::now()->endOfDay();

        $status = $request->input('status', '');
        $search = $request->input('search', '');

        $query = Orders::with(['user', 'items.product.category'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status !== '') {
            $query->where('status', $status);
        }

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
            'total_orders'   => $orders->count(),
            'total_revenue'  => $orders->whereIn('status', ['delivered', 'processing', 'shipped'])->sum('total_price'),
            'total_items'    => $orders->flatMap->items->sum('qty'),
            'avg_order'      => $orders->count()
                ? $orders->whereIn('status', ['delivered', 'processing', 'shipped'])->avg('total_price')
                : 0,
        ];

        $statusBreakdown = $orders->groupBy('status')->map(fn($g) => [
            'count'   => $g->count(),
            'revenue' => $g->sum('total_price'),
        ]);

        $topProducts = OrderItems::with('product')
            ->whereHas('order', function ($q) use ($dateFrom, $dateTo, $status) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                if ($status !== '') $q->where('status', $status);
            })
            ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('frontend.orders.report', compact(
            'orders', 'summary', 'statusBreakdown', 'topProducts',
            'dateFrom', 'dateTo', 'status', 'search'
        ));
    }

    public function reportPdf(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $dateFrom = $request->filled('date_from') ? \Carbon\Carbon::parse($request->date_from)->startOfDay() : \Carbon\Carbon::now()->startOfMonth();
        $dateTo = $request->filled('date_to') ? \Carbon\Carbon::parse($request->date_to)->endOfDay() : \Carbon\Carbon::now()->endOfDay();
        $status = $request->input('status', '');
        $search = $request->input('search', '');

        $query = Orders::with(['user', 'items.product.category'])->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status !== '') $query->where('status', $status);
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%$search%")->orWhere('useremail', 'like', "%$search%");
                  });
            });
        }

        $orders = $query->latest()->get();
        $summary = [
            'total_orders'  => $orders->count(),
            'total_revenue' => $orders->whereIn('status', ['delivered', 'processing', 'shipped'])->sum('total_price'),
            'total_items'   => $orders->flatMap->items->sum('qty'),
            'avg_order'     => $orders->count() ? $orders->whereIn('status', ['delivered', 'processing', 'shipped'])->avg('total_price') : 0,
        ];

        $settings = Settings::first();
        $pdf = Pdf::loadView('frontend.orders.report_pdf', compact('orders', 'summary', 'dateFrom', 'dateTo', 'status', 'settings'))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Penjualan-' . $dateFrom->format('d-m-Y') . '.pdf');
    }

    /* ======================================================
        USER SECTION (Daftar Pesanan & Detail)
    ====================================================== */

    public function index(Request $request)
    {
        // Bersihkan pesanan expired lebih dari 24 jam
        Orders::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'cancelled', 'snap_token' => null]);

        $query = Orders::where('user_id', Auth::id())
            ->with(['items.product.images'])
            ->latest();

        if ($request->filled('search')) $query->where('order_number', 'like', '%' . $request->search . '%');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date_from')) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('created_at', '<=', $request->date_to);

        $orders = $query->get();
        return view('frontend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Orders::with(['items.product.category', 'items.product.unit', 'shipping.province', 'shipping.city'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }

    /* ======================================================
        MIDTRANS SNAP TOKEN (AJAX)
    ====================================================== */

public function getSnapToken($orderNumber)
{
    try {
        $order = Orders::where('order_number', $orderNumber)->firstOrFail();

        // KONFIGURASI MIDTRANS
        // Mengambil data dari config/services.php yang sudah kita buat di langkah 2
\Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        // Tambahkan pengecekan manual untuk memastikan key tidak null
        if (!\Midtrans\Config::$serverKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Key masih kosong di konfigurasi server.'
            ], 500);
        }

        $params = [
    'transaction_details' => [
        // Tambahkan time() atau string unik di belakang agar Midtrans menganggapnya ID baru
        // Namun di database kita tetap menggunakan order_number yang asli
        'order_id'     => $order->order_number . '-' . time(), 
        'gross_amount' => (int) $order->total,
    ],
            'customer_details' => [
                'first_name' => auth()->user()->username,
                'email'      => auth()->user()->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order->update(['snap_token' => $snapToken]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal membuat token: ' . $e->getMessage()
        ], 500);
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
                        $uq->where('username', 'like', "%$search%")->orWhere('useremail', 'like', "%$search%");
                    });
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('frontend.orders.admin_index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order     = Orders::with(['items', 'user'])->findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;

            $order->status = $newStatus;
            $order->save();

            if ($newStatus == 'delivered') {
                if ($order->user && $order->user->is_member) {
                    $this->updateUserTier($order->user);
                }
            }

            if ($newStatus == 'processing' && $oldStatus != 'processing') {
                $this->reduceStock($order->order_id);
            }

            return response()->json(['status' => 'success', 'message' => 'Status diperbarui ke ' . strtoupper($newStatus)]);
        } catch (\Exception $e) {
            Log::error("Update status error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /* ======================================================
        LOGIC: STOCK & TIERING
    ====================================================== */

    private function updateUserTier($user)
    {
        $setting = Settings::first();
        if (!$setting) return;

        $totalSpent = Orders::where('user_id', $user->user_id)->where('status', 'delivered')->sum('total_price');
        $newTier = 'regular';

        if ($totalSpent >= $setting->tier_premium_min) $newTier = 'premium';
        elseif ($totalSpent >= $setting->tier_plus_min) $newTier = 'plus';

        if ($user->tier !== $newTier) {
            $user->update(['tier' => $newTier]);
            Log::info("User {$user->user_id} naik tier ke {$newTier}");
        }
    }

    private function reduceStock($order_id)
    {
        $order = Orders::with(['items.product.category', 'items.product.material'])->find($order_id);
        if (!$order || $order->stock_reduced) return;

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $material = $item->product->material;
                if (!$material) continue;

                $qty = (int) $item->qty;
                $used = ($item->product->category->calc_type ?? 'luas') === 'luas' 
                        ? (($item->width_cm ?? 100) / 100) * (($item->height_cm ?? 100) / 100) * $qty 
                        : $qty;

                $material->decrement('stock', $used);
                StockLogs::create([
                    'material_id' => $material->material_id,
                    'type' => 'out',
                    'amount' => $used,
                    'last_stock' => $material->stock,
                    'description' => "Order #{$order->order_id}",
                ]);
            }
            $order->update(['stock_reduced' => 1]);
        });
    }

    /* ======================================================
        OTHERS: PDF, RATING, DESIGN, CANCEL
    ====================================================== */

    public function downloadInvoice($order_number)
    {
        $order = Orders::where('order_number', $order_number)->firstOrFail();
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);

        return Pdf::loadView('frontend.orders.invoice', compact('order'))->download('Invoice-' . $order->order_number . '.pdf');
    }

    public function downloadResi($order_number)
    {
        $order = Orders::with(['items.product.unit', 'user', 'shipping.province', 'shipping.city'])->where('order_number', $order_number)->firstOrFail();
        $settings = Settings::first();
        return Pdf::loadView('frontend.orders.resi', compact('order', 'settings'))->setPaper([0, 0, 283.46, 425.20])->download('Resi-' . $order_number . '.pdf');
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
        $request->validate(['product_id' => 'required', 'rating' => 'required|integer|min:1|max:5', 'review' => 'required|string']);
        Ratings::create(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'rating' => $request->rating, 'review' => $request->review]);
        return back()->with('success', 'Rating tersimpan!');
    }

    public function cancel($id)
    {
        $order = Orders::where('order_id', $id)->where('user_id', auth()->id())->firstOrFail();
        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled', 'snap_token' => null]);
            return back()->with('success', 'Pesanan dibatalkan.');
        }
        return back()->with('error', 'Gagal batal.');
    }

    public function create()
{
    $products = \App\Models\Products::all();
    $users = \App\Models\User::where('role', 'user')->get();
    
    return view('frontend.orders.create', compact('products', 'users'));
}

public function store(Request $request)
{
    // 1. Validasi Input (Sama seperti sisi User + Handling Member Baru)
    $request->validate([
        'user_id' => 'required_without:new_customer_name',
        'new_customer_name' => 'required_without:user_id',
        'payment_method' => 'required|in:cash,midtrans',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,product_id',
        'products.*.qty' => 'required|integer|min:1',
        'design_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,zip,rar|max:20480', // Max 20MB
    ]);

    return DB::transaction(function () use ($request) {
        
        // 2. Logika User (Daftar Member Baru atau Pilih Member Lama)
        if ($request->filled('new_customer_name')) {
            $user = User::create([
                'full_name' => $request->new_customer_name,
                'useremail' => $request->new_customer_email ?? 'guest.' . time() . '@wellenprint.com',
                'username'  => strtolower(Str::slug($request->new_customer_name)) . rand(100, 999),
                'password'  => bcrypt('password123'),
                'no_telp'   => $request->new_customer_phone,
                'role'      => 'user',
                'is_member' => 1,
            ]);
            $userId = $user->user_id;
        } else {
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
        }

        // 3. Kalkulasi Nominal (Subtotal & Tax)
        $calculatedSubtotal = 0;
        foreach ($request->products as $item) {
            $product = Products::find($item['product_id']);
            if($product) {
                // Jika produk printing pakai hitungan luas, sesuaikan di sini
                // Contoh standard: Harga x Qty
                $calculatedSubtotal += ($product->price * $item['qty']);
            }
        }
        
        $calculatedTax = $calculatedSubtotal * 0.11; // PPN 11%
        $calculatedTotal = $calculatedSubtotal + $calculatedTax;

        // 4. Handle Upload File Desain (Sama seperti flow Website User)
        $designPath = null;
        if ($request->hasFile('design_file')) {
            // Disimpan di folder public/order_designs
            $designPath = $request->file('design_file')->store('order_designs', 'public');
        }

        // 5. Simpan Order Utama (Fix Error 1364: 'total' & 'shipping_method')
        $isCash = $request->payment_method === 'cash';
        $order = Orders::create([
            'user_id'          => $userId,
            'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal'         => $calculatedSubtotal,
            'tax'              => $calculatedTax,
            'total'            => $calculatedTotal, // Nama kolom sesuai error database kamu
            'shipping_cost'    => 0,
            'status'           => $isCash ? 'paid' : 'pending',
            'payment_method'   => $request->payment_method,
            'paid_at'          => $isCash ? now() : null,
            'shipping_address' => 'Ambil di Toko', 
            'shipping_method'  => 'Pickup',
            'design_file'      => $designPath,
        ]);

        // 6. Simpan Detail Item (OrderItems)
        foreach ($request->products as $item) {
            $product = Products::find($item['product_id']);
            if(!$product) continue;

            OrderItems::create([
                'order_id'   => $order->order_id,
                'product_id' => $product->product_id,
                'qty'        => $item['qty'],
                // Gunakan input custom jika ada, jika tidak pakai default produk
                'width'      => $item['width_cm'] ?? $product->default_width_cm ?? 100,
                'height'     => $item['height_cm'] ?? $product->default_height_cm ?? 100,
                'unit_price'      => $product->price,
                'subtotal'   => $product->price * $item['qty'],
            ]);
        }

        // 7. Output Response (Cash Langsung Selesai, Midtrans Generate Token)
        if ($isCash) {
            return response()->json([
                'status'   => 'success',
                'message'  => 'Pesanan tunai berhasil disimpan!',
                'order_id' => $order->order_id
            ]);
        } else {
            // Logika Midtrans
            try {
                $params = [
                    'transaction_details' => [
                        'order_id'     => $order->order_number,
                        'gross_amount' => (int) $calculatedTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $user->full_name,
                        'email'      => $user->useremail,
                        'phone'      => $user->no_telp,
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                return response()->json([
                    'status'     => 'success',
                    'snap_token' => $snapToken,
                    'order_id'   => $order->order_id
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage()
                ], 500);
            }
        }
    });
}   
}