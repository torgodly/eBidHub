<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AdminChartOverview;
use App\Filament\Widgets\AdminStatsOverview;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use RickDBCN\FilamentEmail\FilamentEmail;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->darkMode(false)
            ->defaultThemeMode(ThemeMode::Light)
            ->plugin(new FilamentEmail())
            ->plugin(BreezyCore::make()->myProfile(
                shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                hasAvatars: true, // Enables the avatar upload form component (default = false)
                slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
            )->enableTwoFactorAuthentication())
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('2rem')
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => "#086bd6",
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
                AdminStatsOverview::class,
                AdminChartOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
