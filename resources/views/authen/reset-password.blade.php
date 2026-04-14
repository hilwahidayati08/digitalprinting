@extends('admin.auth')

@section('title', 'Reset Password - Digital Printing')

@section('content')
    {{-- Sisi Kiri: Form --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon"></div>
            <span class="auth-brand-name">Digital Printing</span>
        </div>

        <h1 class="auth-title">Password Baru</h1>
        <p class="auth-subtitle">Silakan buat password baru yang kuat untuk akun Anda.</p>


        <form action="{{ route('password.reset', $token) }}" method="POST" class="space-y-4">
            @csrf

            {{-- Input Password Baru --}}
            <div class="auth-field">
                <label class="auth-label">Password Baru</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="auth-input" placeholder="Minimal 8 karakter" required autofocus>
                </div>
                @error('password') <small style="color: #ef4444; font-size: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="auth-field">
                <label class="auth-label">Konfirmasi Password Baru</label>
                <div class="auth-input-wrap">
                    <span class="auth-input-icon"><i class="fas fa-shield-alt"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input" placeholder="Ulangi password baru" required>
                </div>
            </div>

            {{-- Password Strength Indicator (Visual Sederhana) --}}
            <div style="padding: 0 5px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kekuatan:</span>
                    <span id="strength-text" style="font-size: 10px; font-weight: 800; color: #2563eb;">Ketik password...</span>
                </div>
                <div style="display: flex; gap: 4px; height: 4px;">
                    <div id="strength-1" style="flex: 1; background: #e2e8f0; border-radius: 10px; transition: all 0.3s;"></div>
                    <div id="strength-2" style="flex: 1; background: #e2e8f0; border-radius: 10px; transition: all 0.3s;"></div>
                    <div id="strength-3" style="flex: 1; background: #e2e8f0; border-radius: 10px; transition: all 0.3s;"></div>
                </div>
            </div>

            <button type="submit" class="auth-btn-primary" style="margin-top: 10px;">Simpan Password</button>

            <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #64748b;">
                Ingat password Anda? <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 800; text-decoration: none;">Kembali ke Login</a>
            </p>
        </form>
    </div>

    {{-- Sisi Kanan: Panel Biru --}}
    <div class="auth-right">
        <div style="position: relative; z-index: 2;">
            {{-- Ikon Kunci untuk Reset --}}
            <div class="floating-icon">
                <i class="fas fa-key"></i>
            </div>
            
            <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">
                <span class="typing-text">Akses Aman</span>
            </h2>
            
            <p style="opacity: 0.8; font-size: 11px; line-height: 1.5; max-width: 200px; margin: 0 auto;">
                Gunakan kombinasi huruf besar, angka, dan simbol agar akun tetap aman.
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        // 1. Konfigurasi
        const DURATION_MINUTES = 15;
        const STORAGE_KEY = 'otp_expiry_time';
        
        function startTimer() {
            const display = document.querySelector('#timer');
            const bar = document.getElementById('timer-bar');
            
            if (!display || !bar) {
                console.error("Elemen timer tidak ditemukan!");
                return;
            }

            // 2. Cek waktu kedaluwarsa di storage
            let expiryTime = localStorage.getItem(STORAGE_KEY);
            const now = Math.floor(Date.now() / 1000);

            // Jika tidak ada storage atau sudah expired, set baru
            if (!expiryTime || now > parseInt(expiryTime)) {
                expiryTime = now + (DURATION_MINUTES * 60);
                localStorage.setItem(STORAGE_KEY, expiryTime);
                console.log("Timer baru dibuat. Selesai pada: " + expiryTime);
            } else {
                expiryTime = parseInt(expiryTime);
                console.log("Melanjutkan timer lama. Sisa: " + (expiryTime - now) + " detik");
            }

            // 3. Fungsi Update setiap detik
            const interval = setInterval(() => {
                const currentTime = Math.floor(Date.now() / 1000);
                const remaining = expiryTime - currentTime;

                if (remaining <= 0) {
                    clearInterval(interval);
                    display.textContent = "00:00";
                    bar.style.width = "0%";
                    bar.style.background = "#ef4444";
                    localStorage.removeItem(STORAGE_KEY);
                    return;
                }

                // Hitung menit & detik
                const m = Math.floor(remaining / 60);
                const s = remaining % 60;
                
                // Update Tampilan
                display.textContent = `${m < 10 ? '0' + m : m}:${s < 10 ? '0' + s : s}`;
                
                // Update Progress Bar
                const percent = (remaining / (DURATION_MINUTES * 60)) * 100;
                bar.style.width = percent + "%";

                // Warna kuning jika sisa 2 menit
                if (remaining < 120) bar.style.background = "#f59e0b";
            }, 1000);
        }

        // Jalankan saat halaman siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', startTimer);
        } else {
            startTimer();
        }

        // 4. RESET jika tombol "Kirim Ulang" diklik
        // Cari link yang mengandung kata 'request' atau 'kirim ulang'
        document.querySelectorAll('a').forEach(link => {
            if (link.innerText.toLowerCase().includes('kirim ulang')) {
                link.addEventListener('click', () => {
                    localStorage.removeItem(STORAGE_KEY);
                });
            }
        });
    })();
</script>
@endpush