@extends('admin.auth')

@section('title', 'Lupa Password - Digital Printing')

@section('content')
<div class="text-center">
    <div class="mb-8 flex justify-center">
        @include('partials.auth.logo')
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
            Lupa Password? 🔐
        </h2>
        <p class="text-neutral-500 text-sm mt-2 font-medium">
            Masukkan email Anda untuk menerima kode OTP
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

<form action="{{ route('password.email') }}" method="POST" class="space-y-6">
    @csrf

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
                   class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('useremail') border-red-400 @enderror" 
                   placeholder="nama@email.com" 
                   required 
                   autofocus>
        </div>
        @error('useremail')
            <p class="text-xs text-red-600 mt-1 ml-1 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Info Box -->
    <div class="bg-primary-50 p-5 rounded-2xl border-2 border-primary-100">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-sm text-primary-700">
                <p class="font-semibold mb-1">📧 Cara kerja reset password:</p>
                <ul class="list-disc list-inside space-y-1 text-primary-600">
                    <li>Masukkan email terdaftar Anda</li>
                    <li>Kami akan kirim kode OTP 6 digit</li>
                    <li>Kode berlaku selama 15 menit</li>
                    <li>Gunakan kode untuk membuat password baru</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-4 bg-gradient-to-r from-primary-600 to-primary-500 text-white font-extrabold rounded-2xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide flex items-center justify-center space-x-2 group">
        <span>Kirim Kode OTP</span>
        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
    </button>

    <!-- Back to Login -->
    <div class="text-center pt-4">
        <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 text-sm text-primary-600 hover:text-primary-700 font-semibold group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke halaman login</span>
        </a>
    </div>
</form>

<!-- Security Badge -->
<div class="mt-8 flex items-center justify-center space-x-2 text-xs text-neutral-400">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
    </svg>
    <span>Data Anda aman & terenkripsi</span>
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
    // Add active class to input on focus
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.space-y-2')?.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.closest('.space-y-2')?.classList.remove('focused');
        });
    });
</script>
@endpush