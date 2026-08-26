const tipo = document.getElementById('tipo');
const marca = document.getElementById('marca');
const modelo = document.getElementById('modelo');
const ano = document.getElementById('ano');

const codigoFipe = document.getElementById('codigoFipe');
const valorFipe = document.getElementById('valorFipe');
const mesReferencia = document.getElementById('mesReferencia');
const combustivel = document.getElementById('combustivel');


if (tipo) {

    const dadosIniciais = window.fipeInitialData ?? {};

    function limpar(select, texto) {

        if (!select) return;

        select.innerHTML = `<option value="">${texto}</option>`;
        select.disabled = true;
    }


    function preencher(select, lista, selecionado = null) {

        if (!select) return;

        if (!Array.isArray(lista)) {

            console.error(
                'Erro: Os dados recebidos não são uma lista válida.',
                lista
            );

            select.innerHTML =
                `<option value="">Erro ao carregar dados</option>`;

            select.disabled = true;

            return;
        }

        lista.forEach(item => {

            const codigo = item.code ?? item.codigo;
            const nome = item.name ?? item.nome;

            const option = document.createElement('option');

            option.value = codigo;
            option.textContent = nome;

            let corresponde = false;

            // Comparação normal
            if (
                selecionado !== null &&
                String(codigo) === String(selecionado)
            ) {
                corresponde = true;
            }

            // Caso especial para o ano
            if (
                select.id === 'ano' &&
                selecionado !== null &&
                String(codigo).startsWith(
                    `${selecionado}-`
                )
            ) {
                corresponde = true;
            }

            if (corresponde) {
                option.selected = true;
            }

            select.appendChild(option);
        });

        select.disabled = false;
    }


    async function carregarTipos() {

        try {

            const res = await fetch('/api/tipos');
            const tipos = await res.json();

            preencher(
                tipo,
                tipos,
                dadosIniciais.tipo
            );

        } catch (err) {

            console.error('Erro ao carregar tipos:', err);

        }

    }


    async function carregarMarcas(tipoSelecionado) {

        limpar(marca, 'Selecione a marca');
        limpar(modelo, 'Selecione o modelo');
        limpar(ano, 'Selecione o ano');

        if (!tipoSelecionado) return;

        try {

            const res = await fetch(
                `/api/marcas/${tipoSelecionado}`
            );

            const marcas = await res.json();

            preencher(
                marca,
                marcas,
                dadosIniciais.marca
            );

        } catch (err) {

            console.error('Erro ao carregar marcas:', err);

        }

    }


    async function carregarModelos(
        tipoSelecionado,
        marcaSelecionada
    ) {

        limpar(modelo, 'Selecione o modelo');
        limpar(ano, 'Selecione o ano');

        if (!marcaSelecionada) return;

        try {

            const res = await fetch(
                `/api/modelos/${tipoSelecionado}/${marcaSelecionada}`
            );

            const modelos = await res.json();

            preencher(
                modelo,
                modelos,
                dadosIniciais.modelo
            );

        } catch (err) {

            console.error('Erro ao carregar modelos:', err);

        }

    }


    async function carregarAnos(
        tipoSelecionado,
        marcaSelecionada,
        modeloSelecionado
    ) {

        limpar(ano, 'Selecione o ano');

        if (!modeloSelecionado) return;

        try {

            const res = await fetch(
                `/api/anos/${tipoSelecionado}/${marcaSelecionada}/${modeloSelecionado}`
            );

            const anos = await res.json();

            console.log('Anos da API:', anos);
            console.log('Ano inicial:', dadosIniciais.ano);

            preencher(
                ano,
                anos,
                dadosIniciais.ano
            );

        } catch (err) {

            console.error('Erro ao carregar anos:', err);

        }

    }


    async function carregarDadosVeiculo() {

        if (
            !tipo.value ||
            !marca.value ||
            !modelo.value ||
            !ano.value
        ) {
            return;
        }

        try {

            const res = await fetch(
                `/api/veiculo/${tipo.value}/${marca.value}/${modelo.value}/${ano.value}`
            );

            const veiculo = await res.json();

            console.log(
                'Veículo recebido:',
                veiculo
            );

            codigoFipe.value =
                veiculo.codeFipe ?? '';

            valorFipe.value =
                veiculo.price ?? '';

            mesReferencia.value =
                veiculo.referenceMonth ?? '';

            combustivel.value =
                veiculo.fuel ?? '';

        } catch (err) {

            console.error(
                'Erro ao carregar dados do veículo:',
                err
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Eventos do formulário
    |--------------------------------------------------------------------------
    */

    tipo.addEventListener('change', async () => {

        await carregarMarcas(
            tipo.value
        );

    });


    marca.addEventListener('change', async () => {

        await carregarModelos(
            tipo.value,
            marca.value
        );

    });


    modelo.addEventListener('change', async () => {

        await carregarAnos(
            tipo.value,
            marca.value,
            modelo.value
        );

    });


    ano.addEventListener('change', async () => {

        await carregarDadosVeiculo();

    });


    /*
    |--------------------------------------------------------------------------
    | Inicialização
    |--------------------------------------------------------------------------
    */

    async function inicializar() {

        await carregarTipos();


        // Modo edição
        if (dadosIniciais.tipo) {

            await carregarMarcas(
                dadosIniciais.tipo
            );

        }


        if (
            dadosIniciais.tipo &&
            dadosIniciais.marca
        ) {

            await carregarModelos(
                dadosIniciais.tipo,
                dadosIniciais.marca
            );

        }


        if (
            dadosIniciais.tipo &&
            dadosIniciais.marca &&
            dadosIniciais.modelo
        ) {

            await carregarAnos(
                dadosIniciais.tipo,
                dadosIniciais.marca,
                dadosIniciais.modelo
            );

        }
        if (ano.value) {
            await carregarDadosVeiculo();
        }

    }


    inicializar();

}
