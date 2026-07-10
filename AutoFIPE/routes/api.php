<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FipeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tipos', [FipeController::class, 'tipos']);
Route::get('/marcas/{tipo}', [FipeController::class, 'marcas']);
Route::get('/modelos/{tipo}/{marca}', [FipeController::class, 'modelos']);
Route::get('/anos/{tipo}/{marca}/{modelo}', [FipeController::class, 'anos']);
