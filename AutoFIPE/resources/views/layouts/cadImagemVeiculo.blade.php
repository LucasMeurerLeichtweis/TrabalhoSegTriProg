@props([
    'veiculo' => null,
])

<div class="mt-6">

    <x-input-label
        for="imagens"
        :value="__('Imagens do Veículo')"
    />

    <!-- Preview -->
    <div
        id="previewImagens"
        class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-5"
    ></div>


    <!-- Área para adicionar imagens -->
    <label
        for="imagens"
        class="mt-2 flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-gray-50 transition"
    >

        <div class="flex flex-col items-center justify-center">

            <svg
                class="w-10 h-10 text-gray-400 mb-2"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l-4-4m4 4l4-4"
                />
            </svg>

            <p class="text-sm text-gray-600">
                Clique para selecionar ou arraste imagens aqui
            </p>

            <p class="text-xs text-gray-400 mt-1">
                PNG, JPG ou WEBP • Máx. 5 MB por imagem
            </p>

        </div>

        <input
            id="imagens"
            name="imagens[]"
            type="file"
            multiple
            accept="image/*"
            class="hidden"
        >

    </label>


    <x-input-error
        :messages="$errors->get('imagens')"
        class="mt-2"
    />


    <!-- Imagens existentes que serão excluídas -->
    <div id="imagensExcluidas"></div>

    <div id="imagemPrincipal"></div>
    <!-- Ordem das imagens existentes -->
    <div id="ordemImagens"></div>

</div>


<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

<script>

const input = document.getElementById('imagens');
const preview = document.getElementById('previewImagens');
const dropArea = input.parentElement;

let imagensNovas = [];

let imagensExistentes = @json(
    $veiculo?->imagens?->map(fn ($imagem) => [
        'id' => $imagem->id,
        'url' => $imagem->url,
    ])->values() ?? []
);

let imagensExcluidas = [];


// --------------------------------------------------
// Seleção
// --------------------------------------------------

input.addEventListener('change', (e) => {

    adicionarArquivos([
        ...e.target.files
    ]);

});


// --------------------------------------------------
// Drag & Drop
// --------------------------------------------------

dropArea.addEventListener('dragover', (e) => {

    e.preventDefault();

    dropArea.classList.add(
        'border-indigo-500',
        'bg-indigo-50'
    );

});


dropArea.addEventListener('dragleave', () => {

    dropArea.classList.remove(
        'border-indigo-500',
        'bg-indigo-50'
    );

});


dropArea.addEventListener('drop', (e) => {

    e.preventDefault();

    dropArea.classList.remove(
        'border-indigo-500',
        'bg-indigo-50'
    );

    adicionarArquivos([
        ...e.dataTransfer.files
    ]);

});


// --------------------------------------------------
// Adicionar novas imagens
// --------------------------------------------------

function adicionarArquivos(files) {

    files.forEach(file => {

        if (!file.type.startsWith('image/')) {
            return;
        }

        imagensNovas.push(file);

    });

    atualizarInput();

    renderizarPreview();

}


// --------------------------------------------------
// Atualizar input de arquivos
// --------------------------------------------------

function atualizarInput() {

    const dt = new DataTransfer();

    imagensNovas.forEach(file => {

        dt.items.add(file);

    });

    input.files = dt.files;

}


// --------------------------------------------------
// Renderizar
// --------------------------------------------------

function renderizarPreview() {

    preview.innerHTML = '';

    /*
    |--------------------------------------------------------------------------
    | Imagens existentes
    |--------------------------------------------------------------------------
    */

    imagensExistentes.forEach((imagem, index) => {

        const div = criarCardImagem(
            imagem.url,
            index === 0,
            'existente',
            imagem.id
        );

        preview.appendChild(div);

    });


    /*
    |--------------------------------------------------------------------------
    | Novas imagens
    |--------------------------------------------------------------------------
    */

    imagensNovas.forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = function(e) {

            const div = criarCardImagem(
                e.target.result,
                imagensExistentes.length === 0 && index === 0,
                'nova',
                index
            );

            preview.appendChild(div);

        };

        reader.readAsDataURL(file);

    });


    atualizarOrdem();

}


// --------------------------------------------------
// Criar card
// --------------------------------------------------

function criarCardImagem(
    src,
    principal,
    tipo,
    id
) {

    const div = document.createElement('div');

    div.className =
        'relative rounded-lg overflow-hidden border shadow group cursor-pointer';

    div.dataset.tipo = tipo;
    div.dataset.id = id;

    div.innerHTML = `

        <img
            src="${src}"
            class="w-full h-36 object-cover"
        >

        ${
            principal
            ?
            `
            <span
                class="absolute top-2 left-2
                       bg-indigo-600 text-white text-xs
                       px-2 py-1 rounded"
            >
                Foto Principal
            </span>
            `
            :
            ''
        }

        <div
            class="absolute inset-0 bg-black/60
                   opacity-0 group-hover:opacity-100
                   transition flex items-center justify-center"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-10 h-10 text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7L5 7M10 11V17M14 11V17M6 7L7 20H17L18 7M9 7V4H15V7"
                />

            </svg>

        </div>

    `;


    div.addEventListener('click', () => {

        removerImagem(
            tipo,
            id
        );

    });


    return div;

}


// --------------------------------------------------
// Remover imagem
// --------------------------------------------------

function removerImagem(tipo, id) {

    if (tipo === 'nova') {

        imagensNovas.splice(
            Number(id),
            1
        );

        atualizarInput();

    }


    if (tipo === 'existente') {

        imagensExcluidas.push(id);

        imagensExistentes =
            imagensExistentes.filter(
                imagem =>
                    imagem.id != id
            );

        atualizarImagensExcluidas();

    }


    renderizarPreview();

}


// --------------------------------------------------
// Imagens existentes excluídas
// --------------------------------------------------

function atualizarImagensExcluidas() {

    const container =
        document.getElementById(
            'imagensExcluidas'
        );

    container.innerHTML = '';

    imagensExcluidas.forEach(id => {

        const input =
            document.createElement('input');

        input.type = 'hidden';
        input.name = 'imagens_excluidas[]';
        input.value = id;

        container.appendChild(input);

    });

}


// --------------------------------------------------
// Ordem das imagens existentes
// --------------------------------------------------

function atualizarOrdem() {

    const container =
        document.getElementById(
            'ordemImagens'
        );

    container.innerHTML = '';

    imagensExistentes.forEach(
        (imagem, index) => {

            const input =
                document.createElement('input');

            input.type = 'hidden';

            input.name =
                'ordem_imagens[]';

            input.value =
                imagem.id;

            container.appendChild(input);

        }
    );
    atualizarImagemPrincipal();

}

function atualizarImagemPrincipal() {

    const container =
        document.getElementById('imagemPrincipal');

    container.innerHTML = '';

    const primeiraImagem =
        preview.children[0];

    if (!primeiraImagem) {
        return;
    }

    const input =
        document.createElement('input');

    input.type = 'hidden';
    input.name = 'imagem_principal_tipo';
    input.value =
        primeiraImagem.dataset.tipo;

    container.appendChild(input);


    const inputId =
        document.createElement('input');

    inputId.type = 'hidden';
    inputId.name = 'imagem_principal_id';
    inputId.value =
        primeiraImagem.dataset.id;

    container.appendChild(inputId);
}


// --------------------------------------------------
// Sortable
// --------------------------------------------------

Sortable.create(preview, {

    animation: 200,

    onEnd() {

        const elementos =
            [...preview.children];

        const novasExistentes = [];

        const novasImagens = [];

        elementos.forEach(elemento => {

            const tipo =
                elemento.dataset.tipo;

            const id =
                elemento.dataset.id;


            if (tipo === 'existente') {

                const imagem =
                    imagensExistentes.find(
                        imagem =>
                            String(imagem.id) === String(id)
                    );

                if (imagem) {
                    novasExistentes.push(imagem);
                }

            }


            if (tipo === 'nova') {

                const imagem =
                    imagensNovas[Number(id)];

                if (imagem) {
                    novasImagens.push(imagem);
                }

            }

        });


        imagensExistentes =
            novasExistentes;

        imagensNovas =
            novasImagens;


        atualizarInput();

        atualizarOrdem();

        renderizarPreview();

    }

});


/*
|--------------------------------------------------------------------------
| Inicialização
|--------------------------------------------------------------------------
*/

renderizarPreview();

</script>
