<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\FipeVeiculo;
use App\Models\ImagemVeiculo;
use App\Services\CloudinaryService;

class VeiculoController extends Controller
{
     public function create()
    {
        return view('cadastraAuto');
    }

    public function store(Request $request, CloudinaryService $cloudinary)
    {

        $request->validate(
            [
                'placa' => 'required|string|max:8|unique:veiculos,placa',
                'renavam' => 'required|string|unique:veiculos,renavam',
                'imagens.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
                'cambio' => 'required|string|max:20',
            ],
            [
                'placa.unique' => 'Já existe um veículo cadastrado com esta placa.',
                'renavam.unique' => 'Já existe um veículo cadastrado com este RENAVAM.',
                'placa.required' => 'Informe a placa.',
                'renavam.required' => 'Informe o RENAVAM.',
                'cambio.required' => 'Informe o tipo de câmbio.',
            ]
        );

        $fipe = FipeVeiculo::firstOrCreate(
            [
                'codigo_fipe' => $request->codigo_fipe,
            ],
            [
                'tipo' => $request->tipo,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'ano_modelo' => $request->ano_modelo,
                'combustivel' => $request->combustivel,
            ]
        );
        $valorFipe = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor_fipe);
        $valorCompra = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor_compra);
        $valorVenda = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor_venda);

        $veiculo = Veiculo::create([
            'fipe_veiculo_id' => $fipe->id,
            'placa' => $request->placa,
            'renavam' => $request->renavam,
            'cor' => $request->cor,
            'cambio' => $request->cambio,
            'quilometragem' => $request->quilometragem,
            'valor_compra' => $valorCompra,
            'valor_venda' => $valorVenda,
            'valor_fipe' => $valorFipe,
            'mes_referencia' => $request->mes_referencia,
            'descricao' => $request->descricao,
            'ativo' => true,
        ]);



        if ($request->hasFile('imagens')) {

            foreach ($request->file('imagens') as $index => $imagem) {

                $dadosImagem = $cloudinary->upload($imagem);

                ImagemVeiculo::create([
                    'veiculo_id' => $veiculo->id,
                    'url' => $dadosImagem['url'],
                    'public_id' => $dadosImagem['public_id'],
                    'principal' => $index === 0,
                ]);
            }
        }

        return redirect()
            ->route('cadastraAuto')
            ->with('success', 'Veículo cadastrado com sucesso!');

    }
}
