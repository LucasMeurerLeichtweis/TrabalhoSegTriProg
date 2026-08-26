<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
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

    Route::get('/editAuto', [VeiculoController::class, 'index'])
        ->name('veiculos.index');

    Route::get('/veiculos/{veiculo}/editar', [VeiculoController::class, 'edit'])
        ->name('editVeiculo');

    Route::put('/veiculos/{veiculo}', [VeiculoController::class, 'update'])
        ->name('updateVeiculo');

    Route::get('/listaVeiculos', [VeiculoController::class, 'indexlist'])
        ->name('listaVeiculos');

    Route::patch('/veiculos/{veiculo}/vendido',[VeiculoController::class, 'vendido'])
        ->name('veiculo.vendido');
        
    Route::delete('/veiculos/{veiculo}',[VeiculoController::class, 'destroy'])
        ->name('veiculo.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])
        ->name('usuarios.index');

    Route::put('/usuarios/{usuario}/role', [UserController::class, 'updateRole'])
        ->name('usuarios.updateRole');

    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])
        ->name('usuarios.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
