<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center w-full justify-center gap-4">
        <h2 class="text-xl font-semibold text-white" style="font-size: 40px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
            {{ __('Bem vindo ao') }}
        </h2>

        <a href="/">
            <x-application-logocompleta class="h-16 w-auto" />
        </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-bottom: 55px;">

            <div class="bg-white overflow-y-auto shadow-sm sm:rounded-lg" style="padding: 15px;">

                <h2 class="text-xl font-semibold text-black mb-3 ml-1" style="font-size: 40px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
                    {{ __('Nossas ofertas') }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                    @foreach ($veiculos as $veiculo)
                        <x-boxVeiculo :veiculo="$veiculo" />
                    @endforeach

                </div>

                <div class="mt-6">
                    {{ $veiculos->links() }}
                </div>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
