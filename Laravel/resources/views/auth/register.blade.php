<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1E1E1E] overflow-hidden">
<div class="w-screen h-screen">
    <div class="w-full h-full bg-white grid grid-cols-1 lg:grid-cols-2">

        <!-- Left: Form -->
        <div class="h-screen overflow-y-auto flex items-center justify-center px-4 py-4 md:px-8">
            <div class="w-full max-w-md">
                <h1 class="text-4xl font-light text-[#6E8F2A]">Faça seu cadastro</h1>
                <p class="text-xl text-gray-400 mb-4">Crie sua conta aqui!</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nome')" class="text-lg text-gray-500 mb-2"/>
                        <x-text-input
                            id="name"
                            class="w-full h-12 rounded-lg"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('E-mail')" class="text-lg text-gray-500 mb-2"/>
                        <x-text-input
                            id="email"
                            class="w-full h-12 rounded-lg"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Senha')" class="text-lg text-gray-500 mb-2"/>
                        <x-text-input
                            id="password"
                            class="w-full h-12 rounded-lg"
                            type="password"
                            name="password"
                            required
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirme sua senha')" class="text-lg text-gray-500 mb-2"/>
                        <x-text-input
                            id="password_confirmation"
                            class="w-full h-12 rounded-lg"
                            type="password"
                            name="password_confirmation"
                            required
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Tipo de usuário')" class="text-lg text-gray-500 mb-2"/>
                        <select id="role" name="role" class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700">
                            <option value="" disabled selected hidden>- selecione seu papel -</option>
                            <option value="user">Usuário</option>
                            <option value="manager">Gerente de loja</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                    </div>

                    <x-primary-button class="w-full h-12 rounded-full justify-center text-lg bg-[#789744]">
                        Cadastrar
                    </x-primary-button>

                    <div class="flex items-center gap-4">
                        <div class="h-px bg-gray-300 flex-1"></div>
                        <span class="text-[#789744]">ou</span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <a href="{{ route('login') }}"
                       class="w-full h-12 rounded-full border border-[#789744] text-[#789744] flex items-center justify-center text-lg">
                        Fazer login
                    </a>

                </form>
            </div>
        </div>

        <!-- Right: Image -->
        <div class="hidden lg:block h-full">
            <img
                src="{{ asset('images/img4.png') }}"
                class="w-full h-full object-cover"
                alt="Cadastro"
            >
        </div>

    </div>
</div>
</body>
</html>
