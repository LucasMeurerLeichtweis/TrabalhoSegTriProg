    <form method="POST" action="{{ route('veiculo.store') }}">
        @csrf

        <!-- Tipo -->
        <div>
            <x-input-label for="tipo" :value="__('Tipo')" />
            <x-select-label
                id="tipo"
                name="tipo"
                placeholder="Selecione o tipo"
            />
            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
        </div>

        <!-- Marca -->
        <div class="mt-4">
            <x-input-label for="marca" :value="__('Marca')" />
            <x-select-label
                id="marca"
                name="marca"
                placeholder="Selecione a marca"
            />
            <x-input-error :messages="$errors->get('marca')" class="mt-2" />
        </div>

        <!-- Modelo -->
        <div class="mt-4">
            <x-input-label for="modelo" :value="__('Modelo')" />
            <x-select-label
                id="modelo"
                name="modelo"
                placeholder="Selecione o modelo"
            />
            <x-input-error :messages="$errors->get('modelo')" class="mt-2" />
        </div>

        <!-- Ano -->
        <div class="mt-4">
            <x-input-label for="ano" :value="__('Ano')" />
            <x-select-label
                id="ano"
                name="ano"
                placeholder="Selecione o ano"
            />
            <x-input-error :messages="$errors->get('ano')" class="mt-2" />
        </div>




        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>



