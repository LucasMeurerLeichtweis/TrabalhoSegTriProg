<div class="mt-6">
    <x-input-label for="imagens" :value="__('Imagens do Veículo')" />
    
    <!-- Preview -->
    <div
        id="previewImagens"
        class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-5"
    ></div>

    <label
        for="imagens"
        class="mt-2 flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-gray-50 transition"
    >
        <div class="flex flex-col items-center justify-center">
            <svg class="w-10 h-10 text-gray-400 mb-2"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l-4-4m4 4l4-4"/>
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

    <x-input-error :messages="$errors->get('imagens')" class="mt-2" />


</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

<script>
const input = document.getElementById('imagens');
const preview = document.getElementById('previewImagens');
const dropArea = input.parentElement;

let imagens = [];

// ---------- Seleção ----------
input.addEventListener('change', (e) => {
    adicionarArquivos([...e.target.files]);
});

// ---------- Drag & Drop da área ----------
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
});

dropArea.addEventListener('drop', (e) => {

    e.preventDefault();

    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');

    adicionarArquivos([...e.dataTransfer.files]);
});

// ---------- Adiciona arquivos ----------
function adicionarArquivos(files){

    files.forEach(file => {

        if(file.type.startsWith("image/")){
            imagens.push(file);
        }

    });

    atualizarInput();
    renderizarPreview();
}

// ---------- Atualiza input ----------
function atualizarInput(){

    const dt = new DataTransfer();

    imagens.forEach(file => dt.items.add(file));

    input.files = dt.files;

}

// ---------- Preview ----------
function renderizarPreview(){

    preview.innerHTML = "";

    imagens.forEach((file,index)=>{

        const reader = new FileReader();

        reader.onload = function(e){

            const div = document.createElement("div");

            div.className =
            "relative rounded-lg overflow-hidden border shadow group cursor-pointer";

            div.draggable = true;

            div.innerHTML = `

                <img
                    src="${e.target.result}"
                    class="w-full h-36 object-cover">

                ${
                    index===0
                    ?
                    `<span class="absolute top-2 left-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                        Foto Principal
                    </span>`
                    :
                    ""
                }

                <div
                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-10 h-10 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7L5 7M10 11V17M14 11V17M6 7L7 20H17L18 7M9 7V4H15V7"/>
                    </svg>

                </div>

            `;

            // remover imagem
            div.addEventListener("click",()=>{

                imagens.splice(index,1);

                atualizarInput();

                renderizarPreview();

            });

            preview.appendChild(div);

        }

        reader.readAsDataURL(file);

    });

}

Sortable.create(preview,{
    animation:200,

    onEnd(evt){

        const item = imagens.splice(evt.oldIndex,1)[0];

        imagens.splice(evt.newIndex,0,item);

        atualizarInput();

        renderizarPreview();
    }

});
</script>
