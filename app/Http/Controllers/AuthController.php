<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // =========== GOOGLE OAUTH ===========

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        $email      = $googleUser->getEmail();

        // 1. Cek apakah sudah pernah login Google via google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Sudah pernah → langsung login
            Auth::login($user);
            request()->session()->regenerate();

            return $user->role === 'admin'
                ? redirect()->route('dashboard')
                : redirect()->route('home');
        }

        // 2. Cek apakah email sudah terdaftar (akun manual)
        $user = User::where('useremail', $email)->first();

        if ($user) {
            // Email sudah ada → tautkan google_id ke akun existing
            $user->google_id = $googleUser->getId();
            $user->save();
        } else {
            // 3. User baru → buat akun, password NULL
// SEBELUM
// SESUDAH
$baseUsername = str()->slug($googleUser->getName() ?? $googleUser->getNickname(), '_');
$username = $baseUsername;

while (User::where('username', $username)->exists()) {
    $username = $baseUsername . '_' . rand(100, 999);
}

$user = User::create([
    'username'  => $username,
    'useremail' => $email,
    'google_id' => $googleUser->getId(),
    'no_telp'   => '-',
    'password'  => null,
    'role'      => 'user',
]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        return $user->role === 'admin'
            ? redirect()->route('dashboard')
            : redirect()->route('home');

    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Gagal login via Google. Silakan coba lagi.');
    }
}
// 1. Tampilkan Form Register Awal
    public function showregister()
    {
        return view('authen.register');
    }

    // 2. Proses Submit Form Register -> Simpan ke Session -> Kirim OTP
    public function prosesregister(Request $request)
    {
        // Validasi Input
        $request->validate([
            'username'  => ['required', 'string', 'max:100'],
            'useremail' => ['required', 'string', 'email', 'max:255', 'unique:users,useremail'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Generate OTP 6 Digit
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan Data Sementara ke SESSION (Server Memory)
        // Kita hash password sekarang supaya aman
        session([
            'registrasi_sementara' => [
                'username'  => $request->username,
                'useremail' => $request->useremail,
                'no_telp'   => '-', // Default strip dulu
                'password'  => Hash::make($request->password), 
                'role'      => 'user',
                'otp_code'  => $otpCode // Kode OTP disimpan di sini
            ]
        ]);

        // Kirim Email OTP
        try {
            // Pastikan kamu punya file view: resources/views/emails/otp.blade.php
            Mail::send('emails.otp', ['otpCode' => $otpCode, 'username' => $request->username], function ($message) use ($request) {
                $message->to($request->useremail, $request->username)
                        ->subject('🔐 Kode Verifikasi Pendaftaran');
            });

            return redirect()->route('register.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
} catch (\Exception $e) {
    session()->forget('registrasi_sementara');
    return back()->with('error', 'DEBUG: ' . $e->getMessage());
}
    }

    // 3. Tampilkan Halaman Input OTP
    public function showRegisterVerify()
    {
        // Cek keamanan: Kalau gak ada data di session (user nembak URL), tendang balik
        if (!session()->has('registrasi_sementara')) {
            return redirect()->route('register')->with('error', 'Sesi pendaftaran habis, silakan daftar ulang.');
        }

        // Ambil email dari session buat ditampilkan di layar (opsional, biar user tau email mana yg dikirim)
        $emailUser = session('registrasi_sementara')['useremail'];
        
        return view('authen.verify-register', compact('emailUser'));
    }

    // 4. Proses Cek OTP -> Simpan ke Database User
public function verifyRegisterOtp(Request $request)
{
    $request->validate([
        'otp_code' => 'required|numeric'
    ]);

    $dataSession = session('registrasi_sementara');

    if (!$dataSession) {
        return redirect()->route('register')->with('error', 'Waktu habis, silakan daftar ulang.');
    }

    if ($request->otp_code == $dataSession['otp_code']) {
        
        // 1. Create User
        $user = User::create([
            'username'  => $dataSession['username'],
            'useremail' => $dataSession['useremail'],
            'no_telp'   => $dataSession['no_telp'],
            'password'  => $dataSession['password'], 
            'role'      => 'user', // Memastikan role adalah user
        ]);

        // 2. Hapus Session Registrasi
        session()->forget('registrasi_sementara');

        // 3. LANGSUNG LOGIN-KAN USER (Agar tidak perlu isi form login lagi)
        Auth::login($user);
        $request->session()->regenerate();

        // 4. Redirect ke HOME (Karena ini pasti user baru)
        return redirect()->route('home')->with('success', 'Registrasi Berhasil! Selamat datang.');
        
    } else {
        return back()->with('error', 'Kode OTP Salah!');
    }
}
    // =========== LOGIN MANUAL ===========

    public function showLogin()
    {
        return view('authen.login');
    }

public function proseslogin(Request $request)
{
    $request->validate([
        'useremail' => 'required|string',
        'password'  => 'required|string'
    ]);

    // Cek apakah input berupa email atau username
    $fieldType = filter_var($request->useremail, FILTER_VALIDATE_EMAIL) ? 'useremail' : 'username';

    $user = User::where($fieldType, $request->useremail)->first();

    // Akun Google murni (belum punya password) → arahkan login Google
    if ($user && $user->google_id && is_null($user->password)) {
        return redirect()->route('login')
            ->with('error', 'Akun ini terdaftar via Google. Silakan login menggunakan tombol "Login dengan Google".');
    }

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        request()->session()->regenerate();

        return $user->role === 'admin'
            ? redirect()->route('dashboard')
            : redirect()->route('home');
    }

    return redirect()->route('login')->with('error', 'Email/username atau password salah');
}
    // =========== LOGOUT ===========

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // =========== FORGOT PASSWORD WITH OTP (Tetap Sama) ===========

    public function showForgotForm()
    {
        return view('authen.forgot-password');
    }
public function sendOtp(Request $request)
{
    $request->validate([
        'useremail' => 'required|email|exists:users,useremail'
    ]);

    $user = User::where('useremail', $request->useremail)->first();

    // Akun Google murni → tidak punya password, tidak perlu reset
    if ($user->isGoogleAccount()) {
        return back()->with('error', 'Akun ini terdaftar via Google. Silakan login menggunakan tombol "Login dengan Google".');
    }

    // Bersihkan OTP lama
    PasswordResetOtp::where('useremail', $request->useremail)
        ->where('is_used', false)
        ->update(['is_used' => true]);

    $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $token   = bin2hex(random_bytes(32));

    PasswordResetOtp::create([
        'useremail'  => $request->useremail,
        'otp_code'   => $otpCode,
        'token'      => $token,
        'expires_at' => Carbon::now()->addMinutes(15),
        'is_used'    => false
    ]);

    try {
        Mail::send('emails.otp', ['otpCode' => $otpCode, 'username' => $user->username], function ($message) use ($user) {
            $message->to($user->useremail, $user->username)
                    ->subject('🔐 Reset Password - Kode OTP Digital Printing');
        });

        return redirect()->route('password.verify.form', ['token' => $token])
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal mengirim email.');
    }
}

    public function showVerifyForm($token)
    {
        $resetOtp = PasswordResetOtp::where('token', $token)->where('is_used', false)->first();
        if (!$resetOtp || $resetOtp->expires_at->isPast()) {
            return redirect()->route('password.request')->with('error', 'Token kadaluarsa.');
        }
        $email = $resetOtp->useremail;
        $hiddenEmail = substr($email, 0, 2) . '****' . substr($email, strpos($email, '@'));
        return view('authen.verify-otp', compact('token', 'hiddenEmail'));
    }

    public function verifyOtp(Request $request, $token)
    {
        $request->validate(['otp_code' => 'required|string|size:6']);
        $resetOtp = PasswordResetOtp::where('token', $token)->where('is_used', false)->first();

        if (!$resetOtp || $resetOtp->otp_code !== $request->otp_code) {
            return back()->with('error', 'Kode OTP salah.');
        }

        return redirect()->route('password.reset.form', ['token' => $token]);
    }

    public function showResetForm($token)
    {
        return view('authen.reset-password', compact('token'));
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate(['password' => 'required|min:8|confirmed']);
        $resetOtp = PasswordResetOtp::where('token', $token)->where('is_used', false)->first();

        if ($resetOtp) {
            $user = User::where('useremail', $resetOtp->useremail)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            $resetOtp->is_used = true;
            $resetOtp->save();

            return redirect()->route('login')->with('success', 'Password berhasil direset!');
        }
        return back()->with('error', 'Gagal mereset password.');
    }
}