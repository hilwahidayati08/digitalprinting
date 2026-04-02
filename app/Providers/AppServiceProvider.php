<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
public function boot() {
    view()->composer('*', function ($view) {
        if (auth()->check() && auth()->user()->role == 'admin') {
            $view->with('countAntrian', \App\Models\Orders::where('status', 'paid')->count());
            $view->with('adminNotifs', \App\Models\Notification::where('is_read', false)->latest()->take(5)->get());
        }
    });

    
}
}
