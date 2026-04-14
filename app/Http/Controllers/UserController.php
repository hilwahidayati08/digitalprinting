<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // --- FITUR ADMIN (CRUD) ---

    public function index(Request $request)
    {
        $query = User::query();

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($inner) use ($search) {
                $inner->where('username', 'like', "%{$search}%")
                      ->orWhere('full_name', 'like', "%{$search}%")
                      ->orWhere('useremail', 'like', "%{$search}%");
            });
        });

        $users = $query->latest()->paginate(5)->withQueryString();
        return view('users.index', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user')); // View khusus admin
    }

// File: App\Http\Controllers\UserController.php

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'username'    => 'required|unique:users,username,' . $id . ',user_id',
        'useremail'   => 'required|email|unique:users,useremail,' . $id . ',user_id',
        'role'        => 'required|in:admin,user',
        'is_member'   => 'required|boolean',
        'saldo_komisi'=> 'required|numeric',
        'member_tier' => 'nullable|in:regular,plus,premium',
        'password'    => 'nullable|min:6',
    ]);

    $data = $request->only([
        'username', 'useremail', 'full_name', 'no_telp', 
        'role', 'is_member', 'saldo_komisi', 'member_tier', 
        'total_spent'
    ]);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
}

// Tambahkan method ini agar tidak error saat akses users/{id}
public function show($id)
{
    return redirect()->route('users.edit', $id);
}

    // --- FITUR PROFILE (USER) ---

    public function editProfile()
    {
        $user = auth()->user(); // Mengambil data diri sendiri
        return view('users.profile', compact('user'));
    }

public function updateProfile(Request $request)
{
    $user = User::findOrFail(auth()->id());

    $rules = [
        'username'         => 'required|string|max:100|unique:users,username,' . $user->user_id . ',user_id',
        'useremail'        => 'required|email|unique:users,useremail,' . $user->user_id . ',user_id',
        'full_name'        => 'nullable|string|max:255',
        'no_telp'          => 'nullable|string|max:20',
        'password'         => 'nullable|string|min:8|confirmed',
        'current_password' => [
            'nullable',
            function ($attribute, $value, $fail) use ($user, $request) {
                // current_password hanya wajib kalau:
                // 1. User mengisi password baru
                // 2. User SUDAH punya password (bukan akun Google murni)
                if ($request->filled('password') && $user->hasPassword()) {
                    if (!$value) {
                        $fail('Password saat ini wajib diisi untuk mengganti password.');
                    } elseif (!Hash::check($value, $user->password)) {
                        $fail('Password saat ini tidak sesuai.');
                    }
                }
            }
        ],
    ];

    $request->validate($rules);

    $data = $request->only(['username', 'useremail', 'full_name', 'no_telp']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return back()->with('success', 'Profil berhasil diperbarui!');
}

// App\Http\Controllers\UserController.php

// Method untuk halaman Security
public function editSecurity()
{
    $user = auth()->user();
    return view('users.security', compact('user'));
}

// Method untuk update password
public function updateSecurity(Request $request)
{
    $user = User::findOrFail(auth()->id());

    $rules = [
        'current_password' => [
            'required_if:password,null',
            function ($attribute, $value, $fail) use ($user, $request) {
                if ($request->filled('password') && $user->hasPassword()) {
                    if (!$value) {
                        $fail('Password saat ini wajib diisi untuk mengganti password.');
                    } elseif (!Hash::check($value, $user->password)) {
                        $fail('Password saat ini tidak sesuai.');
                    }
                }
            }
        ],
        'password' => 'nullable|string|min:8|confirmed',
    ];

    $request->validate($rules);

    if ($request->filled('password')) {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
    }

    return back()->with('success', 'Password berhasil diperbarui!');
}

    // --- FUNGSI TOOLS ADMIN LAINNYA ---

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User dihapus');
    }

    public function toggleMember($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_member' => !$user->is_member]);
        return back()->with('success', 'Status member berhasil diubah');
    }
}