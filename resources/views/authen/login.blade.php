@extends('admin.auth')

@section('title', 'Login - Digital Printing')

@section('content')
    {{-- Sisi Kiri: Form --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon"></div>
            <span class="auth-brand-name">Digital Printing</span>
        </div>

        <h1 class="auth-title">Selamat Datang!</h1>
        <p class="auth-subtitle">Masuk untuk mengelola pesanan.</p>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="auth-field">
                <label class="auth-label">Email / Username</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="text" name="useremail" class="auth-input" placeholder="admin@example.com" required>
                </div>
            </div>

            <div class="auth-field">
                <div style="display: flex; justify-content: space-between;">
                    <label class="auth-label">Password</label>
                    <a href="{{ route('password.request') }}" style="font-size: 10px; color: #2563eb; text-decoration: none; font-weight: 700;">Lupa Password?</a>
                </div>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="auth-input" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="auth-btn-primary">Masuk Sekarang</button>

            <div class="auth-divider">
                <span class="auth-divider-line"></span><span>ATAU</span><span class="auth-divider-line"></span>
            </div>

            <a href="{{ url('auth/google') }}" class="auth-btn-google">
                <img src="https://www.svgrepo.com/show/355037/google.svg" width="14"> Google
            </a>

            <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
                Belum punya akun? <a href="{{ route('register') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Daftar</a>
            </p>
        </form>
    </div>

    {{-- Sisi Kanan: Panel Biru dengan Animasi Lucu --}}
    <div class="auth-right">
<div style="position: relative; z-index: 2;">
    {{-- Ikon diganti agar lebih ramah untuk Customer --}}
    <div class="floating-icon">
        <i class="fas fa-user-circle"></i>
    </div>
    
    <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
        {{-- Teks: Pusat Layanan --}}
        <span class="typing-text">Pusat Layanan</span>
    </h2>
    
    <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
        Akses semua kebutuhan dan pantau aktivitas Anda dengan mudah dalam satu pintu.
    </p>
</div>
    </div>
@endsection