<?php

namespace App\Providers\Filament;

use App\Filament\App\Resources\ActivityResource;
use App\Filament\App\Resources\ReportResource;
use App\Filament\App\Widgets\AreaWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->darkMode(false)
            ->brandName('Proyectos Instituto Sudcaliforniano de Cultura')
            ->path('app')
            ->sidebarCollapsibleOnDesktop()
            ->profile()
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Escritorio')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn(): string => Dashboard::getUrl()),
                    ...ReportResource::getNavigationItems(),
                    NavigationItem::make('Panel de control')
                        ->url(fn(): string => route('filament.administrador.pages.dashboard'))
                        ->visible(Gate::allows('isAdmin'))
                        ->icon('heroicon-o-table-cells')
                ]);
            })
            ->colors([
                'primary' => '#9F2241',
                'secundary' => '#BE9655',
                'tittle' => '#777777'
            ])
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                AreaWidget::class,
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
