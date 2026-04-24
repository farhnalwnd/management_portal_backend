<?php

namespace App\Providers;

use App\Http\Responses\SsoLogoutResponse;
use App\Models\ContentMgt;
use App\Observers\ContentMgtObserver;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, SsoLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Spatie\Activitylog\Models\Activity::observe(\App\Observers\ActivityObserver::class);
        // ContentMgt::observe(ContentMgtObserver::class);
    }
}
