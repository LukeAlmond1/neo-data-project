<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NeoDataAnalysisController;
use App\Http\Controllers\NeoObjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/neo-analysis', [NeoDataAnalysisController::class, 'get']);
Route::get('/neo-objects/{neoObject}', [NeoObjectController::class, 'show']);

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
