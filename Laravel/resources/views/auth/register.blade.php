<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{
        role: 'user',
        cep: '',
        rua: '',
        numero: '',
        bairro: '',
        addressStatus: '',
        addressError: '',
        isLoadingAddress: false,
        async validateCep(cepValue) {
            // Remove caracteres não numéricos
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
    }">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Papel')" />

            <select name="role" id="role" x-model="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="user">Usuário</option>
                <option value="manager">Gerente de loja</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>


        <div class="mt-4" x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
            <x-input-label for="city" :value="__('Cidade da Loja')" />

            <select name="city" id="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" x-bind:required="role === 'manager'">
                <option value="">Selecione uma cidade...</option>
                <option value="Juazeiro do Norte">Juazeiro do Norte</option>
                <option value="Crato">Crato</option>
                <option value="Barbalha">Barbalha</option>
            </select>

            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div class="mt-4" x-show="role === 'manager'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
            <!-- CEP -->
            <x-input-label for="cep" :value="__('CEP')" />
            
            <div class="relative">
                <x-text-input id="cep" class="block mt-1 w-full" 
                              type="text" 
                              name="cep" 
                              x-model="cep"
                              :value="old('cep')" 
                              placeholder="00000-000"
                              @blur="validateCep(cep)"
                              x-bind:required="role === 'manager'"
                              maxlength="9" />

                <!-- Indicador de carregamento -->
                <div class="absolute right-3 top-3" x-show="isLoadingAddress">
                    <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

            <x-input-error :messages="$errors->get('cep')" class="mt-2" />

            <!-- Rua -->
            <div class="mt-4">
                <x-input-label for="rua" :value="__('Rua')" />
                
                <x-text-input id="rua" class="block mt-1 w-full" 
                              type="text" 
                              name="rua" 
                              x-model="rua"
                              :value="old('rua')" 
                              placeholder="Preenchido automaticamente"
                              x-bind:disabled="addressStatus !== 'valido'" />

                <x-input-error :messages="$errors->get('rua')" class="mt-2" />
            </div>

            <!-- Número -->
            <div class="mt-4">
                <x-input-label for="numero" :value="__('Número')" />
                
                <x-text-input id="numero" class="block mt-1 w-full" 
                              type="text" 
                              name="numero" 
                              x-model="numero"
                              :value="old('numero')" 
                              placeholder="Ex: 123"
                              x-bind:required="role === 'manager'"
                              x-bind:disabled="addressStatus !== 'valido'" />

                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
            </div>

            <!-- Bairro -->
            <div class="mt-4">
                <x-input-label for="bairro" :value="__('Bairro')" />
                
                <x-text-input id="bairro" class="block mt-1 w-full" 
                              type="text" 
                              name="bairro" 
                              x-model="bairro"
                              :value="old('bairro')" 
                              placeholder="Preenchido automaticamente"
                              x-bind:required="role === 'manager'"
                              x-bind:disabled="addressStatus !== 'valido'" />

                <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirme sua senha')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Já tem uma conta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>