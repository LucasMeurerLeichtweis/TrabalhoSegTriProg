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

        <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
            <div style="width: 30%;">
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

                <div class="mt-4">
                    <x-input-label for="valorCompra" :value="__('Valor de Compra')" />
                    <x-text-input
                        id="valorCompra"
                        class="block mt-1 max-w-25"
                        type="text"
                        name="valor_compra"
                        oninput="formatarMoeda(this)"
                        :value="old('valor_compra')"
                    />
                </div>

                <div class="mt-4">
                    <x-input-label for="valorVenda" :value="__('Valor de Venda')" />
                    <x-text-input
                        id="valorVenda"
                        class="block mt-1 max-w-25"
                        type="text"
                        name="valor_venda"
                        oninput="formatarMoeda(this)"
                        :value="old('valor_venda')"
                    />
                </div>

            </div>

            <div class="mt-4" style="width: 70%; height: 27.5vh; display: flex; flex-direction: column;">
                <x-input-label for="descricao" :value="__('Descrição')" style="height: 10%; width: 100%" />
                <x-textarea-input id="descricao" name="descricao" style="height: 90%; width: 100%" />
            </div>
        </div>

<script>
function formatarMoeda(input) {
    // Remove tudo que não é número
    let valor = input.value.replace(/\D/g, '');

    if (valor === '') {
        input.value = '';
        return;
    }

    // Converte para centavos
    valor = (parseInt(valor, 10) / 100).toFixed(2);

    // Formata para o padrão brasileiro
    valor = valor.replace('.', ',');
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    input.value = 'R$ ' + valor;
}
</script>


