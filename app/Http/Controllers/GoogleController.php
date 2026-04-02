<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Mengarahkan user ke halaman login Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan useremail (sesuai nama kolom di model kamu)
            $user = User::where('useremail', $googleUser->email)->first();

            if ($user) {
                // KASUS 1: User sudah terdaftar (mungkin lewat OTP sebelumnya)
                // Kita update google_id nya agar sinkron
                $user->update([
                    'google_id' => $googleUser->id,
                ]);

                Auth::login($user);
                return redirect()->intended('/dashboard'); // Sesuaikan rute setelah login

            } else {
                // KASUS 2: User benar-benar baru
                $newUser = User::create([
                    'username'  => $googleUser->name,
                    'useremail' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make(str()->random(24)), // Password random aman
                    'role'      => 'customer', // Default role di sistem kamu
                ]);

                Auth::login($newUser);
                return redirect()->intended('/dashboard');
            }

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Ada masalah saat login Google: ' . $e->getMessage());
        }
    }
}