
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Placa -->
        <div class="mt-4">
            <x-input-label for="placa" :value="__('Placa')" />
            <x-text-input
            id="placa"
            maxlength="8"
            minlength="8"
            uppercase
            class="block mt-1 w-full"
            type="text"
            style="text-transform: uppercase;"
            oninput="formatarPlaca(this)"
            name="placa"
            :value="old('placa')" required autofocus autocomplete="placa"/>
            <script>
                    function formatarPlaca(input) {
                        let valor = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                        if (valor.length > 3) {
                            valor = valor.substring(0, 3) + ' ' + valor.substring(3);
                        }
                        input.value = valor;
                    }
            </script>

            <x-input-error :messages="$errors->get('placa')" class="mt-2" />
        </div>

        <!-- Renavam -->
        <div class="mt-4">
            <x-input-label for="renavam" :value="__('Renavam')" />
            <x-text-input
            id="renavam"
            maxlength="12"
            minlength="12"
            uppercase
            class="block mt-1 w-full"
            type="text"
            style="text-transform: uppercase;"
            oninput="formatarRenavam(this)"
            name="renavam"
            :value="old('renavam')" required autofocus autocomplete="renavam"/>
            <script>
                    function formatarRenavam(input) {
                        let valor = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                        if (valor.length > 10) {
                            valor = valor.substring(0,10) + '-' + valor.substring(10);
                        }
                        input.value = valor;
                    }
            </script>

            <x-input-error :messages="$errors->get('renavam')" class="mt-2" />
        </div>



        <!-- Quilometragem -->
        <div class="mt-4">
            <x-input-label for="quilometragem" :value="__('Quilometragem')" />

            <x-number-input
                id="quilometragem"
                name="quilometragem"
                maxlength="6"
                min="0"
                max="999999"
                :value="old('quilometragem')"
                class="mt-1 block w-full"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('quilometragem')" class="mt-2" />
        </div>

        <!-- Cor -->
        <div class="mt-4">
            <x-input-label for="cor" :value="__('Cor')" />
            <input
                type="color"
                id="cor"
                name="cor"
                value="{{ old('cor', '#000000') }}"
                class="block mt-1 h-10 w-20 rounded-md border border-gray-300 cursor-pointer"
            >
            <x-input-error :messages="$errors->get('cor')" class="mt-2" />
        </div>


    </form>



