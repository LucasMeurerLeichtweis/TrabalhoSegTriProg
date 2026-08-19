<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeiculoController;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [VeiculoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/veiculos/{veiculo}', [VeiculoController::class, 'show'])
    ->name('veiculos');

Route::middleware(['auth', 'verified', 'role:admin|superadmin'])->group(function () {

    Route::get('/cadastraAuto', [VeiculoController::class, 'create'])
        ->name('cadastraAuto');

    Route::get('/boxVeiculo', [VeiculoController::class, 'getVeiculos'])
        ->name('veiculos.getVeiculos');

    Route::post('/cadastraAuto', [VeiculoController::class, 'store'])
        ->name('veiculo.store');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
