<x-app-layout>
    <x-sidebar-nav-user active="home">
        
        {{-- Ocupa a tela toda, fundo branco, sem o quadrado flutuante do Breeze --}}
        <div class="w-full min-h-screen bg-white p-6 sm:p-10 lg:p-12">

            {{-- Boas-vindas --}}
            <h1 class="text-3xl sm:text-4xl font-normal text-gray-800 leading-tight">
                Seja bem-vindo,
                <strong class="block font-bold mt-1">{{ Auth::user()->name }}!</strong>
            </h1>

            {{-- ── Doação Aprovada / Agendada ── --}}
            @isset($doacaoAgendada)
            @php
                $dataRetirada = \Carbon\Carbon::parse($doacaoAgendada->updated_at ?? now())->addDay();
                $enderecoCompleto = $doacaoAgendada->store->rua && $doacaoAgendada->store->numero
                    ? $doacaoAgendada->store->rua . ', ' . $doacaoAgendada->store->numero . 
                      ($doacaoAgendada->store->bairro ? ' - ' . $doacaoAgendada->store->bairro : '')
                    : ($doacaoAgendada->store->address ?? 'Endereço da loja não cadastrado');
            @endphp

            <div class="flex flex-col lg:flex-row items-stretch bg-white rounded-xl shadow-md overflow-hidden mt-8 border border-green-100">

                {{-- Imagem Lateral --}}
                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&auto=format&fit=crop&q=80"
                    alt="Foto da doação aprovada"
                    class="w-full lg:w-56 h-56 lg:h-auto object-cover flex-shrink-0">

                {{-- Corpo Central - Informações da Loja e Produto --}}
                <div class="flex-1 p-6 flex flex-col justify-between min-w-0">
                    
                    {{-- Status Badge --}}
                    <div class="mb-3">
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-800 text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Doação Aprovada
                        </span>
                    </div>

                    {{-- Nome da Loja --}}
                    <h3 class="text-xl font-bold text-gray-900 mt-1 mb-3 truncate">
                        {{ $doacaoAgendada->store->name ?? 'Loja não informada' }}
                    </h3>

                    {{-- Endereço da Loja com Ícone --}}
                    <div class="flex items-start gap-2 mb-4">
                        <svg class="w-5 h-5 text-[#841A1A] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-gray-700 leading-snug break-words">
                                {{ $enderecoCompleto }}
                            </p>
                            @if ($doacaoAgendada->store->cep)
                                <p class="text-xs text-gray-500 mt-0.5">CEP: {{ $doacaoAgendada->store->cep }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Divisória --}}
                    <div class="border-t border-gray-200 my-4"></div>

                    {{-- Informações do Produto --}}
                    <div class="space-y-2">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">Produto:</span> 
                            <span class="text-[#841A1A] font-semibold">{{ $doacaoAgendada->batch->product->name ?? 'Produto não informado' }}</span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">Quantidade:</span> 
                            <span class="text-gray-600">
                                {{ $doacaoAgendada->quantity }} unidades
                            </span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">Validade:</span> 
                            <span class="text-gray-600">{{ \Carbon\Carbon::parse($doacaoAgendada->batch->expiration_date)->format('d/m/Y') }}</span>
                        </p>
                    </div>
                </div>

                {{-- Painel Lateral Direito - Informações de Retirada --}}
                <div class="flex flex-col items-center justify-center gap-3 bg-gradient-to-b from-gray-50 to-gray-100 border-t lg:border-t-0 lg:border-l border-gray-200 px-6 py-6 lg:py-8 lg:min-w-[280px] text-center">
                    
                    {{-- Texto de Instruções --}}
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest">
                        Retire seu produto até:
                    </p>

                    {{-- Data Limite em Destaque --}}
                    <div class="bg-white border-2 border-[#841A1A] rounded-xl p-4 shadow-sm w-full">
                        <p class="text-3xl font-black text-[#841A1A] tracking-tight tabular-nums leading-tight">
                            {{ $dataRetirada->format('d/m/Y') }}
                        </p>
                        <p class="text-xs text-gray-600 font-medium mt-1">
                            Horário comercial
                        </p>
                    </div>

                    {{-- Aviso ao Usuário --}}
                    <p class="text-xs text-gray-600 leading-relaxed max-w-xs">
                        Apresente seu nome de usuário <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span> ao gerente para coleta.
                    </p>

                    {{-- Botão CTA --}}
                    <a href="{{ route('user.doacoes') }}" 
                       class="w-full mt-2 inline-flex items-center justify-center rounded-full bg-[#841A1A] hover:bg-[#6b1515] px-5 py-3 text-sm font-semibold text-white transition-colors duration-200 shadow-md hover:shadow-lg">
                        Ver Minhas Doações
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
            @endisset

            {{-- ── Recentes ── --}}
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mt-12 mb-5">Recente</h2>

            <div class="flex flex-col gap-3">
                @isset($doacoesRecentes)
                    @forelse($doacoesRecentes as $doacao)
                    @php
                        $exp = \Carbon\Carbon::parse($doacao->batch->expiration_date ?? now());
                    @endphp
                    <details class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">

                        <summary class="flex items-center justify-between px-4 sm:px-5 py-4 cursor-pointer list-none gap-2 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="flex-shrink-0">
                                    <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z"
                                          stroke="#841A1A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-base font-semibold text-gray-800 truncate">
                                        {{ $doacao->batch->product->name ?? 'Produto não informado' }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-0.5 truncate">
                                        {{ $doacao->quantity }} un.
                                        &bull; {{ $doacao->store->name ?? 'Loja não informada' }}
                                        &bull; {{ $exp->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <span class="flex-shrink-0 bg-[#841A1A] text-white text-xs sm:text-sm font-semibold
                                         rounded-full px-4 sm:px-5 py-2 flex items-center gap-1.5 shadow-sm">
                                Detalhes
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     class="transition-transform duration-200 group-open:rotate-180">
                                    <path d="M6 9l6 6 6-6" stroke="white" stroke-width="2.2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </summary>

                        <div class="border-t border-gray-100 bg-gray-50/50 px-4 sm:px-5 py-4">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                <span class="text-base font-bold text-gray-800">
                                    {{ $doacao->batch->product->name ?? 'Produto não informado' }}
                                </span>
                                <div class="flex flex-wrap items-center gap-4">
                                    <span class="flex items-center gap-1.5 text-sm text-gray-600">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/>
                                            <path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/>
                                        </svg>
                                        {{ $exp->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center gap-1.5 text-sm text-gray-600">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/>
                                            <path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Lote: {{ $doacao->batch->batch_number ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Categoria: <span class="font-medium text-gray-700">{{ $doacao->batch->product->category ?? 'N/A' }}</span>
                                <span class="mx-2">&bull;</span> 
                                Status: <span class="font-medium text-gray-700">{{ ucfirst($doacao->status) }}</span>
                            </p>
                        </div>

                    </details>
                    @empty
                    <p class="text-base text-gray-500 mt-4">Nenhuma doação recente encontrada.</p>
                    @endforelse
                @else
                    <p class="text-base text-gray-500 mt-4">Nenhuma doação recente encontrada.</p>
                @endisset
            </div>

        </div>

    </x-sidebar-nav-user>
</x-app-layout>