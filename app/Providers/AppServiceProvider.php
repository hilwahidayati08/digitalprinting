<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot() 
{
    view()->composer('*', function ($view) {
        // Mengambil data dari table settings (baris pertama)
        $settings = \App\Models\Settings::first(); 
        $view->with('settings', $settings);

        // Logic antrian kamu yang sudah ada tetap di sini
        if (auth()->check() && auth()->user()->role == 'admin') {
            $view->with('countAntrian', \App\Models\Orders::where('status', 'paid')->count());
            $view->with('adminNotifs', \App\Models\Notification::where('is_read', false)->latest()->take(5)->get());
        }
    });

    Paginator::useTailwind();
}
}
