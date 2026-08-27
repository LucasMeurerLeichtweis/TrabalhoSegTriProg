<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\FipeVeiculo;
use App\Models\ImagemVeiculo;
use App\Services\CloudinaryService;
use App\Services\FipeService;

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
        $valorFipe = $this->converterMoeda(
            $request->valor_fipe
        );

        $valorCompra = $this->converterMoeda(
            $request->valor_compra
        );

        $valorVenda = $this->converterMoeda(
            $request->valor_venda
        );

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

    public function getVeiculos(){
    $veiculos = Veiculo::with(['fipe', 'imagens'])->get();

    return view('layouts.boxVeiculo', compact('veiculos'));
    }


    public function index(FipeService $fipeService)
    {
        $veiculos = Veiculo::with(['fipe', 'imagens'])
            ->where('ativo', true)
            ->latest()
            ->paginate(9);

        foreach ($veiculos as $veiculo) {

            if ($veiculo->fipe) {

                $marca = $fipeService->marcaPorCodigo(
                    $veiculo->fipe->tipo,
                    $veiculo->fipe->marca
                );

                $modelo = $fipeService->modeloPorCodigo(
                    $veiculo->fipe->tipo,
                    $veiculo->fipe->marca,
                    $veiculo->fipe->modelo
                );

                $veiculo->fipe->marca_descricao =
                    $marca['name'] ?? 'Marca não encontrada';

                $veiculo->fipe->modelo_descricao =
                    $modelo['name'] ?? 'Modelo não encontrado';
            }
        }

        return view('dashboard', compact('veiculos'));
    }

    public function indexlist(FipeService $fipeService)
    {
        $veiculos = Veiculo::with(['fipe', 'imagens'])
            ->latest()
            ->paginate(9);

        foreach ($veiculos as $veiculo) {

            if ($veiculo->fipe) {

                $marca = $fipeService->marcaPorCodigo(
                    $veiculo->fipe->tipo,
                    $veiculo->fipe->marca
                );

                $modelo = $fipeService->modeloPorCodigo(
                    $veiculo->fipe->tipo,
                    $veiculo->fipe->marca,
                    $veiculo->fipe->modelo
                );

                $veiculo->fipe->marca_descricao =
                    $marca['name'] ?? 'Marca não encontrada';

                $veiculo->fipe->modelo_descricao =
                    $modelo['name'] ?? 'Modelo não encontrado';
            }
        }

        return view('listaVeiculos', compact('veiculos'));
    }

    public function show(Veiculo $veiculo, FipeService $fipeService)
    {
        $veiculo->load(['fipe', 'imagens']);


        $fipe = $veiculo->fipe;

        $marca = $fipeService->marcaPorCodigo(
            $fipe->tipo,
            $fipe->marca
        );

        $modelo = $fipeService->modeloPorCodigo(
            $fipe->tipo,
            $fipe->marca,
            $fipe->modelo
        );

        return view('veiculos', compact(
            'veiculo',
            'marca',
            'modelo'
        ));
    }

    public function update(
    Request $request,
    Veiculo $veiculo,
    CloudinaryService $cloudinary
) {
    $dados = $request->validate(
        [
            'placa' => [
                'required',
                'string',
                'max:8',
                'unique:veiculos,placa,' . $veiculo->id,
            ],

            'renavam' => [
                'required',
                'string',
                'unique:veiculos,renavam,' . $veiculo->id,
            ],

            'cor' => 'nullable|string|max:20',

            'cambio' => 'required|string|max:20',

            'quilometragem' => 'nullable|numeric',

            'descricao' => 'nullable|string',

            'valor_compra' => 'nullable|string',

            'valor_venda' => 'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | Novas imagens
            |--------------------------------------------------------------------------
            */

            'imagens' => 'nullable|array',

            'imagens.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Imagens excluídas
            |--------------------------------------------------------------------------
            */

            'imagens_excluidas' => 'nullable|array',

            'imagens_excluidas.*' => [
                'integer',
            ],

            /*
            |--------------------------------------------------------------------------
            | Ordem das imagens existentes
            |--------------------------------------------------------------------------
            */

            'ordem_imagens' => 'nullable|array',

            'ordem_imagens.*' => [
                'integer',
            ],
        ],
        [
            'placa.unique' =>
                'Já existe outro veículo cadastrado com esta placa.',

            'renavam.unique' =>
                'Já existe outro veículo cadastrado com este RENAVAM.',

            'placa.required' =>
                'Informe a placa.',

            'renavam.required' =>
                'Informe o RENAVAM.',

            'cambio.required' =>
                'Informe o tipo de câmbio.',

            'imagens.*.image' =>
                'Todos os arquivos devem ser imagens.',

            'imagens.*.mimes' =>
                'As imagens devem estar nos formatos JPG, JPEG, PNG ou WEBP.',

            'imagens.*.max' =>
                'Cada imagem pode ter no máximo 5 MB.',
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Conversão dos valores
    |--------------------------------------------------------------------------
    */

    $dados['valor_compra'] =
        $this->converterMoeda(
            $dados['valor_compra'] ?? null
        );

    $dados['valor_venda'] =
        $this->converterMoeda(
            $dados['valor_venda'] ?? null
        );


    /*
    |--------------------------------------------------------------------------
    | Atualiza os dados do veículo
    |--------------------------------------------------------------------------
    */

    $veiculo->update(
        collect($dados)->except([
            'imagens',
            'imagens_excluidas',
            'ordem_imagens',
        ])->toArray()
    );


    /*
    |--------------------------------------------------------------------------
    | Excluir imagens removidas
    |--------------------------------------------------------------------------
    */

    if ($request->filled('imagens_excluidas')) {

        $imagensExcluir =
            $veiculo->imagens()
                ->whereIn(
                    'id',
                    $request->imagens_excluidas
                )
                ->get();

        foreach ($imagensExcluir as $imagem) {

            /*
            |--------------------------------------------------------------------------
            | Remove do Cloudinary
            |--------------------------------------------------------------------------
            */

            if ($imagem->public_id) {

                $cloudinary->destroy(
                    $imagem->public_id
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Remove do banco
            |--------------------------------------------------------------------------
            */

            $imagem->delete();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Atualizar ordem e imagem principal
    |--------------------------------------------------------------------------
    */

    if ($request->filled('ordem_imagens')) {

        /*
        | Remove a principal atual
        */

        $veiculo->imagens()->update([
            'principal' => false,
        ]);


        /*
        | A primeira imagem da lista será a principal
        */

        foreach (
            $request->ordem_imagens
            as $index => $imagemId
        ) {

            $imagem =
                $veiculo->imagens()
                    ->where(
                        'id',
                        $imagemId
                    )
                    ->first();

            if ($imagem) {

                $imagem->update([
                    'principal' => $index === 0,
                ]);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Upload das novas imagens
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('imagens')) {

        $possuiPrincipal =
            $veiculo->imagens()
                ->where(
                    'principal',
                    true
                )
                ->exists();


        foreach (
            $request->file('imagens')
            as $index => $arquivo
        ) {

            $dadosImagem =
                $cloudinary->upload(
                    $arquivo
                );


            ImagemVeiculo::create([
                'veiculo_id' =>
                    $veiculo->id,

                'url' =>
                    $dadosImagem['url'],

                'public_id' =>
                    $dadosImagem['public_id'],

                /*
                | Se não existir nenhuma imagem
                | principal, a primeira nova vira principal
                */

                'principal' =>
                    !$possuiPrincipal && $index === 0,
            ]);


            $possuiPrincipal = true;
        }
    }


    return redirect()
        ->route('listaVeiculos')
        ->with(
            'success',
            'Veículo atualizado com sucesso!'
        );
}


        private function converterMoeda($valor): ?float
        {
            if ($valor === null || $valor === '') {
                return null;
            }

            $valor = trim($valor);

            // Remove R$ e espaços
            $valor = str_replace(['R$', ' '], '', $valor);

            // Formato brasileiro: 110.000,50
            if (str_contains($valor, ',')) {
                $valor = str_replace('.', '', $valor);
                $valor = str_replace(',', '.', $valor);
            }

            return (float) $valor;
        }
    public function edit(Veiculo $veiculo, FipeService $fipeService)
    {
        $veiculo->load(['fipe', 'imagens']);

        $fipe = $veiculo->fipe;

        $marca = $fipeService->marcaPorCodigo(
            $fipe->tipo,
            $fipe->marca
        );

        $modelo = $fipeService->modeloPorCodigo(
            $fipe->tipo,
            $fipe->marca,
            $fipe->modelo
        );
        $veiculo->fipe->marca_descricao =
            $marca['name'] ?? 'Marca não encontrada';

        $veiculo->fipe->modelo_descricao =
            $modelo['name'] ?? 'Modelo não encontrado';

        return view('editVeiculo', compact(
            'veiculo',
            'marca',
            'modelo'
        ));
    }
    public function vendido(Veiculo $veiculo)
    {
        $veiculo->update([
            'ativo' => false,
        ]);

        return redirect()
            ->route('listaVeiculos')
            ->with(
                'success',
                'Veículo marcado como vendido!'
            );
    }
    public function destroy(Veiculo $veiculo, CloudinaryService $cloudinary)
        {
        $veiculo->load('imagens');

        foreach ($veiculo->imagens as $imagem) {

            if ($imagem->public_id) {
                $cloudinary->destroy($imagem->public_id);
            }

            $imagem->delete();
        }

        $veiculo->delete();

        return redirect()
            ->route('listaVeiculos')
            ->with(
                'success',
                'Veículo excluído com sucesso!'
            );
    }

}
