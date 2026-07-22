<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified', 'role:admin|superadmin'])->group(function () {

    Route::get('/cadastraAuto', [VeiculoController::class, 'create'])
        ->name('cadastraAuto');

    Route::post('/cadastraAuto', [VeiculoController::class, 'store'])
        ->name('veiculo.store');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
