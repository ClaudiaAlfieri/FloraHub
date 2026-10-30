<?php

namespace App\Providers;

use App\Services\Gbif\GbifClient;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;
use Spatie\Permission\Middleware\RoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GbifClient::class, fn (): GbifClient => new GbifClient(
            baseUrl: (string) config('services.gbif.base_url'),
            timeout: (int) config('services.gbif.timeout'),
            cacheTtl: (int) config('services.gbif.cache_ttl'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureLivewire();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }

    /**
     * Re-apply the role middleware to every Livewire request made from a protected page.
     */
    protected function configureLivewire(): void
    {
        Livewire::addPersistentMiddleware([
            RoleMiddleware::class,
        ]);
    }
}
