<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    // USER
   public function index(Request $request)
{
    $query = WithdrawalRequest::with('user');

    // Filter Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $withdraws = $query->latest()->paginate(10)->withQueryString();

    return view('admin.withdrawals.index', compact('withdraws'));
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

        return back()->with('success', 'Request withdraw berhasil dikirim! Tunggu konfirmasi admin.');
    }

    // ADMIN
    public function adminIndex(Request $request)
    {
        $query = WithdrawalRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdraws = $query->latest()->paginate(15);

        return view('withdrawals.index', compact('withdraws')); // ✅ fix
    }

    public function approve($id)
    {
        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if (!$withdrawal->is_pending) {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        try {
            $withdrawal->approve();
            return back()->with('success',
                "Withdraw {$withdrawal->amount_formatted} untuk {$withdrawal->user->username} berhasil disetujui."
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if (!$withdrawal->is_pending) {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        $withdrawal->reject($request->rejection_reason);

        return back()->with('success',
            "Request withdraw {$withdrawal->user->username} berhasil ditolak."
        );
    }
}