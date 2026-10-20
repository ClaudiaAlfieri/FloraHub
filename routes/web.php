<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Páginas de demonstração dos templates (conteúdo estático, ainda sem autenticação)
Route::view('user/dashboard', 'user.dashboard')->name('user.dashboard');
Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
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
