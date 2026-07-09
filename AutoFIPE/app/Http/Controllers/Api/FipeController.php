<?php

namespace App\Http\Controllers;

use App\Models\FipeVeiculo;
use app\Services\FipeService;

class FipeController extends Controller
{
   public function __construct(
        private FipeService $fipeService
    ) {
    }
}
