@extends('admin.auth')

@section('title', 'Reset Password - Digital Printing')

@section('content')
<div class="text-center">
    <div class="mb-8 flex justify-center">
        @include('partials.auth.logo')
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
            Buat Password Baru
        </h2>
        <p class="text-neutral-500 text-sm mt-2 font-medium">
            Password minimal 8 karakter
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

<form action="{{ route('password.reset', $token) }}" method="POST" class="space-y-6">
    @csrf

    <!-- New Password -->
    <div class="space-y-2">
        <label for="password" class="block text-sm font-semibold text-neutral-700 ml-1">
            Password Baru
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <input type="password" 
                   name="password" 
                   id="password"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('password') border-red-400 @enderror" 
                   placeholder="Minimal 8 karakter" 
                   required>
        </div>
        @error('password')
            <p class="text-xs text-red-600 mt-1 ml-1 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="space-y-2">
        <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 ml-1">
            Konfirmasi Password Baru
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <input type="password" 
                   name="password_confirmation" 
                   id="password_confirmation"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium" 
                   placeholder="Ketik ulang password baru" 
                   required>
        </div>
    </div>

    <!-- Password Strength Indicator -->
    <div class="space-y-2">
        <div class="flex justify-between items-center">
            <span class="text-xs font-medium text-neutral-600">Kekuatan Password:</span>
            <span class="text-xs font-medium text-primary-600" id="strength-text">Ketik password...</span>
        </div>
        <div class="flex space-x-1 h-1.5">
            <div class="flex-1 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-red-500 transition-all duration-300" id="strength-1" style="width: 0%"></div>
            </div>
            <div class="flex-1 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-yellow-500 transition-all duration-300" id="strength-2" style="width: 0%"></div>
            </div>
            <div class="flex-1 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 transition-all duration-300" id="strength-3" style="width: 0%"></div>
            </div>
        </div>
        <ul class="text-xs text-neutral-500 space-y-1 mt-2">
            <li class="flex items-center space-x-1" id="check-length">
                <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Minimal 8 karakter</span>
            </li>
            <li class="flex items-center space-x-1" id="check-number">
                <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Mengandung angka</span>
            </li>
            <li class="flex items-center space-x-1" id="check-uppercase">
                <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Mengandung huruf besar</span>
            </li>
        </ul>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-4 bg-gradient-to-r from-primary-600 to-primary-500 text-white font-extrabold rounded-2xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide">
        Reset Password
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
@endsection

@push('scripts')
<script>
    const password = document.getElementById('password');
    const strength1 = document.getElementById('strength-1');
    const strength2 = document.getElementById('strength-2');
    const strength3 = document.getElementById('strength-3');
    const strengthText = document.getElementById('strength-text');
    
    const checkLength = document.getElementById('check-length');
    const checkNumber = document.getElementById('check-number');
    const checkUppercase = document.getElementById('check-uppercase');

    password.addEventListener('input', function() {
        const val = this.value;
        let strength = 0;
        
        // Check length
        if (val.length >= 8) {
            strength++;
            checkLength.classList.add('text-green-600');
            checkLength.querySelector('svg').classList.add('text-green-500');
        } else {
            checkLength.classList.remove('text-green-600');
            checkLength.querySelector('svg').classList.remove('text-green-500');
        }
        
        // Check number
        if (/\d/.test(val)) {
            strength++;
            checkNumber.classList.add('text-green-600');
            checkNumber.querySelector('svg').classList.add('text-green-500');
        } else {
            checkNumber.classList.remove('text-green-600');
            checkNumber.querySelector('svg').classList.remove('text-green-500');
        }
        
        // Check uppercase
        if (/[A-Z]/.test(val)) {
            strength++;
            checkUppercase.classList.add('text-green-600');
            checkUppercase.querySelector('svg').classList.add('text-green-500');
        } else {
            checkUppercase.classList.remove('text-green-600');
            checkUppercase.querySelector('svg').classList.remove('text-green-500');
        }
        
        // Update strength bars
        if (strength >= 1) {
            strength1.style.width = '100%';
        } else {
            strength1.style.width = '0%';
        }
        
        if (strength >= 2) {
            strength2.style.width = '100%';
        } else {
            strength2.style.width = '0%';
        }
        
        if (strength >= 3) {
            strength3.style.width = '100%';
        } else {
            strength3.style.width = '0%';
        }
        
        // Update text
        if (val.length === 0) {
            strengthText.textContent = 'Ketik password...';
        } else if (strength < 2) {
            strengthText.textContent = 'Lemah';
        } else if (strength < 3) {
            strengthText.textContent = 'Sedang';
        } else {
            strengthText.textContent = 'Kuat';
        }
    });
</script>
@endpush