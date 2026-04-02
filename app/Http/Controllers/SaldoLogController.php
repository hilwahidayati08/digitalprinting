<?php

namespace App\Http\Controllers;

use App\Models\SaldoLog;
use Illuminate\Http\Request;

class SaldoLogController extends Controller
{
    // USER
    public function index(Request $request)
{
    // Eager load 'user' untuk performa, tampilkan semua log (Admin view)
    $query = SaldoLog::with('user');

    // Filter Berdasarkan Pencarian Username (Jika ada)
    if ($request->filled('search')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('username', 'like', '%' . $request->search . '%');
        });
    }

    // Filter Berdasarkan Tipe
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    $logs = $query->latest()->paginate(15)->withQueryString();

    return view('admin.saldo-logs.index', compact('logs'));
}

    // ADMIN
    public function adminIndex(Request $request)
    {
        $query = SaldoLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $logs = $query->latest()->paginate(20);

        return view('saldo-logs.index', compact('logs')); // ✅ fix
    }
}