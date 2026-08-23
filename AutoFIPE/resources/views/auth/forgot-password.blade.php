<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Não tem problema. Informe seu endereço de e-mail e enviaremos um link para redefinição de senha, que permitirá que você escolha uma nova senha.') }}
    </div>

    <!-- Status da sessão -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Endereço de e-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Lembrou da senha? -->
        <div class="mt-4 text-sm text-gray-600">
            {{ __('Lembrou da sua senha?') }}

            <a
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}"
            >
                {{ __('Entre aqui') }}
            </a>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar link para redefinição de senha') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
