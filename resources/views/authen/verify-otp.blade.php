@extends('admin.auth')

@section('title', 'Verifikasi OTP - Digital Printing')

@section('content')
    {{-- Sisi Kiri: Form --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon">   </div>
            <span class="auth-brand-name">Digital Printing</span>
        </div>

        <h1 class="auth-title">Verifikasi OTP</h1>
        <p class="auth-subtitle">
            Kode terkirim ke <span style="color: #2563eb; font-weight: 700;">{{ $hiddenEmail }}</span>
        </p>

        <form action="{{ route('password.verify', $token) }}" method="POST" class="space-y-4">
            @csrf

            {{-- Input OTP (Didesain agar angka terlihat besar di tengah) --}}
            <div class="auth-field">
                <label class="auth-label">Kode OTP (6 Digit)</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-fingerprint"></i></span>
                    <input type="text" name="otp_code" id="otp_code" class="auth-input" 
                        style="text-align: center; letter-spacing: 8px; font-size: 20px; font-weight: 800;"
                        placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]*" required autofocus>
                </div>
                @error('otp_code') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Timer Box --}}
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">⏳ WAKTU TERSISA</span>
                    <span id="timer" style="font-size: 14px; font-weight: 800; color: #2563eb;">15:00</span>
                </div>
                <div style="width: 100%; bg: #e2e8f0; height: 6px; border-radius: 10px; background: #e2e8f0; overflow: hidden;">
                    <div id="timer-bar" style="width: 100%; height: 100%; background: #2563eb; transition: width 1s linear;"></div>
                </div>
            </div>

            <button type="submit" class="auth-btn-primary" style="margin-top: 10px;">Verifikasi Sekarang</button>

            <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
                Tidak terima kode? 
                <a href="{{ route('password.request') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Kirim Ulang</a>
            </p>

            <div style="text-align: center; margin-top: 10px;">
                <a href="{{ route('login') }}" style="font-size: 11px; color: #94a3b8; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>

    {{-- Sisi Kanan: Panel Biru --}}
    <div class="auth-right">
<div style="position: relative; z-index: 2;">
    {{-- Ikon Gembok Terbuka --}}
    <div class="floating-icon">
        <i class="fas fa-unlock-alt"></i>
    </div>
    
    <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
        {{-- Teks lebih manusiawi: Pulihkan Akses --}}
        <span class="typing-text">Pulihkan Akses</span>
    </h2>
    
    <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
        Jangan khawatir, kami akan membantu mengatur ulang kata sandi dan mengamankan kembali akun Anda.
    </p>
</div>
    </div>
@endsection

@push('scripts')
<script>
    // Timer Countdown Logic
    function startTimer(duration, display) {
        let timer = duration, minutes, seconds;
        const bar = document.getElementById('timer-bar');
        
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;
            
            const percentage = (timer / duration) * 100;
            bar.style.width = percentage + '%';

            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = "00:00";
                bar.style.background = "#ef4444";
            }
        }, 1000);
    }

    window.onload = function () {
        const fifteenMinutes = 60 * 15,
              display = document.querySelector('#timer');
        startTimer(fifteenMinutes, display);
    };

    // Auto submit behavior (Opsional)
    document.getElementById('otp_code').addEventListener('input', function() {
        if (this.value.length === 6) {
            // form.submit(); // Aktifkan jika ingin submit otomatis saat 6 angka terisi
        }
    });
</script>
@endpush