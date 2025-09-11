<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


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
        Gate::policy(\App\Models\BoardMember::class, \App\Policies\AboutUsPolicy::class);
        Gate::policy(\App\Models\PreviousBoard::class, \App\Policies\AboutUsPolicy::class);
    
    }
}
