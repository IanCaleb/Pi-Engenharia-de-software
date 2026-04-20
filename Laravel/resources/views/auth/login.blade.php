<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#1E1E1E] overflow-hidden">

<div class="w-screen h-screen">

    <div class="w-full h-full bg-white grid grid-cols-1 lg:grid-cols-2">

        <!-- Imagem -->
        <div class="hidden lg:block h-full">
            <img
                src="{{ asset('images/img3.png') }}"
                class="w-full h-full object-cover"
                alt="Login"
            >
        </div>

        <!-- Formulário -->
        <div class="h-screen overflow-y-auto flex items-center justify-center px-6 py-6 md:px-12">

            <div class="w-full max-w-md">

                <h1 class="text-5xl font-light text-[#6E8F2A]">
                    Faça seu login
                </h1>

                <p class="text-2xl text-gray-400 mb-10">
                    Acesse sua conta por aqui!
                </p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('E-mail')" class="text-xl text-gray-500 mb-2"/>
                        <x-text-input
                            id="email"
                            class="w-full h-14 rounded-xl"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Senha')" class="text-xl text-gray-500 mb-2"/>

                        <x-text-input
                            id="password"
                            class="w-full h-14 rounded-xl"
                            type="password"
                            name="password"
                            required
                        />

                        <div class="text-right mt-2">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-[#6E8F2A] text-sm">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <x-primary-button class="w-full h-14 rounded-full justify-center text-xl bg-[#789744]">
                        Entrar
                    </x-primary-button>

                    <div class="flex items-center gap-4">
                        <div class="h-px bg-gray-300 flex-1"></div>
                        <span class="text-[#789744]">ou</span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <a href="{{ route('register') }}"
                       class="w-full h-14 rounded-full border border-[#789744] text-[#789744] flex items-center justify-center text-xl">
                        Criar Conta
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

</body>

</body>
</html>

