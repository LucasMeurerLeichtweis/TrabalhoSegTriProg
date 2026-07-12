<x-app-layout>

    <div class="py-12" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="overflow-y: auto; max-height: 80vh; max-width: 70vw;" margin-bottom: 70px;>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 20px;">
                <div class="p-6 text-gray-900">
                    <h1 style="font-size: 24px; font-weight: bold;"> Model search </h1>
                    <x-cadFipe>
                    </x-cadFipe>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 20px;">
                <div class="p-6 text-gray-900">
                    <h1 style="font-size: 24px; font-weight: bold;"> Vehicle data </h1>
                    <x-cadVeiculo>
                    </x-cadVeiculo>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 style="font-size: 24px; font-weight: bold;"> Vehicle images </h1>
                    <x-cadImagemVeiculo>
                    </x-cadImagemVeiculo>
                </div>
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-primary-button  class="ms-4" style="font-size:5vh; font-weight: bold; padding: 20px">
                    {{ __('Register Vehicle') }}
                </x-primary-button>
            </div>

        </div>
    </div>

</x-app-layout>
