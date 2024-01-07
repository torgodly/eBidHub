<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en'])->visible(true,true)->outsidePanelRoutes([
                    'admin',
                    'seller',
                    // Additional custom routes where the switcher should be visible outside panels
                ])->outsidePanelPlacement(Placement::BottomRight); // also accepts a closure
        });
    }
}
