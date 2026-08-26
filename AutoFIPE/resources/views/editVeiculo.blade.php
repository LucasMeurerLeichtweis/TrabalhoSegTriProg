<x-app-layout>

    <div class="py-12">

        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            style="overflow-y: auto; max-height: 80vh; max-width: 70vw; margin-bottom: 70px;"
        >

            <form
                action="{{ route('updateVeiculo', $veiculo->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                {{-- FIPE --}}

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    style="margin-bottom: 20px;"
                >

                    <div class="p-6 text-gray-900">

                        <h1 style="font-size: 24px; font-weight: bold;">
                            Buscar modelo
                        </h1>

                        <x-cadFipe
                            :veiculo="$veiculo"
                            :marca="$marca"
                            :modelo="$modelo"
                        />

                    </div>

                </div>


                {{-- INFORMAÇÕES --}}

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    style="margin-bottom: 20px;"
                >

                    <div class="p-6 text-gray-900">

                        <h1 style="font-size: 24px; font-weight: bold;">
                            Informações do veículo
                        </h1>

                        <x-cadVeiculo :veiculo="$veiculo" />

                    </div>

                </div>


                {{-- IMAGENS --}}

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900">

                        <h1 style="font-size: 24px; font-weight: bold;">
                            Imagens do veículo
                        </h1>

                        <x-cadImagemVeiculo
                            :veiculo="$veiculo"
                        />

                    </div>

                </div>


                {{-- BOTÃO SALVAR --}}

                <div class="flex items-center justify-center mt-4">

                    <x-primary-button
                        class="ms-4"
                        style="font-size:5vh; font-weight:bold; padding:20px"
                    >
                        Salvar alterações
                    </x-primary-button>

                </div>

            </form>


            {{-- AÇÕES PERIGOSAS --}}

            <div
                class="flex items-center justify-center gap-4 mt-6"
            >

                {{-- MARCAR COMO VENDIDO --}}

                <form
                    action="{{ route('veiculo.vendido', $veiculo->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700"
                        onclick="return confirm('Deseja marcar este veículo como vendido?')"
                    >
                        Marcar como vendido
                    </button>

                </form>


                {{-- EXCLUIR --}}

                <form
                    action="{{ route('veiculo.destroy', $veiculo->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700"
                        onclick="return confirm('Tem certeza que deseja excluir este veículo? Esta ação não poderá ser desfeita.')"
                    >
                        Excluir veículo
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
