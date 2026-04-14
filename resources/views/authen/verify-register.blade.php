@extends('admin.auth')

@section('title', 'Verifikasi Akun - Digital Printing')

@section('content')

@php
    $sessionData = session('registrasi_sementara');
    $email = $sessionData['useremail'] ?? 'email@anda.com';
    
    // Logika sensor email
    $parts = explode('@', $email);
    $name = $parts[0];
    $domain = $parts[1] ?? '';
    $len = strlen($name);
    $showLen = floor($len / 2); 
    $hiddenEmail = substr($name, 0, $showLen) . str_repeat('*', $len - $showLen) . '@' . $domain;
@endphp

{{-- Sisi Kiri: Form --}}
<div class="auth-left">
    <div class="auth-brand">
        <div class="auth-brand-icon"></div>
        <span class="auth-brand-name">Digital Printing</span>
    </div>

    <h1 class="auth-title">Verifikasi Email</h1>
    <p class="auth-subtitle">
        Masukkan 6 digit kode OTP yang dikirim ke <br>
        <span style="color: #2563eb; font-weight: 700;">{{ $hiddenEmail }}</span>
    </p>

    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px; border-radius: 12px; font-size: 12px; margin-bottom: 20px; font-weight: 600;">
            ⚠️ {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px; border-radius: 12px; font-size: 12px; margin-bottom: 20px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register.verify.process') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Input OTP --}}
        <div class="auth-field">
            <label class="auth-label">Kode OTP (6 Angka)</label>
            <div class="auth-input-wrap">
                <span class="auth-input-icon"><i class="fas fa-key"></i></span>
                <input type="text" 
                       name="otp_code" 
                       id="otp_code" 
                       maxlength="6" 
                       inputmode="numeric" 
                       class="auth-input"
                       style="text-align: center; letter-spacing: 10px; font-size: 22px; font-weight: 800;"
                       placeholder="------" 
                       required autofocus autocomplete="off">
            </div>
            @error('otp_code') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
        </div>

        {{-- Info Box --}}
        <div style="background: #eff6ff; border-radius: 12px; padding: 12px; display: flex; gap: 10px; align-items: start;">
            <i class="fas fa-info-circle" style="color: #3b82f6; margin-top: 2px;"></i>
            <p style="font-size: 10px; color: #1e40af; line-height: 1.4;">
                Cek folder <b>Spam/Junk</b> jika kode tidak muncul di kotak masuk utama Anda.
            </p>
        </div>

        <button type="submit" class="auth-btn-primary">Verifikasi & Buat Akun</button>

        <div class="auth-divider">
            <span class="auth-divider-line"></span><span>ATAU</span><span class="auth-divider-line"></span>
        </div>

        <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
            Salah alamat email? 
            <a href="{{ route('register') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Daftar Ulang</a>
        </p>
    </form>
</div>

{{-- Sisi Kanan: Panel Biru --}}
<div class="auth-right">
    <div style="position: relative; z-index: 2;">
        {{-- Ikon Amplop Terbuka --}}
        <div class="floating-icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        
        <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
            {{-- Teks: Verifikasi Akun --}}
            <span class="typing-text">Verifikasi Akun</span>
        </h2>
        
        <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
            Satu langkah terakhir untuk memastikan keamanan akun dan melindungi data pribadi Anda.
        </p>
    </div>
</div>

<script>
    document.getElementById('otp_code').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

@endsection