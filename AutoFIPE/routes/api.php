<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/api/fipe/marcas/{tipo}', [FipeController::class,'marcas']);

Route::get('/api/fipe/modelos/{tipo}/{marca}',
    [FipeController::class,'modelos']);

Route::get('/api/fipe/anos/{tipo}/{marca}/{modelo}',
    [FipeController::class,'anos']);

Route::get('/api/fipe/detalhes/{codigo}',
    [FipeController::class,'detalhes']);
