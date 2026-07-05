<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center  w-full">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Bem-vindo ao') }}
        </h2>

        <a href="/">
            <x-application-logocompleta class="h-16 w-auto" />
        </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
