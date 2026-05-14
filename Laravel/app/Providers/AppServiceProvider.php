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
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('components.toast-container', function ($view) {
            try {
                $expiring = \App\Models\Product::whereBetween('expires_at', [now(), now()->addDays(7)])->get();
                $expired  = \App\Models\Product::where('expires_at', '<', now())->get();

                $toasts = collect()
                    ->merge($expired->map(fn($p) => ['type' => 'expired',  'message' => "{$p->name} venceu em " . \Carbon\Carbon::parse($p->expires_at)->format('d/m/Y')]))
                    ->merge($expiring->map(fn($p) => ['type' => 'expiring', 'message' => "{$p->name} — vence em " . \Carbon\Carbon::parse($p->expires_at)->diffForHumans()]));

                $view->with('toasts', $toasts);
            } catch (\Exception $e) {
                $view->with('toasts', collect());
            }
        });

        \Illuminate\Support\Facades\View::composer('components.navbar', function ($view) {
            $view->with('notifications', collect());
            $view->with('unreadCount', 0);
        });
    }
}
