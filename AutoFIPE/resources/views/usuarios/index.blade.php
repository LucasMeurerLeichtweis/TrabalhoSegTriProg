<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

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

</x-app-layout>
