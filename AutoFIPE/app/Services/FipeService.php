<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FipeService
{
    protected string $baseUrl = 'https://parallelum.com.br/fipe/api/v1';

    public function marcas(string $tipo)
    {
        return Http::get("{$this->baseUrl}/{$tipo}/marcas")->json();
    }

    public function modelos(string $tipo, int $marca)
    {
        return Http::get("{$this->baseUrl}/{$tipo}/marcas/{$marca}/modelos")->json();
    }

    public function anos(string $tipo, int $marca, int $modelo)
    {
        return Http::get("{$this->baseUrl}/{$tipo}/marcas/{$marca}/modelos/{$modelo}/anos")->json();
    }

    public function valor(string $tipo, int $marca, int $modelo, string $ano)
    {
        return Http::get("{$this->baseUrl}/{$tipo}/marcas/{$marca}/modelos/{$modelo}/anos/{$ano}")->json();
    }
}
