<?php

use App\Http\Controllers\Dev\QuickLoginController;
use App\Models\Family;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Início de sessão rápido: apenas em desenvolvimento (APP_ENV=local)
Route::post('dev/login/{role}', QuickLoginController::class)
    ->middleware('guest')
    ->whereIn('role', ['admin', 'user'])
    ->name('dev.login');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::view('dashboard', 'user.dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard', [
                'familiesCount' => Family::count(),
            ]);
        })->name('dashboard');

        Route::livewire('families', 'pages::admin.families')
            ->can('viewAny', Family::class)
            ->name('families.index');
    });

// Páginas de testes (guias 03.1 a 03.4): apenas em desenvolvimento (APP_ENV=local)
if (app()->isLocal()) {
    Route::prefix('dev')->name('dev.')->group(function () {
        Route::view('tailwind', 'dev.tailwind')->name('tailwind');
        Route::view('components', 'dev.components')->name('components');
        Route::livewire('livewire', 'pages::dev.livewire')->name('livewire');
        Route::livewire('flux', 'pages::dev.flux')->name('flux');
    });
}

require __DIR__.'/settings.php';
