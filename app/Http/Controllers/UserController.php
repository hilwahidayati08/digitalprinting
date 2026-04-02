<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    // Search Logic
    $query->when($request->search, function ($q, $search) {
        $q->where(function ($inner) use ($search) {
            $inner->where('username', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('useremail', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
        });
    });

    // Role Filter
    $query->when($request->role, function ($q, $role) {
        $q->where('role', $role);
    });

    // Membership Status Filter
    $query->when($request->filled('is_member'), function ($q) use ($request) {
        $q->where('is_member', $request->is_member);
    });

    // Sort by newest
    $users = $query->latest()->paginate(15)->withQueryString();

    return view('users.index', compact('users'));
}

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|max:100',
            'full_name' => 'nullable|string|max:255',
            'useremail' => 'required|email|unique:users,useremail',
            'password'  => 'required|min:6',
            'no_telp'   => 'nullable|string|max:20',
            'role'      => 'required|string',
        ]);

        User::create([
            'username'  => $request->username,
            'full_name' => $request->full_name,
            'useremail' => $request->useremail,
            'password'  => Hash::make($request->password),
            'no_telp'   => $request->no_telp,
            'role'      => $request->role,
            'is_member' => 0, // Default bukan member
            'total_spent' => 0,
            'saldo_komisi' => 0,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        // Hapus 'profile' dari eager loading
        $user = User::with([
            'saldoLogs',
            'withdrawalRequests',
            'memberRequest',
        ])->findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        // Hapus with('profile')
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'username'  => 'required|unique:users,username,' . $id . ',user_id',
        'useremail' => 'required|email|unique:users,useremail,' . $id . ',user_id',
        'full_name' => 'nullable|string|max:255',
        'no_telp'   => 'nullable|string|max:20',
        'password'  => 'nullable|min:6',
    ]);

    $data = $request->only(['username', 'useremail', 'full_name', 'no_telp']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return back()->with('success', 'Profil Anda berhasil diperbarui!');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus pengecekan profile karena tabelnya sudah dihapus
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }

    // ==========================================
    // ADMIN: Toggle Member Manual
    // ==========================================

    public function toggleMember($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_member' => !$user->is_member]);

        $status = $user->is_member ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status member {$user->username} berhasil {$status}.");
    }

    // ==========================================
    // ADMIN: Override Rate Komisi Per Member
    // ==========================================

    /**
     * Admin set rate komisi khusus untuk member tertentu.
     * Jika dikosongkan, member akan ikut rate tier dari settings.
     */
    public function setCommissionRate(Request $request, $id)
    {
        $request->validate([
            'commission_rate_override' => 'nullable|numeric|min:0|max:100',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'commission_rate_override' => $request->commission_rate_override ?: null,
        ]);

        $pesan = $request->commission_rate_override
            ? "Rate komisi {$user->username} diset ke {$request->commission_rate_override}%."
            : "Rate komisi {$user->username} dikembalikan ke default tier.";

        return back()->with('success', $pesan);
    }
}