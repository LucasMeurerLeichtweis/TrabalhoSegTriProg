<a
    href="{{ route('editVeiculo', $veiculo->id) }}"
    class="block bg-white rounded-xl shadow border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition"
>

@php
    $imagemPrincipal = $veiculo->imagens->firstWhere('principal', true);
    $cambios = [
        1 => 'Manual',
        2 => 'Automático',
        3 => 'CVT',
        4 => 'Semi-automático',
    ];

    $cambio = $cambios[$veiculo->cambio] ?? 'Não informado';
@endphp

<div class="px-4 py-2">
    <h3 class="text-lg font-semibold flex justify-between gap-2 text-black">
            <span>Tipo: {{$veiculo->fipe->tipo}}</span>
            <span>Câmbio: {{$cambio}}</span>
    </h3>
</div>

    <div class="px-4 py-2 flex flex-row items-center">

        <div style="width: 60%">
        <div class="relative overflow-hidden whitespace-nowrap">

            <h3 class="text-lg font-semibold">
                {{ $veiculo->fipe->modelo_descricao }}
            </h3>

            <div class="absolute right-0 top-0 h-full w-16
                        bg-gradient-to-l from-white to-transparent">
            </div>

        </div>

        <h3 class="text-sm font-semibold">
            {{$veiculo->fipe->marca_descricao}}
        </h3>


        <div class="flex items-center gap-2 text-sm text-gray-500">

        </div>

        <div class="mt-3 text-xl">
            Valor de venda:<span class="font-bold"> R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</span>
        </div>

        <div class="mt-3 text-xl">
            Placa:<span class="font-bold"> {{$veiculo->placa}}</span>
        </div>

        <div class="mt-3 text-xl">
            Renavam:<span class="font-bold"> {{$veiculo->renavam}}</span>
        </div>

        <div class="mt-4 flex justify-start text-sm text-gray-600 gap-3">
            <span
                class="inline-block w-8 h-6 rounded-full border border-gray-300"
                style="background-color: {{ $veiculo->cor }}"
                title="Cor do veículo"
            ></span>
            <span>•</span>
            <span>{{ number_format($veiculo->quilometragem, 0, ',', '.') }} km</span>

            <span>•</span>
            <span>{{ $veiculo->fipe->ano_modelo }}</span>
            </div>

        </div>
        <div class="w-[40%] h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                @if ($imagemPrincipal)
                    <img
                        src="{{ $imagemPrincipal->url }}"
                        alt="{{ $veiculo->fipe->modelo_descricao }}"
                        class="w-full h-full object-cover"
                    >
                @endif
            </div>

    </div>

</a>
