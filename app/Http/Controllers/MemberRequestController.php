<?php

namespace App\Http\Controllers;

use App\Models\MemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberRequestController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'reason' => 'required|string|min:20|max:500',
    ], [
        'reason.required' => 'Alasan wajib diisi.',
        'reason.min'      => 'Alasan minimal 20 karakter.',
    ]);

$user = auth()->user();
    
    // 1. Ambil Setting dari database (Asumsi row ID 1 atau sesuaikan)
    $setting = \App\Models\Settings::first(); 

    // 2. Hitung Data Order User (Hanya yang sudah valid/selesai)
    $validStatuses = ['paid', 'processing', 'shipped', 'delivered'];
    
    $userOrdersCount = \App\Models\Orders::where('user_id', $user->user_id)
                        ->whereIn('status', $validStatuses)
                        ->count();

    $userTotalSpent = \App\Models\Orders::where('user_id', $user->user_id)
                        ->whereIn('status', $validStatuses)
                        ->sum('total');

    // 3. Cek Syarat Member menggunakan kolom $fillable kamu
    $minOrders = $setting->member_min_orders ?? 5;
    $minSpent  = $setting->member_min_spent ?? 500000;

    if ($userOrdersCount < $minOrders && $userTotalSpent < $minSpent) {
        return redirect()->back()->with('error', 
            "Syarat belum cukup. Minimal $minOrders order atau total belanja Rp " . number_format($minSpent, 0, ',', '.')
        );
    }

    // 4. Cek duplikasi request
    $existing = MemberRequest::where('user_id', $user->user_id)->first();
    if ($existing) {
        return redirect()->back()->with('info', 'Anda sudah mengajukan pendaftaran member.');
    }

    // 5. Simpan ke tabel member_requests
    MemberRequest::create([
        'user_id'          => $user->user_id,
        'rejection_reason' => $request->reason,
        'status'           => 'pending',
    ]);

    return redirect()->route('home')->with('success', 'Pengajuan member berhasil dikirim!');
}

    // ADMIN
public function adminIndex(Request $request)
{
    $query = MemberRequest::with('user');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Menggunakan paginate 10 agar seragam dengan tabel lain
    $requests = $query->latest()->paginate(10)->withQueryString();

    return view('member-requests.index', compact('requests'));
}

    public function approve($id)
    {
        $memberRequest = MemberRequest::with('user')->findOrFail($id);

        if ($memberRequest->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $memberRequest->update([
            'status'       => 'approved',
            'processed_at' => now(),
        ]);

        // Set user jadi member
        $memberRequest->user->update(['is_member' => 1]);

        return back()->with('success', "{$memberRequest->user->username} berhasil disetujui menjadi member.");
    }

    public function reject($id)                  // ← hapus Request $request, tidak perlu
    {
        $memberRequest = MemberRequest::with('user')->findOrFail($id);

        if ($memberRequest->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $memberRequest->update([
            'status'       => 'rejected',
            'processed_at' => now(),
            // rejection_reason tidak ditimpa, tetap berisi alasan customer
        ]);

        return back()->with('success', "Pengajuan {$memberRequest->user->username} berhasil ditolak.");
    }
}