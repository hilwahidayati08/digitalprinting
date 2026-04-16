<?php

namespace App\Http\Controllers;

use App\Models\MemberRequest;
use Illuminate\Http\Request;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class MemberRequestController extends Controller
{
public function store(Request $request)
{
    $user = auth()->user();

    // Cek duplikasi
    $existing = MemberRequest::where('user_id', $user->user_id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->first();

    if ($existing) {
        return redirect()->back()->with('info', 'Anda sudah mengajukan pendaftaran member.');
    }

    MemberRequest::create([
        'user_id' => $user->user_id,
        'status'  => 'pending',
    ]);

Notification::create([
    'user_id'  => null,
    'type'     => 'member',
    'title'    => 'Permintaan Member Baru',
    'message'  => auth()->user()->username
                 . ' mengajukan permintaan menjadi member.',
    'url'      => '/member-requests',
    'is_read'  => false,
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
    
    // Store old tier BEFORE updating
    $oldTier = $memberRequest->user->member_tier; // Add this line
    
    $memberRequest->update([
        'status'       => 'approved',
        'processed_at' => now(),
    ]);
    
    // Set user jadi member
    $memberRequest->user->update(['is_member' => 1]);
    
    Notification::create([
        'user_id'  => $memberRequest->user_id,
        'type'     => 'member',
        'title'    => 'Selamat, Kamu Jadi Member!',
        'message'  => 'Permintaan member kamu disetujui. '
                     . 'Kamu sekarang bisa mendapatkan komisi dari setiap pesanan.',
        'url'      => '/orders',
        'is_read'  => false,
    ]);
    
    // Now you can use $oldTier
    if ($oldTier !== $memberRequest->user->member_tier) {
        Notification::create([
            'user_id'  => $memberRequest->user->user_id,
            'type'     => 'member',
            'title'    => 'Tier Member Naik!',
            'message'  => 'Selamat! Tier kamu naik ke '
                         . strtoupper($memberRequest->user->member_tier) . '.',
            'url'      => '/orders',
            'is_read'  => false,
        ]);
    }
    
    return back()->with('success', "{$memberRequest->user->username} berhasil disetujui menjadi member.");
}

public function reject($id)
{
    $memberRequest = MemberRequest::with('user')->findOrFail($id);
    
    if ($memberRequest->status !== 'pending') {
        return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
    }
    
    $memberRequest->update([
        'status'       => 'rejected',
        'processed_at' => now(),
    ]);
    
    // Fix the notification creation
    Notification::create([
    'user_id' => $memberRequest->user_id,
        'type'     => 'member',
        'title'    => '❌ Member Ditolak',
        'message'  => 'Pengajuan ' . $memberRequest->user->username . ' telah ditolak.',
        'url'      => '/member-requests',
        'is_read'  => false,  // Use false instead of 0 for consistency
    ]);
    
    return back()->with('success', "Pengajuan {$memberRequest->user->username} berhasil ditolak.");
}
}