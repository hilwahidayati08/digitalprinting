@extends('admin.auth')

@section('title', 'Login Admin - Digital Printing')

@section('content')
<div class="max-w-md mx-auto py-10 px-4 animate-fade-in-up">
    
    <div class="text-center">
        <div class="mb-8 flex justify-center transform hover:scale-105 transition-transform duration-300">
            @include('partials.auth.logo')
        </div>

        <div class="mb-8">
            <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
                Welcome Back!
            </h2>
            <p class="text-neutral-500 text-sm mt-2 font-medium">
                Masuk untuk mengelola semua proyek cetak Anda
            </p>
        </div>
    </div>

    @include('partials.auth.alert')

    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
        @csrf

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
                <input type="email" name="useremail" id="useremail" value="{{ old('useremail') }}"
                    class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('useremail') border-danger-light @enderror" 
                    placeholder="admin@digiprint.com" required autofocus>
            </div>
            @error('useremail')
                <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

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
                <input type="password" name="password" id="password"
                    class="w-full pl-12 pr-4 py-4 bg-neutral-50/50 border-2 border-neutral-200 rounded-2xl text-sm outline-none focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-neutral-400 font-medium @error('password') border-danger-light @enderror" 
                    placeholder="••••••••" required>
            </div>
            @error('password')
                <p class="text-xs text-danger-dark mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between px-1">
            <label class="flex items-center cursor-pointer group">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded-lg border-2 border-neutral-300 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 focus:ring-2 transition-all cursor-pointer">
                <span class="ml-2 text-xs font-semibold text-neutral-600 group-hover:text-primary-600 transition-colors">
                    Ingat Saya
                </span>
            </label>
            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors flex items-center space-x-1 group">
                <span>Lupa Password?</span>
                <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-primary text-white font-extrabold rounded-2xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide flex items-center justify-center space-x-2 group">
            <span>Sign In</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>

        <div class="flex items-center justify-center space-x-2 text-xs text-neutral-400 pt-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Koneksi aman & terenkripsi</span>
        </div>
    </form>

    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-neutral-200"></div></div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-neutral-400 font-semibold uppercase text-[10px] tracking-widest">Atau masuk dengan</span>
        </div>
    </div>

    <a href="{{ route('google.login') }}" class="w-full py-4 bg-white border-2 border-neutral-200 text-neutral-700 font-bold rounded-2xl shadow-sm hover:bg-neutral-50 hover:border-neutral-300 transform hover:-translate-y-0.5 transition-all duration-200 text-sm flex items-center justify-center space-x-3">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5" alt="Google">
        <span>Google Account</span>
    </a>

    <div id="g_id_onload" data-client_id="{{ env('GOOGLE_CLIENT_ID') }}" data-login_uri="{{ route('google.login') }}" data-auto_prompt="true"></div>

    <div class="mt-10 text-center pt-8 border-t-2 border-neutral-100">
        <p class="text-sm text-neutral-500 font-medium">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-primary-600 font-bold hover:text-primary-700 hover:underline underline-offset-4 decoration-2 decoration-primary-500/30 transition-all">
                Buat Akun Baru
            </a>
        </p>
    </div>

    <div class="mt-6 flex justify-center space-x-6">
        <div class="flex items-center space-x-1.5 text-[10px] text-neutral-400 font-medium uppercase tracking-tighter">
            <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
            <span>24/7 Support</span>
        </div>
        <div class="flex items-center space-x-1.5 text-[10px] text-neutral-400 font-medium uppercase tracking-tighter">
            <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
            <span>SSL Secure</span>
        </div>
        <div class="flex items-center space-x-1.5 text-[10px] text-neutral-400 font-medium uppercase tracking-tighter">
            <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
            <span>Data Protection</span>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
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
</style>
@endpush

@push('scripts')
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
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