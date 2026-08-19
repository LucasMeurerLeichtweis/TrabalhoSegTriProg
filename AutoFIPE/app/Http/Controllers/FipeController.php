<?php

namespace App\Http\Controllers;

use App\Services\FipeService;

class FipeController extends Controller
{
    public function __construct(
        protected FipeService $fipeService
    ) {
    }

    public function index()
    {
        return view('cadastraAuto');
    }

    public function tipos()
    {
        return response()->json([
            ['codigo' => 'carros', 'nome' => 'Carros'],
            ['codigo' => 'motos', 'nome' => 'Motos'],
            ['codigo' => 'caminhoes', 'nome' => 'Caminhões'],
        ]);
    }

    public function marcas(string $tipo)
    {
        return response()->json(
            $this->fipeService->marcas($tipo)
        );
    }

    public function modelos(string $tipo, string $marca)
    {
        return response()->json(
            $this->fipeService->modelos($tipo, $marca)
        );
    }

    public function anos(
        string $tipo,
        string $marca,
        string $modelo
    ) {
        return response()->json(
            $this->fipeService->anos(
                $tipo,
                $marca,
                $modelo
            )
        );
    }

    public function veiculo(
        string $tipo,
        string $marca,
        string $modelo,
        string $ano
    ) {
        return response()->json(
            $this->fipeService->valor(
                $tipo,
                $marca,
                $modelo,
                $ano
            )
        );
    }
}
