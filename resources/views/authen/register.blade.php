@extends('admin.auth')

@section('title', 'Daftar Akun - Digital Printing')

@section('content')
    {{-- Sisi Kiri: Form --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon"></div>
            <span class="auth-brand-name">Digital Printing</span>
        </div>

        <h1 class="auth-title">Buat Akun Baru</h1>
        <p class="auth-subtitle">Daftar untuk mulai mengelola pesanan Anda.</p>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            
            {{-- Input Username --}}
            <div class="auth-field">
                <label class="auth-label">Username</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="auth-input" placeholder="Contoh: BudiAdmin" value="{{ old('username') }}" required autofocus>
                </div>
                @error('username') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Input Email --}}
            <div class="auth-field">
                <label class="auth-label">Email Address</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="useremail" class="auth-input" placeholder="admin@example.com" value="{{ old('useremail') }}" required>
                </div>
                @error('useremail') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Input Password --}}
            <div class="auth-field">
                <label class="auth-label">Password</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="auth-input" placeholder="Minimal 8 karakter" required>
                </div>
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="auth-field">
                <label class="auth-label">Konfirmasi Password</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-shield-alt"></i></span>
                    <input type="password" name="password_confirmation" class="auth-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="auth-btn-primary">Daftar Sekarang</button>

            <div class="auth-divider">
                <span class="auth-divider-line"></span><span>ATAU</span><span class="auth-divider-line"></span>
            </div>

            <a href="{{ url('auth/google') }}" class="auth-btn-google">
                <img src="https://www.svgrepo.com/show/355037/google.svg" width="14"> Daftar dengan Google
            </a>

            <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Masuk</a>
            </p>
        </form>
    </div>

    {{-- Sisi Kanan: Panel Biru (Sama dengan Login agar Konsisten) --}}
<div class="auth-right">
    <div style="position: relative; z-index: 2;">
        {{-- Ikon Roket --}}
        <div class="floating-icon">
            <i class="fas fa-rocket"></i>
        </div>
        
        <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
            <span class="typing-text">Mulai Sekarang</span>
        </h2>
        
        <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
            Satu langkah lagi untuk menikmati kemudahan layanan cetak digital dalam genggaman Anda.
        </p>
    </div>
</div>
@endsection