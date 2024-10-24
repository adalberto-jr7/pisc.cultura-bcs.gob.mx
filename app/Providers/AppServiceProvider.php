<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
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
    FilamentView::registerRenderHook(
      PanelsRenderHook::SIMPLE_PAGE_START,
      fn() => view('auth-header')
    );
    Gate::define('isAdmin', function (User $user) {
      return $user->isAdmin();
    });
  }
}
