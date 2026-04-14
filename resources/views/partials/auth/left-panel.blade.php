<div class="auth-left">
    {{-- Logo --}}
    <div class="auth-brand">
        <div class="auth-brand-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 3H18C19.1 3 20 3.9 20 5V19C20 20.1 19.1 21 18 21H6C4.9 21 4 20.1 4 19V5C4 3.9 4.9 3 6 3Z" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M9 7H15M9 11H15M9 15H12" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>
        <div>
            <span class="auth-brand-name">Digital Printing</span>
            <span class="auth-brand-sub">Admin Panel</span>
        </div>
    </div>

    {{-- Heading --}}
    <div class="auth-intro">
        <h1 class="auth-title">Selamat Datang!</h1>
        <p class="auth-subtitle">Masuk untuk melanjutkan ke dashboard Anda</p>
    </div>

    {{-- Alert --}}
    @if (session('status'))
        <div class="auth-alert auth-alert--success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="auth-alert auth-alert--error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/><path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="#" class="auth-form">
        @csrf

        {{-- Email / Username --}}
        <div class="auth-field">
            <label class="auth-label" for="email">Email atau Username</label>
            <div class="auth-input-wrap">
                <span class="auth-input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/></svg>
                </span>
                <input
                    id="email"
                    type="text"
                    name="email"
                    class="auth-input @error('email') is-error @enderror"
                    placeholder="Masukkan email atau username"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    autofocus
                />
            </div>
            @error('email')
                <span class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="auth-field">
            <label class="auth-label" for="password">Password</label>
            <div class="auth-input-wrap">
                <span class="auth-input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="auth-input @error('password') is-error @enderror"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                />
                <button type="button" class="auth-input-toggle" onclick="togglePassword()" aria-label="Tampilkan password">
                    <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
                </button>
            </div>
            @error('password')
                <span class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Remember & Forgot --}}
        <div class="auth-row">
            <label class="auth-check">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot">Lupa Password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Masuk
        </button>

        {{-- Divider --}}
        <div class="auth-divider">
            <span class="auth-divider-line"></span>
            <span class="auth-divider-text">atau</span>
            <span class="auth-divider-line"></span>
        </div>

        {{-- Google --}}
        <a href="#" class="auth-btn-google">
            <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Masuk dengan Google
        </a>
    </form>

    {{-- Footer --}}
    <div class="auth-form-footer">
        Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>';
    }
}
</script>
@endpush