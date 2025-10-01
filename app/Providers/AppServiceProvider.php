<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        //

       View::composer('*', function ($view) {
        $user = Auth::user();
        $showSubscriptionModal = false;

        if ($user && $user->hasActiveSubscription() && !$user->subscription_modal_shown) {
            $showSubscriptionModal = true;
        }

        $view->with('showSubscriptionModal', $showSubscriptionModal);
    });
    }
}
