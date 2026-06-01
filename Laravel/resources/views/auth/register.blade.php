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
        <div class="h-screen overflow-y-auto flex items-center justify-center px-4 py-8 md:px-8">
            <div class="w-full max-w-md">
                <h1 class="text-4xl font-light text-[#6E8F2A]">Faça seu cadastro</h1>
                <p class="text-xl text-gray-400 mb-8">Crie sua conta aqui!</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" x-data="{
                    role: 'user',
                    cep: '',
                    rua: '',
                    numero: '',
                    bairro: '',
                    city: '',
                    addressStatus: '',
                    addressError: '',
                    isLoadingAddress: false,
                    async validateCep(cepValue) {
                        const cleanCep = cepValue.replace(/\D/g, '');

                        if (cleanCep.length !== 8) {
                            this.addressStatus = '';
                            this.addressError = '';
                            this.rua = '';
                            this.bairro = '';
                            return;
                        }

                        this.isLoadingAddress = true;
                        this.addressStatus = 'validando';
                        this.addressError = '';

                        try {
                            const apiUrl = `https://viacep.com.br/ws/${cleanCep}/json/`;
                            const response = await fetch(apiUrl);
                            const data = await response.json();

                            if (data.erro) {
                                this.addressStatus = 'erro';
                                this.addressError = 'CEP não encontrado';
                                this.rua = '';
                                this.bairro = '';
                            } else {
                                this.addressStatus = 'valido';
                                this.rua = data.logradouro;
                                this.bairro = data.bairro;
                            }
                        } catch (error) {
                            this.addressStatus = 'erro';
                            this.addressError = 'Erro ao validar CEP. Tente novamente.';
                            this.rua = '';
                            this.bairro = '';
                            console.error('Erro na validação:', error);
                        } finally {
                            this.isLoadingAddress = false;
                        }
                    }
                }" class="space-y-4">
                    @csrf

                    <!-- Nome -->
                    <div>
                        <label for="name" class="text-lg text-gray-500 mb-2 block">Nome</label>
                        <input
                            id="name"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="text-lg text-gray-500 mb-2 block">E-mail</label>
                        <input
                            id="email"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <!-- Tipo de usuário -->
                    <div>
                        <label for="role" class="text-lg text-gray-500 mb-2 block">Tipo de usuário</label>
                        <select id="role" name="role" x-model="role" class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]">
                            <option value="user">Usuário</option>
                            <option value="manager">Gerente de loja</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                    </div>

                    <!-- Cidade (apenas para gerente) -->
                    <div x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <label for="city" class="text-lg text-gray-500 mb-2 block">Cidade da Loja</label>
                        <select id="city" name="city" x-model="city" class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]" x-bind:required="role === 'manager'">
                            <option value="">Selecione uma cidade...</option>
                            <option value="Juazeiro do Norte">Juazeiro do Norte</option>
                            <option value="Crato">Crato</option>
                            <option value="Barbalha">Barbalha</option>
                        </select>
                        <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                    </div>

                    <!-- CEP (apenas para gerente) -->
                    <div x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <label for="cep" class="text-lg text-gray-500 mb-2 block">CEP</label>
                        <div class="relative">
                            <input
                                id="cep"
                                class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]"
                                type="text"
                                name="cep"
                                x-model="cep"
                                :value="old('cep')"
                                placeholder="00000-000"
                                @blur="validateCep(cep)"
                                x-bind:required="role === 'manager'"
                                maxlength="9"
                            />
                            <!-- Indicador de carregamento -->
                            <div class="absolute right-3 top-3" x-show="isLoadingAddress">
                                <svg class="animate-spin h-5 w-5 text-[#789744]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <!-- Ícone de validação -->
                            <div class="absolute right-3 top-3" x-show="addressStatus === 'valido'">
                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <!-- Ícone de erro -->
                            <div class="absolute right-3 top-3" x-show="addressStatus === 'erro'">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <!-- Mensagem de erro -->
                        <div x-show="addressStatus === 'erro'" class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                            <p class="text-sm text-red-700" x-text="addressError || 'Erro ao validar CEP'"></p>
                        </div>
                        <x-input-error :messages="$errors->get('cep')" class="mt-2"/>
                    </div>

                    <!-- Rua (apenas para gerente) -->
                    <div x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <label for="rua" class="text-lg text-gray-500 mb-2 block">Rua</label>
                        <input
                            id="rua"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744] disabled:bg-gray-100"
                            type="text"
                            name="rua"
                            x-model="rua"
                            :value="old('rua')"
                            placeholder="Preenchido automaticamente"
                            x-bind:required="role === 'manager'"
                            x-bind:disabled="addressStatus !== 'valido'"
                        />
                        <x-input-error :messages="$errors->get('rua')" class="mt-2"/>
                    </div>

                    <!-- Número (apenas para gerente) -->
                    <div x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <label for="numero" class="text-lg text-gray-500 mb-2 block">Número</label>
                        <input
                            id="numero"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744] disabled:bg-gray-100"
                            type="text"
                            name="numero"
                            x-model="numero"
                            :value="old('numero')"
                            placeholder="Ex: 123"
                            x-bind:required="role === 'manager'"
                            x-bind:disabled="addressStatus !== 'valido'"
                        />
                        <x-input-error :messages="$errors->get('numero')" class="mt-2"/>
                    </div>

                    <!-- Bairro (apenas para gerente) -->
                    <div x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <label for="bairro" class="text-lg text-gray-500 mb-2 block">Bairro</label>
                        <input
                            id="bairro"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744] disabled:bg-gray-100"
                            type="text"
                            name="bairro"
                            x-model="bairro"
                            :value="old('bairro')"
                            placeholder="Preenchido automaticamente"
                            x-bind:required="role === 'manager'"
                            x-bind:disabled="addressStatus !== 'valido'"
                        />
                        <x-input-error :messages="$errors->get('bairro')" class="mt-2"/>
                    </div>

                    <!-- Senha -->
                    <div>
                        <label for="password" class="text-lg text-gray-500 mb-2 block">Senha</label>
                        <input
                            id="password"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]"
                            type="password"
                            name="password"
                            required
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <!-- Confirmar Senha -->
                    <div>
                        <label for="password_confirmation" class="text-lg text-gray-500 mb-2 block">Confirme sua senha</label>
                        <input
                            id="password_confirmation"
                            class="w-full h-12 rounded-lg border border-gray-300 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#789744]"
                            type="password"
                            name="password_confirmation"
                            required
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                    </div>

                    <!-- Botão Cadastrar -->
                    <button type="submit" class="w-full h-12 rounded-full justify-center text-lg bg-[#789744] text-white font-semibold hover:bg-[#6a7c3a] transition mt-6">
                        Cadastrar
                    </button>

                    <!-- Divisor -->
                    <div class="flex items-center gap-4 my-4">
                        <div class="h-px bg-gray-300 flex-1"></div>
                        <span class="text-[#789744]">ou</span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <!-- Link Login -->
                    <a href="{{ route('login') }}" class="w-full h-12 rounded-full border border-[#789744] text-[#789744] flex items-center justify-center text-lg font-semibold hover:bg-[#f5f5f5] transition">
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
