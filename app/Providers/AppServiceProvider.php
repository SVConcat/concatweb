<?php

namespace App\Providers;

use App\Models\BoardMember;
use App\Models\PreviousBoard;
use App\Policies\AboutUsPolicy;
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
        Gate::policy(BoardMember::class, AboutUsPolicy::class);
        Gate::policy(PreviousBoard::class, AboutUsPolicy::class);

    }
}
