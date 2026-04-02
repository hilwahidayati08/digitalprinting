@extends('admin.auth')

@section('title', 'Register Admin - Digital Printing')

@section('content')
<div class="text-center">
    <div class="mb-8 flex justify-center">
        @include('partials.auth.logo')
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
            Create Account
        </h2>
        <p class="text-neutral-500 text-sm mt-2 font-medium">
            Daftar untuk memulai proyek cetak Anda
        </p>
    </div>
</div>

@include('partials.auth.alert')

<form action="{{ route('register.post') }}" method="POST" class="space-y-6">
    @csrf

    <!-- Name Field -->
    <div class="space-y-2">
        <label for="name" class="block text-sm font-semibold text-neutral-700 ml-1">
            Username
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <input type="text" 
                   name="username" 
                   id="name"
                   value="{{ old('username') }}"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('name') border-danger-light @enderror" 
                   placeholder="John Doe" 
                   required 
                   autofocus>
        </div>
        @error('username')
            <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div class="space-y-2">
        <label for="useremail" class="block text-sm font-semibold text-neutral-700 ml-1">
            Email Address
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
            </div>
            <input type="email" 
                   name="useremail" 
                   id="useremail"
                   value="{{ old('useremail') }}"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('useremail') border-danger-light @enderror" 
                   placeholder="admin@digiprint.com" 
                   required>
        </div>
        @error('useremail')
            <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone Number Field (Optional) -->
    <div class="space-y-2">
        <label for="phone" class="block text-sm font-semibold text-neutral-700 ml-1">
            Phone Number <span class="text-neutral-400 font-normal">(Optional)</span>
        </label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <input type="tel" 
                   name="phone" 
                   id="phone"
                   value="{{ old('phone') }}"
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('phone') border-danger-light @enderror" 
                   placeholder="0812-3456-7890">
        </div>
        @error('phone')
            <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Field -->
    <div class="space-y-2">
        <label for="password" class="block text-sm font-semibold text-neutral-700 ml-1">
            Password
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
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('password') border-danger-light @enderror" 
                   placeholder="Minimal 8 karakter" 
                   required>
        </div>
        @error('password')
            <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password Field -->
    <div class="space-y-2">
        <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 ml-1">
            Confirm Password
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
                   placeholder="Konfirmasi password" 
                   required>
        </div>
    </div>

    <!-- Password Strength Indicator -->
    <div class="px-1">
        <div class="flex justify-between mb-1">
            <span class="text-xs font-medium text-neutral-600">Password Strength</span>
            <span class="text-xs font-medium text-neutral-400" id="password-strength-text">Minimal 8 karakter</span>
        </div>
        <div class="flex space-x-1">
            <div class="flex-1 h-1.5 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-danger-light transition-all duration-300" id="strength-1" style="width: 0%"></div>
            </div>
            <div class="flex-1 h-1.5 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-warning-light transition-all duration-300" id="strength-2" style="width: 0%"></div>
            </div>
            <div class="flex-1 h-1.5 bg-neutral-200 rounded-full overflow-hidden">
                <div class="h-full bg-success-light transition-all duration-300" id="strength-3" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="px-1">
        <label class="flex items-start cursor-pointer group">
            <input type="checkbox" 
                   name="terms" 
                   class="mt-0.5 w-4 h-4 rounded-lg border-2 border-neutral-300 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 focus:ring-2 transition-all cursor-pointer" 
                   required>
            <span class="ml-2 text-xs text-neutral-600 group-hover:text-primary-600 transition-colors">
                Saya setuju dengan 
                <a href="#" class="font-semibold text-primary-600 hover:text-primary-700">Syarat & Ketentuan</a> 
                dan 
                <a href="#" class="font-semibold text-primary-600 hover:text-primary-700">Kebijakan Privasi</a>
            </span>
        </label>
        @error('terms')
            <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-4 bg-gradient-primary text-white font-extrabold rounded-2xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide flex items-center justify-center space-x-2 group">
        <span>Create Account</span>
        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
    </button>

    <!-- Security Badge -->
    <div class="flex items-center justify-center space-x-2 text-xs text-neutral-400 pt-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        <span>Data Anda aman & terenkripsi</span>
    </div>
</form>

<!-- Login Link -->
<div class="mt-10 text-center pt-8 border-t-2 border-neutral-100">
    <p class="text-sm text-neutral-500 font-medium">
        Sudah punya akun? 
        <a href="{{ route('login') }}" 
           class="text-primary-600 font-bold hover:text-primary-700 hover:underline underline-offset-4 decoration-2 decoration-primary-500/30 transition-all">
            Masuk Sekarang
        </a>
    </p>
</div>

<!-- Benefits -->
<div class="mt-6 grid grid-cols-3 gap-2">
    <div class="text-center">
        <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-primary-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-[10px] font-medium text-neutral-600">Easy Order</p>
    </div>
    <div class="text-center">
        <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-primary-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-[10px] font-medium text-neutral-600">Fast Process</p>
    </div>
    <div class="text-center">
        <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-primary-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
        <p class="text-[10px] font-medium text-neutral-600">Secure Payment</p>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom animations */
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
    // Add active class to input on focus
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.space-y-2')?.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.closest('.space-y-2')?.classList.remove('focused');
        });
    });

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strength1 = document.getElementById('strength-1');
    const strength2 = document.getElementById('strength-2');
    const strength3 = document.getElementById('strength-3');
    const strengthText = document.getElementById('password-strength-text');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Check length
        if (password.length >= 8) strength++;
        if (password.length >= 10) strength++;
        
        // Check for numbers
        if (/\d/.test(password)) strength++;
        
        // Check for uppercase letters
        if (/[A-Z]/.test(password)) strength++;
        
        // Check for special characters
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
        
        // Update strength bars
        strength1.style.width = '0%';
        strength2.style.width = '0%';
        strength3.style.width = '0%';
        
        if (strength >= 2) strength1.style.width = '100%';
        if (strength >= 4) strength2.style.width = '100%';
        if (strength >= 6) strength3.style.width = '100%';
        
        // Update text
        if (strength < 2) {
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-xs font-medium text-danger-dark';
        } else if (strength < 4) {
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-xs font-medium text-warning-dark';
        } else if (strength < 6) {
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-xs font-medium text-success';
        } else {
            strengthText.textContent = 'Sangat Kuat';
            strengthText.className = 'text-xs font-medium text-success-dark';
        }
    });

    // Confirm password validation
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            this.classList.add('border-danger-light');
            this.classList.remove('border-neutral-200', 'focus:border-primary-500');
        } else {
            this.classList.remove('border-danger-light');
            this.classList.add('border-neutral-200', 'focus:border-primary-500');
        }
    });
</script>
@endpush