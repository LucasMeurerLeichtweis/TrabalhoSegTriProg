<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center w-full justify-center gap-4">
            <h2
                class="text-xl font-semibold text-white"
                style="font-size: 40px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif"
            >
                {{ __('Detalhes do Veículo') }}
            </h2>
        </div>
    </x-slot>

    @php
        $imagemPrincipal = $veiculo->imagens->firstWhere('principal', true);

        $cambios = [
            1 => 'Manual',
            2 => 'Automático',
            3 => 'CVT',
            4 => 'Semi-automático',
        ];

        $cambio = $cambios[$veiculo->cambio] ?? 'Não informado';

        $nomeMarca = $marca['name'] ?? 'Marca não encontrada';
        $nomeModelo = $modelo['name'] ?? 'Modelo não encontrado';
    @endphp

    <div class="py-12">
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            style="padding-bottom: 55px;"
        >

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Botão voltar --}}
                <div class="mb-6">
                    <a
                        href="{{ route('dashboard') }}"
                        class="text-gray-600 hover:text-gray-900 font-semibold"
                    >
                        ← Voltar para os veículos
                    </a>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <div
                        x-data="{
                            imagens: @js($veiculo->imagens->values()->pluck('url')),
                            atual: 0,

                            proxima() {
                                this.atual = (this.atual + 1) % this.imagens.length;
                            },

                            anterior() {
                                this.atual =
                                    (this.atual - 1 + this.imagens.length) % this.imagens.length;
                            }
                        }"
                        class="w-full"
                    >
                        {{-- IMAGEM PRINCIPAL --}}
                        <div class="relative flex justify-center">

                            <div class="relative w-full overflow-hidden">

                                <template x-if="imagens.length > 0">
                                    <img
                                        :src="imagens[atual]"
                                        alt="Imagem do veículo"
                                        class="w-full h-[440px] object-contain"
                                    >
                                </template>

                                <template x-if="imagens.length === 0">
                                    <div
                                        class="w-full h-[440px] flex items-center justify-center text-gray-400 bg-gray-100"
                                    >
                                        Nenhuma imagem disponível
                                    </div>
                                </template>

                                {{-- SETA ANTERIOR --}}
                                <button
                                    x-show="imagens.length > 1"
                                    @click="anterior()"
                                    type="button"
                                    class="absolute left-4 top-1/2 -translate-y-1/2
                                        text-red-600 text-6xl font-light
                                        hover:scale-110 transition"
                                >
                                    ‹
                                </button>

                                {{-- SETA PRÓXIMA --}}
                                <button
                                    x-show="imagens.length > 1"
                                    @click="proxima()"
                                    type="button"
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        text-red-600 text-6xl font-light
                                        hover:scale-110 transition"
                                >
                                    ›
                                </button>

                            </div>

                        </div>


                        {{-- PREVIEWS --}}
                        <div
                            x-show="imagens.length > 1"
                            class="flex justify-start gap-3 mt-5 overflow-x-auto px-4 pb-2"
                        >

                            <template
                                x-for="(imagem, index) in imagens"
                                :key="index"
                            >

                                <button
                                    type="button"
                                    @click="atual = index"
                                    class="shrink-0 overflow-hidden transition"
                                    :class="
                                        atual === index
                                            ? 'opacity-100 ring-2 ring-red-600'
                                            : 'opacity-70 hover:opacity-100'
                                    "
                                >

                                    <img
                                        :src="imagem"
                                        alt="Preview do veículo"
                                        class="w-24 h-20 object-cover"
                                    >

                                </button>

                            </template>

                        </div>

                    </div>

                    {{-- INFORMAÇÕES PRINCIPAIS --}}
                    <div class="flex flex-col">

                        <div>

                            <span class="text-sm text-gray-500 uppercase">
                                {{ ucfirst($veiculo->fipe->tipo) }}
                            </span>

                            <h1 class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $nomeModelo }}
                            </h1>

                            <h2 class="text-xl text-gray-600 mt-1">
                                {{ $nomeMarca }}
                            </h2>

                        </div>


                        {{-- Preço --}}
                        <div class="mt-6 border-y py-5">

                            <span class="text-sm text-gray-500">
                                Preço de venda
                            </span>

                            <div class="text-4xl font-bold text-green-600 mt-1">
                                R$
                                {{ number_format($veiculo->valor_venda, 2, ',', '.') }}
                            </div>

                            <div class="text-sm text-gray-500 mt-2">
                                Valor FIPE:
                                R$ {{ number_format($veiculo->valor_fipe, 2, ',', '.') }}
                            </div>

                        </div>


                        {{-- Informações rápidas --}}
                        <div class="grid grid-cols-2 gap-4 mt-6">

                            <div class="border rounded-lg p-4">
                                <span class="block text-sm text-gray-500">
                                    Ano
                                </span>

                                <strong class="text-lg">
                                    {{ $veiculo->fipe->ano_modelo }}
                                </strong>
                            </div>


                            <div class="border rounded-lg p-4">
                                <span class="block text-sm text-gray-500">
                                    Quilometragem
                                </span>

                                <strong class="text-lg">
                                    {{ number_format($veiculo->quilometragem, 0, ',', '.') }} km
                                </strong>
                            </div>


                            <div class="border rounded-lg p-4">
                                <span class="block text-sm text-gray-500">
                                    Câmbio
                                </span>

                                <strong class="text-lg">
                                    {{ $cambio }}
                                </strong>
                            </div>


                            <div class="border rounded-lg p-4">
                                <span class="block text-sm text-gray-500">
                                    Combustível
                                </span>

                                <strong class="text-lg">
                                    {{ $veiculo->fipe->combustivel }}
                                </strong>
                            </div>

                            <div class="border rounded-lg p-4 flex gap-5">
                            <div>
                                <span class="block text-lg text-black font-bold">
                                    Cor:
                                </span>
                            </div>
                            <span
                                class="inline-block w-9 h-9 rounded-full border border-gray-300"
                                style="background-color: {{ $veiculo->cor }}"
                            ></span>
                            </div>

                        </div>

                    </div>

                </div>



                        {{-- DESCRIÇÃO --}}
                        @if ($veiculo->descricao)

                            <div class="mt-10 border-t" style="padding-top:-2rem;">

                                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                                    Descrição
                                </h2>

                                <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                                    {{ $veiculo->descricao }}
                                </p>

                            </div>

                        @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
