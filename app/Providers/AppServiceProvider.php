<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Gbif\GbifClient;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->configureApi();
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

    /**
     * Configure who can manage API tokens and how many API requests can be made per minute.
     */
    protected function configureApi(): void
    {
        // Only users with the "user" role have personal API tokens: there is no model to write a policy for.
        Gate::define('manage-api-tokens', fn (User $user): bool => $user->hasRole('user'));

        RateLimiter::for('api', function (Request $request): Limit {
            return $request->user()
                ? Limit::perMinute(120)->by((string) $request->user()->id)
                : Limit::perMinute(60)->by((string) $request->ip());
        });
    }
}
