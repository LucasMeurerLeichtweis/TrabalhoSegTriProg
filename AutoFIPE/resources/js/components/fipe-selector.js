const tipo = document.getElementById('tipo');
const marca = document.getElementById('marca');
const modelo = document.getElementById('modelo');
const ano = document.getElementById('ano');

const codigoFipe = document.getElementById('codigoFipe');
const valorFipe = document.getElementById('valorFipe');
const mesReferencia = document.getElementById('mesReferencia');
const anoModelo = document.getElementById('anoModelo');
const combustivel = document.getElementById('combustivel');

if (tipo) {

    function limpar(select, texto) {
        if (!select) return;

        select.innerHTML = `<option value="">${texto}</option>`;
        select.disabled = true;
    }

    function preencher(select, lista) {
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

            select.innerHTML += `
                <option value="${codigo}">
                    ${nome}
                </option>
            `;
        });

        select.disabled = false;
    }

    // Carrega os tipos
    fetch('/api/tipos')
        .then(res => res.json())
        .then(tipos => preencher(tipo, tipos))
        .catch(err => console.error(err));


    // Quando selecionar um tipo
    tipo.addEventListener('change', () => {

        limpar(marca, 'Selecione a marca');
        limpar(modelo, 'Selecione o modelo');
        limpar(ano, 'Selecione o ano');

        if (!tipo.value) return;

        fetch(`/api/marcas/${tipo.value}`)
            .then(res => res.json())
            .then(marcas => preencher(marca, marcas))
            .catch(err => console.error(err));
    });


    // Quando selecionar uma marca
    marca.addEventListener('change', () => {

        limpar(modelo, 'Selecione o modelo');
        limpar(ano, 'Selecione o ano');

        if (!marca.value) return;

        fetch(`/api/modelos/${tipo.value}/${marca.value}`)
            .then(res => res.json())
            .then(modelos => preencher(modelo, modelos))
            .catch(err => console.error(err));
    });


    // Quando selecionar um modelo
    modelo.addEventListener('change', () => {

        limpar(ano, 'Selecione o ano');

        if (!modelo.value) return;

        fetch(
            `/api/anos/${tipo.value}/${marca.value}/${modelo.value}`
        )
            .then(res => res.json())
            .then(anos => preencher(ano, anos))
            .catch(err => console.error(err));
    });


    // Quando selecionar um ano
    ano.addEventListener('change', () => {

        if (!ano.value) return;

        fetch(
            `/api/veiculo/${tipo.value}/${marca.value}/${modelo.value}/${ano.value}`
        )
            .then(res => res.json())
            .then(veiculo => {

                console.log('Veículo recebido:', veiculo);

                codigoFipe.value = veiculo.codeFipe ?? '';
                valorFipe.value = veiculo.price ?? '';
                mesReferencia.value = veiculo.referenceMonth ?? '';
                anoModelo.value = veiculo.modelYear ?? '';
                combustivel.value = veiculo.fuel ?? '';

            })
            .catch(err => console.error(err));
    });
}
