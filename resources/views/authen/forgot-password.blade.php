@extends('admin.auth')

@section('title', 'Lupa Password - Digital Printing')

@section('content')
    {{-- Sisi Kiri: Form --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon"></div>
            <span class="auth-brand-name">Digital Printing</span>
        </div>

        <h1 class="auth-title">Lupa Password? </h1>
        <p class="auth-subtitle">Masukkan email Anda untuk menerima kode OTP.</p>

        {{-- Peringatan Akun Google --}}
        @if(session('error'))
            <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 15px; border-radius: 16px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 10px;">
                <i class="fab fa-google" style="color: #ef4444; margin-top: 2px;"></i>
                <div>
                    <p style="font-size: 12px; font-weight: 800; color: #dc2626; margin: 0 0 4px;">Akun Google Terdeteksi</p>
                    <p style="font-size: 11px; color: #ef4444; margin: 0;">{{ session('error') }}</p>
                    <a href="{{ url('auth/google') }}" 
                       style="display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; background: #2563eb; color: white; padding: 8px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; text-decoration: none;">
                        <i class="fab fa-google"></i> Login dengan Google
                    </a>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            
            {{-- Input Email --}}
            <div class="auth-field">
                <label class="auth-label">Email Address</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="useremail" class="auth-input" placeholder="nama@email.com" value="{{ old('useremail') }}" required autofocus>
                </div>
                @error('useremail') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Box Info Cara Kerja --}}
            <div style="background: #eff6ff; border: 1px dashed #bfdbfe; padding: 12px; border-radius: 12px; margin-bottom: 10px;">
                <p style="font-size: 10px; color: #1e40af; font-weight: 800; margin-bottom: 4px; text-transform: uppercase;">
                    <i class="fas fa-info-circle"></i> Info Reset:
                </p>
                <ul style="font-size: 10px; color: #3b82f6; padding-left: 15px; line-height: 1.4;">
                    <li>Masukkan email terdaftar Anda</li>
                    <li>Kami akan kirim kode OTP 6 digit</li>
                    <li>Gunakan kode untuk ganti password</li>
                </ul>
            </div>

            <button type="submit" class="auth-btn-primary">Kirim Kode OTP</button>

            <div class="auth-divider">
                <span class="auth-divider-line"></span><span>ATAU</span><span class="auth-divider-line"></span>
            </div>

            <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
                Ingat password Anda? <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Kembali ke Login</a>
            </p>
        </form>
    </div>

    {{-- Sisi Kanan: Panel Biru --}}
    <div class="auth-right">
        <div style="position: relative; z-index: 2;">
            <div class="floating-icon">
                <i class="fas fa-unlock-alt"></i>
            </div>
            <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
                <span class="typing-text">Pulihkan Akses</span>
            </h2>
            <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
                Jangan khawatir, kami akan membantu mengatur ulang kata sandi dan mengamankan kembali akun Anda.
            </p>
        </div>
    </div>
@endsection