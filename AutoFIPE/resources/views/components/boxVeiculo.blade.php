<a
    href="{{ route('veiculos.show', $veiculo->id) }}"
    class="block bg-white rounded-xl shadow border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition"
>
<div class="bg-white rounded-xl shadow border overflow-hidden hover:shadow-lg transition">

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

<div class="p-4">
    <h3 class="text-lg font-semibold flex justify-between gap-2 text-black">
            <span>Tipo: {{$veiculo->fipe->tipo}}</span>
            <span>Câmbio: {{$cambio}}</span>
    </h3>
</div>
<div class="h-52 bg-gray-100">
    @if ($imagemPrincipal)
        <img
            src="{{ $imagemPrincipal->url }}"
            alt="{{ $veiculo->fipe->modelo_descricao }}"
            class="w-full h-full object-cover"
        >
    @endif
</div>

    <div class="p-4">


        <h3 class="text-lg font-semibold">
            {{$veiculo->fipe->modelo_descricao}}
        </h3>

        <h3 class="text-sm font-semibold">
            {{$veiculo->fipe->marca_descricao}}
        </h3>


        <div class="flex items-center gap-2 text-sm text-gray-500">
            <span
                class="inline-block w-4 h-4 rounded-full border border-gray-300"
                style="background-color: {{ $veiculo->cor }}"
                title="Cor do veículo"
            ></span>

            <span> • {{ $veiculo->fipe->ano_modelo }}</span>
        </div>

        <div class="mt-3 font-bold text-xl">
            R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}
        </div>

        <div class="mt-4 flex justify-between text-sm text-gray-600">
            <span>{{ number_format($veiculo->quilometragem, 0, ',', '.') }} km</span>
        </div>
    </div>

</div>
</a>
