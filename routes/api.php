<?php

use App\Http\Controllers\Api\FamilyController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\SpeciesController;
use Illuminate\Support\Facades\Route;

// Todas as rotas deste ficheiro têm o prefixo /api e o rate limiter "api" (AppServiceProvider).
Route::name('api.')->group(function () {
    // Públicas: o catálogo, só de leitura.
    Route::get('species', [SpeciesController::class, 'index'])->name('species.index');
    Route::get('species/{species:slug}', [SpeciesController::class, 'show'])->name('species.show');
    Route::get('families', FamilyController::class)->name('families.index');

    // Com token pessoal (Sanctum) que tenha a ability account:read.
    Route::middleware(['auth:sanctum', 'abilities:account:read'])->group(function () {
        Route::get('me', [MeController::class, 'show'])->name('me.show');
        Route::get('me/notifications', [MeController::class, 'notifications'])->name('me.notifications');
    });
});
