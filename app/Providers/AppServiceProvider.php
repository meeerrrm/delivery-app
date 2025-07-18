<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

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
        FilamentColor::register([
            'custom-danger' => Color::Rose,
            'custom-default' => Color::Neutral,
            'custom-info' => Color::Sky,
            'custom-primary' => Color::Blue,
            'custom-success' => Color::Lime,
            'custom-warning' => Color::Orange,
        ]);
    }
}
