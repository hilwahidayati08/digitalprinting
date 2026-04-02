@extends('admin.auth')

@section('title', 'Verifikasi OTP - Digital Printing')

@section('content')
<div class="text-center">
    <div class="mb-8 flex justify-center">
        @include('partials.auth.logo')
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
            Verifikasi Kode OTP
        </h2>
        <p class="text-neutral-500 text-sm mt-2 font-medium">
            Kode telah dikirim ke <span class="font-semibold text-primary-600">{{ $hiddenEmail }}</span>
        </p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border-2 border-green-200 text-green-700 rounded-2xl text-sm animate-slide-down">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border-2 border-red-200 text-red-700 rounded-2xl text-sm animate-slide-down">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
@endif

<form action="{{ route('password.verify', $token) }}" method="POST" class="space-y-6">
    @csrf

    <!-- OTP Field -->
    <div class="space-y-2">
        <label for="otp_code" class="block text-sm font-semibold text-neutral-700 ml-1">
            Kode OTP (6 digit)
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3"/>
                </svg>
            </div>
            <input type="text" 
                   name="otp_code" 
                   id="otp_code"
                   value="{{ old('otp_code') }}"
                   maxlength="6"
                   inputmode="numeric"
                   pattern="[0-9]*"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium text-center text-2xl tracking-[8px] @error('otp_code') border-red-400 @enderror" 
                   placeholder="000000"
                   required>
        </div>
        @error('otp_code')
            <p class="text-xs text-red-600 mt-1 ml-1 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Timer & Info -->
    <div class="bg-primary-50 p-5 rounded-2xl border-2 border-primary-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-semibold text-primary-700">⏰ Waktu tersisa:</span>
            <span class="text-lg font-bold text-primary-600" id="timer">15:00</span>
        </div>
        <div class="w-full bg-primary-200 rounded-full h-2">
            <div class="bg-primary-600 h-2 rounded-full transition-all duration-1000" id="timer-bar" style="width: 100%"></div>
        </div>
        <p class="text-xs text-primary-600 mt-3">
            Kode OTP akan kadaluarsa dalam 15 menit. Jangan berikan kode kepada siapapun.
        </p>
    </div>

    <!-- Resend Link -->
    <div class="text-center">
        <p class="text-sm text-neutral-500">
            Tidak menerima kode? 
            <a href="{{ route('password.request') }}" class="text-primary-600 font-bold hover:text-primary-700 hover:underline underline-offset-4">
                Kirim Ulang
            </a>
        </p>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-4 bg-gradient-to-r from-primary-600 to-primary-500 text-white font-extrabold rounded-2xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide">
        Verifikasi OTP
    </button>

    <!-- Back to Login -->
    <div class="text-center pt-2">
        <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 text-sm text-neutral-500 hover:text-primary-600 font-medium group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke login</span>
        </a>
    </div>
</form>

<!-- Security Badge -->
<div class="mt-8 flex items-center justify-center space-x-2 text-xs text-neutral-400">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
    </svg>
    <span>Kode OTP bersifat rahasia</span>
</div>
@endsection

@push('styles')
<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-down {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Timer countdown
    function startTimer(duration, display) {
        let timer = duration, minutes, seconds;
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;
            
            // Update timer bar
            const percentage = (timer / duration) * 100;
            document.getElementById('timer-bar').style.width = percentage + '%';

            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = "00:00";
                document.getElementById('timer-bar').style.width = '0%';
                document.getElementById('timer-bar').classList.add('bg-red-500');
            }
        }, 1000);
    }

    window.onload = function () {
        const fifteenMinutes = 60 * 15,
            display = document.querySelector('#timer');
        startTimer(fifteenMinutes, display);
    };

    // Auto focus OTP input
    document.getElementById('otp_code').focus();
    
    // Auto submit when 6 digits entered
    document.getElementById('otp_code').addEventListener('input', function(e) {
        if (this.value.length === 6) {
            // Optional: auto submit form
            // this.form.submit();
        }
    });
</script>
@endpush