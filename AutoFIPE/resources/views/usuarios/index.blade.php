<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div
        x-data="{
            modalAberto: false,
            usuarioSelecionado: null,
            abrirModal(usuario) {
                this.usuarioSelecionado = usuario;
                this.modalAberto = true;
            }
        }"
    >

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-white">

                    <h1 class="text-2xl font-bold mb-6">
                        Lista de Usuários
                    </h1>

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="border-b border-gray-600">
                                <tr>
                                    <th class="text-left px-4 py-3">
                                        ID
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Nome
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        E-mail
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Função
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Cadastro
                                    </th>

                                    <th class="text-left px-4 py-3">
                                        Opções
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @forelse($usuarios as $usuario)

                                    <tr class="border-b border-gray-700 hover:bg-gray-700">

                                        <td class="px-4 py-3">
                                            {{ $usuario->id }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $usuario->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $usuario->email }}
                                        </td>

                                        <td class="px-4 py-3">

                                            @forelse($usuario->roles as $role)

                                                <span class="px-3 py-1 text-sm rounded bg-blue-600">
                                                    {{ $role->name }}
                                                </span>

                                            @empty

                                                <span class="text-gray-400">
                                                    Sem função
                                                </span>

                                            @endforelse

                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $usuario->created_at->format('d/m/Y H:i') }}
                                        </td>

                                        <td class="px-4 py-3 text-center" >
                                            @if (!$usuario->hasRole('superadmin'))
                                            <button
                                                type="button"
                                                @click='abrirModal({
                                                    id: {{ $usuario->id }},
                                                    nome: @json($usuario->name),
                                                    email: @json($usuario->email),
                                                    role: @json($usuario->roles->first()?->name)
                                                })'
                                                class="px-4 py-1 bg-blue-600 hover:bg-blue-700 rounded"
                                            >
                                                Opções
                                            </button>
                                            @else
                                            <span class="text-gray-500">
                                                ---
                                            </span>
                                            @endif
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-400">
                                            Nenhum usuário encontrado.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-6">
                        {{ $usuarios->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div
        x-show="modalAberto"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
    >

        <!-- Fundo escuro -->
        <div
            class="absolute inset-0 bg-black/60"
            @click="modalAberto = false"
        ></div>


        <!-- Conteúdo -->
        <div
            class="relative z-10 w-full max-w-md bg-gray-800 rounded-lg shadow-xl p-6 text-white"
            @click.stop
        >

            <!-- Cabeçalho -->
            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-bold">
                    Gerenciar Usuário
                </h2>

                <button
                    type="button"
                    @click="modalAberto = false"
                    class="text-gray-400 hover:text-white text-2xl"
                >
                    ×
                </button>

            </div>


            <!-- Dados -->
            <div class="mb-6">

                <p class="text-lg font-semibold" x-text="usuarioSelecionado?.nome"></p>

                <p
                    class="text-gray-400 text-sm"
                    x-text="usuarioSelecionado?.email"
                ></p>

            </div>


            <!-- Alterar função -->
            <form
                method="POST"
                :action="'/usuarios/' + usuarioSelecionado.id + '/role'"
                class="mb-6"
            >

                @csrf
                @method('PUT')

                <label class="block mb-2">
                    Alterar função
                </label>

                <select
                    name="role"
                    x-model="usuarioSelecionado.role"
                    class="w-full bg-gray-700 border-gray-600 rounded text-white"
                >
                    <option value="client">
                        Cliente
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                    <option value="superadmin">
                        Super Admin
                    </option>

                </select>


                <button
                    type="submit"
                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 py-2 rounded"
                >
                    Salvar função
                </button>

            </form>


            <!-- Separador -->
            <div class="border-t border-gray-600 my-6"></div>


            <!-- Excluir -->
            <form
                method="POST"
                :action="'/usuarios/' + usuarioSelecionado.id"
                onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 py-2 rounded"
                >
                    Excluir usuário
                </button>

            </form>

        </div>

    </div>

</x-app-layout>
