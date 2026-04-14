<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use App\Models\User;
class WithdrawalController extends Controller
{
    // USER
   public function index(Request $request)
{
    $user = auth()->user();
    
    $query = WithdrawalRequest::where('user_id', $user->user_id);

    // Filter Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $withdraws = $query->latest()->paginate(5)->withQueryString();

    return view('withdrawals.index', compact('withdraws', 'user'));
}

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'amount'         => 'required|numeric|min:10000',
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:100',
        ]);

        if (!$user->saldoCukup($request->amount)) {
            return back()->withErrors([
                'amount' => 'Saldo komisi tidak mencukupi. Saldo kamu: ' . $user->saldo_komisi_formatted,
            ]);
        }

        $pendingExists = WithdrawalRequest::where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingExists) {
            return back()->with('error', 'Kamu masih memiliki request withdraw yang sedang diproses.');
        }

        WithdrawalRequest::create([
            'user_id'        => $user->user_id,
            'amount'         => $request->amount,
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'status'         => 'pending',
        ]);

        \App\Models\Notification::create([
            'type'    => 'withdrawal',
            'title'   => '💸 Request Withdraw Baru',
            'message' => $user->username . ' mengajukan withdraw Rp ' . number_format($request->amount) . '.',
            'url'     => '/withdrawals',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Request withdraw berhasil dikirim! Tunggu konfirmasi admin.');
    }

    // ADMIN
public function adminIndex(Request $request)
{
    $withdraws = WithdrawalRequest::with('user')
        ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
        ->latest()
        ->paginate(5);

    $members = User::where('is_member', true)  // ← pastikan ini ada
        ->orderBy('username')
        ->get();

    return view('withdrawals.admin_index', compact('withdraws', 'members')); // ← pastikan nama view benar
}

    public function approve($id)
    {
        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if (!$withdrawal->is_pending) {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        try {
            $withdrawal->approve();
            \App\Models\Notification::create([
    'type'    => 'withdrawal',
    'title'   => '✅ Withdraw Disetujui',
    'message' => 'Withdraw ' . $withdrawal->amount_formatted . ' untuk ' . $withdrawal->user->username . ' telah disetujui.',
    'url'     => '/withdrawals',
    'is_read' => 0,
]);
            return back()->with('success',
                "Withdraw {$withdrawal->amount_formatted} untuk {$withdrawal->user->username} berhasil disetujui."
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        
    }


}