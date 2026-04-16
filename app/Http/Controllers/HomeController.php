<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Carts;
use App\Models\Categories;
use App\Models\District;
use App\Models\Faqs;
use App\Models\FinishingOption;
use App\Models\Heros;
use App\Models\Materials;
use App\Models\MemberRequest;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\PasswordResetOtp;
use App\Models\Portofolios;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Profiles;
use App\Models\Province;
use App\Models\Ratings;
use App\Models\SaldoLog;
use App\Models\Services;
use App\Models\Settings;
use App\Models\Shippings;
use App\Models\StockLogs;
use App\Models\Units;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function home()
    {
        $hero = Heros::where('section', 'hero')
            ->first();

        $about = Heros::where('section', 'about')
            ->first();
        $categories = Categories::all();
        $services = Services::all();
        $topProductIds = OrderItems::select('product_id', DB::raw('SUM(qty) as total_sold'))
    ->groupBy('product_id')
    ->orderByDesc('total_sold')
    ->take(8)
    ->pluck('product_id');
$products = Products::whereIn('product_id', $topProductIds)
    ->with(['images', 'ratings', 'category'])
    ->get()
    ->sortBy(fn($p) => array_search($p->product_id, $topProductIds->toArray()));
        $portofolios = Portofolios::latest()->limit(4)->get();
        $faqs = Faqs::where('is_active', 1)->get();
        return view('welcome', compact(
            'hero',
            'about',
            'categories',
            'services',
            'products',
            'portofolios',
            'faqs'
        ));
    }

    public function dashboard()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // ── USERS ──────────────────────────────────────────
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        $newUsersLastMonth = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $userGrowth = $newUsersLastMonth > 0
            ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1)
            : ($newUsersThisMonth > 0 ? 100 : 0);

        // ── ORDERS ─────────────────────────────────────────
        $totalOrders = Orders::count();
        $ordersThisMonth = Orders::where('created_at', '>=', $startOfMonth)->count();
        $pendingOrders = Orders::where('status', 'pending')->count();
        $processingOrders = Orders::where('status', 'processing')->count();
        $completedOrders = Orders::where('status', 'completed')->count();
        $cancelledOrders = Orders::where('status', 'cancelled')->count();

        // ── REVENUE ────────────────────────────────────────
        $totalRevenue = Orders::where('status', 'completed')->sum('total');
        $revenueThisMonth = Orders::where('status', 'completed')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');
        $revenueLastMonth = Orders::where('status', 'completed')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');
        $revenueGrowth = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : ($revenueThisMonth > 0 ? 100 : 0);

        // ── PRODUCTS ───────────────────────────────────────
        $totalProducts = Products::count();
        $lowStockProducts = Materials::whereRaw('stock <= min_stock')->count();
        $outOfStockProducts = Materials::where('stock', 0)->count();
        $lowStockMaterialsCount = Materials::whereRaw('stock <= min_stock')->count();
        $totalMaterials = Materials::count();
        // ── REVENUE CHART (last 6 months) ──────────────────
$revenueChart = collect(); // Mulai dengan collection kosong
for ($i = 5; $i >= 0; $i--) {
    $month = $now->copy()->subMonths($i);
    $revenueChart->push([
        'month' => $month->format('M Y'),
        'revenue' => Orders::where('status', 'completed')
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->sum('total'),
        'orders' => Orders::whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->count(),
    ]);
}


        // ── RECENT ORDERS (EXCEPT DELIVERED & CANCEL) ─────────
$recentOrders = Orders::with('user')
    ->whereNotIn('status', ['delivered', 'cancelled', 'completed']) // Add completed if needed
    ->latest()
    ->paginate(5);

        // ── TOP PRODUCTS ───────────────────────────────────
        $topProducts = OrderItems::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        // ── RATINGS ────────────────────────────────────────
        $avgRating = Ratings::avg('rating') ?? 0;
        $totalRatings = Ratings::count();

        // ── WITHDRAWAL REQUESTS ────────────────────────────
        $pendingWithdrawals = WithdrawalRequest::where('status', 'pending, paid')->count();
        $totalWithdrawals = WithdrawalRequest::where('status', 'approved')->sum('amount');

        // ── MEMBER REQUESTS ────────────────────────────────
        $pendingMemberRequests = MemberRequest::where('status', 'pending')->count();

        // ── SALDO / BALANCE ────────────────────────────────
        $totalSaldoIn = SaldoLog::where('type', 'in')->sum('amount');
        $totalSaldoOut = SaldoLog::where('type', 'out')->sum('amount');

        // ── CATEGORIES & SERVICES ──────────────────────────
        $totalCategories = Categories::count();
        $totalServices = Services::count();
        $totalPortofolios = Portofolios::count();

        return view('dashboard', compact(
            // Users
            'totalUsers',
            'newUsersThisMonth',
            'userGrowth',
            // Orders
            'totalOrders',
            'ordersThisMonth',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            // Revenue
            'totalRevenue',
            'revenueThisMonth',
            'revenueGrowth',
            // Products
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            // Charts
            'revenueChart',
            // Lists
            'recentOrders',
            'topProducts',
            // Others
            'avgRating',
            'totalRatings',
            'pendingWithdrawals',
            'totalWithdrawals',
            'pendingMemberRequests',
            'totalSaldoIn',
            'totalSaldoOut',
            'totalCategories',
            'totalServices',
            'totalPortofolios',
            'lowStockMaterialsCount',
            'totalMaterials'
        ));

    }
}

