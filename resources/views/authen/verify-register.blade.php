@extends('admin.auth')

@section('title', 'Verifikasi Akun - Digital Printing')

@section('content')

{{-- Logika untuk mengambil email dari session dan menyensornya (contoh: bu**@gmail.com) --}}
@php
    $sessionData = session('registrasi_sementara');
    $email = $sessionData['useremail'] ?? 'email@anda.com';
    
    // Logika sensor email sederhana
    $parts = explode('@', $email);
    $name = $parts[0];
    $domain = $parts[1] ?? '';
    $len = strlen($name);
    $showLen = floor($len / 2); 
    $hiddenEmail = substr($name, 0, $showLen) . str_repeat('*', $len - $showLen) . '@' . $domain;
@endphp

<div class="text-center">
    <div class="mb-8 flex justify-center">
        {{-- Pastikan file partial ini ada, jika error hapus baris ini --}}
        @include('partials.auth.logo') 
    </div>

    <div class="mb-6">
        <h2 class="text-3xl font-display font-bold text-neutral-800 tracking-tight">
            Verifikasi Email
        </h2>
        <p class="text-neutral-500 text-sm mt-2 font-medium">
            Masukkan 6 digit kode OTP yang telah kami kirim ke <br>
            <span class="font-bold text-primary-600 tracking-wide">{{ $hiddenEmail }}</span>
        </p>
    </div>

    {{-- Tampilkan Error Jika OTP Salah --}}
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 mb-6 font-medium animate-pulse">
            ⚠️ {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-xl p-3 mb-6 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif
</div>

{{-- FORM UTAMA --}}
<form action="{{ route('register.verify.process') }}" method="POST" class="space-y-6">
    @csrf

    <div class="space-y-2">
        <label for="otp_code" class="block text-sm font-semibold text-neutral-700 ml-1">
            Kode OTP (6 Angka)
        </label>
        <div class="relative group">
            <input type="text" 
                   name="otp_code" 
                   id="otp_code" 
                   maxlength="6" 
                   inputmode="numeric" 
                   class="w-full py-4 bg-white border-2 border-neutral-200 rounded-2xl text-center text-3xl tracking-[10px] focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-neutral-800 transition-all placeholder-neutral-300 @error('otp_code') border-red-500 text-red-600 @enderror" 
                   placeholder="------" 
                   required
                   autofocus
                   autocomplete="off">
        </div>
        @error('otp_code')
            <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 flex items-start gap-3">
        <div class="text-blue-500 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        </div>
        <p class="text-xs text-blue-700 leading-relaxed">
            Tidak menerima kode? Cek folder <b>Spam/Junk</b> atau pastikan email yang Anda masukkan benar.
        </p>
    </div>

    <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-600/20 transition-all transform active:scale-[0.98]">
        Verifikasi & Buat Akun
    </button>

    <div class="text-center pt-2">
        <p class="text-sm text-neutral-500">
            Salah alamat email? 
            {{-- Tombol ini akan menghapus session dan membolehkan user daftar ulang --}}
            <a href="{{ route('register') }}" class="text-primary-600 font-bold hover:underline hover:text-primary-700 transition-colors">
                Daftar Ulang
            </a>
        </p>
    </div>
</form>

{{-- Script Opsional: Biar input OTP otomatis angka saja --}}
<script>
    document.getElementById('otp_code').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

@endsection