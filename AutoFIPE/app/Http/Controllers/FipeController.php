<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class FipeController extends Controller
{
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

    public function marcas($tipo)
    {
        return Http::get("https://parallelum.com.br/fipe/api/v1/$tipo/marcas")->json();
    }

    public function modelos($tipo, $marca)
    {
        return Http::get("https://parallelum.com.br/fipe/api/v1/$tipo/marcas/$marca/modelos")
            ->json()['modelos'];
    }

    public function anos($tipo, $marca, $modelo)
    {
        return Http::get("https://parallelum.com.br/fipe/api/v1/$tipo/marcas/$marca/modelos/$modelo/anos")
            ->json();
    }
}
