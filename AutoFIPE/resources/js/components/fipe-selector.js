const tipo = document.getElementById('tipo');
const marca = document.getElementById('marca');
const modelo = document.getElementById('modelo');
const ano = document.getElementById('ano');
const codigoFipe = document.getElementById('codigoFipe');
const valorFipe = document.getElementById('valorFipe');
const mesReferencia = document.getElementById('mesReferencia');

// Se o elemento principal não existir nesta página, interrompe o script silenciosamente
if (!tipo) {
    // Não faz nada e evita que os erros aconteçam nas páginas sem o formulário FIPE
} else {

    function limpar(select, texto) {
        if (!select) return; // Proteção extra caso falte algum elemento individual
        select.innerHTML = `<option value="">${texto}</option>`;
        select.disabled = true;
    }

    function preencher(select, lista) {

        if (!lista || !Array.isArray(lista)) {
            console.error("Erro: Os dados recebidos não são uma lista válida.", lista);
            alert("Erro ao carregar dados. Confira sua conexão com a internet ou tente novamente mais tarde.");
            select.innerHTML = `<option value="">Erro ao carregar dados</option>`;
            return;
        }

        if (!select) return; // Proteção extra caso falte algum elemento individual
        lista.forEach(item => {
            select.innerHTML += `
                <option value="${item.codigo}">
                    ${item.nome}
                </option>`;
        });

        select.disabled = false;
    }

    // Carrega os tipos apenas se o elemento 'tipo' existir na página
    fetch('/api/tipos')
        .then(res => res.json())
        .then(tipos => preencher(tipo, tipos));

    // Quando selecionar um tipo
    tipo.addEventListener('change', (event) => {

        limpar(marca, 'Selecione a marca');
        limpar(modelo, 'Selecione o modelo');
        limpar(ano, 'Selecione o ano');

        if (!tipo.value) return;

        fetch('/api/marcas/' + tipo.value)
            .then(res => res.json())
            .then(marcas => preencher(marca, marcas));

        event.preventDefault(); // Corrigido: o 'event' agora vem do parâmetro da arrow function
    });

    // Quando selecionar uma marca
    if (marca) {
        marca.addEventListener('change', () => {

            limpar(modelo, 'Selecione o modelo');
            limpar(ano, 'Selecione o ano');

            if (!marca.value) return;

            fetch(`/api/modelos/${tipo.value}/${marca.value}`)
                .then(res => res.json())
                .then(modelos => preencher(modelo, modelos));
        });
    }

    // Quando selecionar um modelo
    if (modelo) {
        modelo.addEventListener('change', () => {

            limpar(ano, 'Selecione o ano');

            if (!modelo.value) return;

            fetch(`/api/anos/${tipo.value}/${marca.value}/${modelo.value}`)
                .then(res => res.json())
                .then(anos => preencher(ano, anos));
        });
    }

    //Quando selecionar um ano
    if (ano) {
    ano.addEventListener('change', () => {

        if (!ano.value) return;

        console.log("Evento do ano disparou!");

        fetch(`/api/veiculo/${tipo.value}/${marca.value}/${modelo.value}/${ano.value}`)
            .then(res => res.json())
            .then(veiculo => {

            codigoFipe.value = veiculo.CodigoFipe;
            valorFipe.value = veiculo.Valor;
            mesReferencia.value = veiculo.MesReferencia;

            })
            .catch(err => console.error(err));

    });
    }

}
