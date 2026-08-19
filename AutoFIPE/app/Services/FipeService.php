<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FipeService
{
    protected string $baseUrl = 'https://fipe.parallelum.com.br/api/v2';

    protected function tipoApi(string $tipo): string
    {
        return match ($tipo) {
            'carros' => 'cars',
            'motos' => 'motorcycles',
            'caminhoes' => 'trucks',
            default => $tipo,
        };
    }

    protected function request()
    {
        $request = Http::acceptJson();

        if ($token = config('services.fipe.token')) {
            $request = $request->withHeaders([
                'X-Subscription-Token' => $token,
            ]);
        }

        return $request;
    }

    /**
     * Lista as marcas.
     */
    public function marcas(string $tipo)
    {
        $tipo = $this->tipoApi($tipo);

        return $this->request()
            ->get("{$this->baseUrl}/{$tipo}/brands")
            ->json();
    }

    /**
     * Lista os modelos de uma marca.
     */
    public function modelos(string $tipo, string $marca)
    {
        $tipo = $this->tipoApi($tipo);

        return $this->request()
            ->get("{$this->baseUrl}/{$tipo}/brands/{$marca}/models")
            ->json();
    }

    /**
     * Lista os anos de um modelo.
     */
    public function anos(
        string $tipo,
        string $marca,
        string $modelo
    ) {
        $tipo = $this->tipoApi($tipo);

        return $this->request()
            ->get(
                "{$this->baseUrl}/{$tipo}/brands/{$marca}/models/{$modelo}/years"
            )
            ->json();
    }

    /**
     * Consulta o valor FIPE.
     */
    public function valor(
        string $tipo,
        string $marca,
        string $modelo,
        string $ano
    ) {
        $tipo = $this->tipoApi($tipo);

        return $this->request()
            ->get(
                "{$this->baseUrl}/{$tipo}/brands/{$marca}/models/{$modelo}/years/{$ano}"
            )
            ->json();
    }

    /**
     * Busca uma marca pelo código.
     */
    public function marcaPorCodigo(
        string $tipo,
        string $codigo
    ) {
        $marcas = $this->marcas($tipo);

        return collect($marcas)
            ->firstWhere('code', $codigo);
    }

    /**
     * Busca um modelo pelo código.
     */
    public function modeloPorCodigo(
        string $tipo,
        string $codigoMarca,
        string $codigoModelo
    ) {
        $modelos = $this->modelos($tipo, $codigoMarca);

        return collect($modelos)
            ->firstWhere('code', $codigoModelo);
    }
}
