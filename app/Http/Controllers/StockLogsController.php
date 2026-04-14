<?php

namespace App\Http\Controllers;

use App\Models\StockLogs;
use Illuminate\Http\Request;

class StockLogsController extends Controller
{
    public function index(Request $request)
{
    // Menggunakan query builder agar bisa dikondisikan
    $query = StockLogs::with('material.unit');

    // Fitur Pencarian: Mencari berdasarkan nama material
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->whereHas('material', function($q) use ($search) {
            $q->where('material_name', 'like', "%{$search}%");
        });
    }

    // Menampilkan log terbaru di atas dengan pagination
    // withQueryString() penting agar saat pindah halaman, keyword pencarian tidak hilang
    $logs = $query->latest()->paginate(5)->withQueryString();

    return view('stock_logs.index', compact('logs'));
}
}