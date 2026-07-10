const tipo = document.getElementById('tipo');
const marca = document.getElementById('marca');
const modelo = document.getElementById('modelo');
const ano = document.getElementById('ano');

function limpar(select, texto) {
    select.innerHTML = `<option value="">${texto}</option>`;
    select.disabled = true;
}

function preencher(select, lista) {
    lista.forEach(item => {
        select.innerHTML += `
            <option value="${item.codigo}">
                ${item.nome}
            </option>`;
    });

    select.disabled = false;
}

// Carrega os tipos
fetch('/api/tipos')
    .then(res => res.json())
    .then(tipos => preencher(tipo, tipos));

// Quando selecionar um tipo
tipo.addEventListener('change', () => {

    limpar(marca, 'Selecione a marca');
    limpar(modelo, 'Selecione o modelo');
    limpar(ano, 'Selecione o ano');

    if (!tipo.value) return;

    fetch('/api/marcas/' + tipo.value)
        .then(res => res.json())
        .then(marcas => preencher(marca, marcas));
});

// Quando selecionar uma marca
marca.addEventListener('change', () => {

    limpar(modelo, 'Selecione o modelo');
    limpar(ano, 'Selecione o ano');

    if (!marca.value) return;

    fetch(`/api/modelos/${tipo.value}/${marca.value}`)
        .then(res => res.json())
        .then(modelos => preencher(modelo, modelos));
});

// Quando selecionar um modelo
modelo.addEventListener('change', () => {

    limpar(ano, 'Selecione o ano');

    if (!modelo.value) return;

    fetch(`/api/anos/${tipo.value}/${marca.value}/${modelo.value}`)
        .then(res => res.json())
        .then(anos => preencher(ano, anos));
});
