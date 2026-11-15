<?php

namespace App\Providers;

use App\Models\Indikator;
use App\Policies\IndikatorAssignmentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        if (config('app.env') === 'production' || str_starts_with((string) config('app.url'), 'https://') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        // Daftarkan IndikatorAssignmentPolicy secara manual
        // karena user kita adalah JwtUser (bukan model Eloquent standar)
        Gate::policy(Indikator::class, IndikatorAssignmentPolicy::class);
    }
}
