<x-app-layout>
    <x-sidebar-nav-manager active="produtos">

        {{-- ═══════════════════════════════════════════
             WRAPPER PRINCIPAL — ocupa toda a área após
             a sidebar sem max-width nem margens automáticas
        ════════════════════════════════════════════════ --}}
        <div
            x-data="{ modalAberto: false }"
            class="w-full bg-gray-50 px-4 py-6 sm:px-6 sm:py-8 lg:px-8 min-h-screen">

            {{-- ── Cabeçalho da página ── --}}
            <header class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Listagem de Produtos</h1>
                    <p class="mt-1 text-sm text-gray-500">Gerencie os produtos e suas validades</p>
                </div>

                <button
                    @click="modalAberto = true"
                    class="w-full justify-center sm:w-auto inline-flex shrink-0 items-center gap-2 rounded-lg bg-[#08273B] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0a3350] sm:mt-0">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                    Adicionar Produto
                </button>
            </header>

            {{-- ── Barra de busca e Filtros ── --}}
            <form method="GET" action="{{ route('manager.produtos') }}" class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center">
                
                {{-- Input de Texto (Busca) --}}
                <div class="flex-1">
                    <label for="busca-produto" class="sr-only">Buscar produtos</label>
                    <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-2.5 shadow-sm focus-within:border-[#749048] focus-within:ring-1 focus-within:ring-[#749048]">
                        <svg class="h-4 w-4 shrink-0 text-gray-400" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                            <path d="M21 21l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <input
                            id="busca-produto"
                            name="search"
                            type="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por nome ou categoria..."
                            class="flex-1 border-none bg-transparent text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">
                    </div>
                </div>

                {{-- Dropdown de Status (Filtro) --}}
                <div class="sm:w-48 shrink-0">
                    <label for="filtro-status" class="sr-only">Filtrar por status</label>
                    <select 
                        id="filtro-status" 
                        name="status"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm focus:border-[#749048] focus:outline-none focus:ring-1 focus:ring-[#749048]">
                        <option value="">Todos os status</option>
                        <option value="expired" @selected(request('status') === 'expired')>Vencidos</option>
                        <option value="warning" @selected(request('status') === 'warning')>Perto do Vencimento</option>
                        <option value="safe" @selected(request('status') === 'safe')>Em dia</option>
                    </select>
                </div>

                {{-- Botões de Ação --}}
                <div class="flex items-center gap-2 shrink-0">
                    <button 
                        type="submit" 
                        class="rounded-xl bg-[#749048] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5f7a39]">
                        Filtrar
                    </button>
                    
                    {{-- Botão de limpar filtros (só aparece se houver alguma busca ativa) --}}
                    @if(request()->hasAny(['search', 'status']) && (request('search') != '' || request('status') != ''))
                        <a href="{{ route('manager.produtos') }}" 
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>

            {{-- ── Grade de produtos ── --}}
            <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3" role="list">

                @forelse ($batches as $batch)

                    @php
                        // Conectando o visual do Front com a lógica do Back
                        $status = $batch->expirationStatus();
                        $labelDias = $batch->expirationMessage();
        
                        if ($status === 'expired') {
                            $badgeBg = 'bg-red-500';
                            $badgeText = 'text-white';
                            $showBtn = true;
                        } elseif ($status === 'warning') {
                            $badgeBg = 'bg-yellow-400';
                            $badgeText = 'text-gray-900';
                            $showBtn = true;
                        } else {
                            $badgeBg = 'bg-green-500';
                            $badgeText = 'text-gray-700';
                            $showBtn = false;
                        }
                    @endphp

                <li class="flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                {{-- Topo do card (Com Alerta e Botão de Deletar) --}}
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-2">
                        {{-- Ícone produto (Atualizado para uma caixa) --}}
                        <svg class="h-5 w-5 shrink-0 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <h2 class="font-bold text-gray-900">{{ $batch->product->name }}</h2>
                    </div>

                    {{-- Grupo de ícones da direita (Alerta + Lixeira) --}}
                    <div class="flex items-center gap-2">
                        @if ($status !== 'safe')
                            {{-- Ícone de alerta --}}
                            <svg class="h-5 w-5 shrink-0 {{ $status === 'expired' ? 'text-red-500' : 'text-orange-400' }}" viewBox="0 0 24 24" fill="none" aria-label="Atenção">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8" />
                                <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        @endif

                        {{-- Mini-formulário de Delete --}}
                        <form 
                            action="{{ route('products.destroy', $batch->product->id) }}" 
                            method="POST" 
                            class="m-0 p-0"
                            onsubmit="return confirm('Tem certeza que deseja excluir o produto {{ $batch->product->name }}? Esta ação não pode ser desfeita.');">
                            
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="text-gray-400 transition hover:text-red-600" title="Excluir Produto">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Categoria --}}
                <p class="mb-4 text-sm text-gray-500">{{ $batch->product->category }}</p>

                {{-- Dados do produto --}}
                <dl class="mb-4 space-y-1 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Quantidade:</dt>
                        <dd class="font-semibold text-gray-800">{{ $batch->quantity }} unidades</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Validade:</dt>
                        <dd class="font-semibold text-gray-800">{{ $batch->expiration_date->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Adicionado em:</dt>
                        <dd class="font-semibold text-gray-800">{{ $batch->product->created_at->format('d/m/Y') }}</dd>
                    </div>
                </dl>

                {{-- Badge de dias --}}
                <span class="mb-4 inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badgeBg }} {{ $badgeText }}">
                    {{ $labelDias }}
                </span>

                {{-- Botão doação (apenas para críticos/vencidos) --}}
                @if ($showBtn)
                    <form action="{{ route('donations.store') }}" method="POST" class="mt-auto flex flex-col gap-3">
                        @csrf
                        
                        {{-- Envia o ID para o back-end de forma oculta --}}
                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">

                        {{-- Campinho para escolher a quantidade (o limite máximo é o que tem no estoque) --}}
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-3 py-2">
                            <label for="qtd-{{ $batch->product->id }}" class="text-xs font-medium text-gray-600">Qtd. a Doar:</label>
                            <input
                                type="number"
                                id="qtd-{{ $batch->id }}"
                                name="quantity"
                                min="1"
                                max="{{ $batch->quantity }}"
                                value="{{ $batch->quantity }}"
                                class="h-7 w-16 rounded border border-gray-300 p-1 text-center text-sm focus:border-[#749048] focus:ring-1 focus:ring-[#749048] focus:outline-none"
                                required>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-[#08273B] py-2.5 text-sm font-semibold text-white transition hover:bg-[#0a3350]">
                            Disponibilizar para Doação
                        </button>
                    </form>
                @endif

            </li>


                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Nenhum produto cadastrado no momento.
                    </div>
                @endforelse


            </ul>


            {{-- ═══════════════════════════════════════════
                 MODAL — Adicionar Novo Produto
            ════════════════════════════════════════════════ --}}
            <div
                x-show="modalAberto"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/40 px-0 sm:px-4"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-titulo"
                style="display: none;">
                {{-- Painel do modal --}}
                <div
                    x-show="modalAberto"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="modalAberto = false"
                    class="relative w-full sm:max-w-md rounded-t-2xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-xl max-h-[90vh] overflow-y-auto">
                    {{-- Botão fechar --}}
                    <button
                        @click="modalAberto = false"
                        class="absolute right-4 top-4 rounded-full p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                        aria-label="Fechar modal">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    {{-- Cabeçalho do modal --}}
                    <header class="mb-5">
                        <h2 id="modal-titulo" class="text-xl font-bold text-gray-900">
                            Adicionar Novo Produto
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Preencha os dados do produto para adicionar ao sistema
                        </p>
                    </header>

                    {{-- Formulário com atributos name atualizados para Inglês --}}
                    <form method="POST" action="{{ route('manager.produtos.store') }}" class="space-y-4">
                        @csrf

                        {{-- Nome do Produto --}}
                        <div>
                            <label for="nome_produto" class="mb-1 block text-sm font-medium text-gray-700">
                                Nome do Produto
                            </label>
                            <input
                                id="nome_produto"
                                type="text"
                                name="name" 
                                placeholder="Ex: Leite Integral 1L"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
                        </div>

                        {{-- Categoria --}}
                        <div>
                            <label for="categoria" class="mb-1 block text-sm font-medium text-gray-700">
                                Categoria
                            </label>
                            <select name="category" id="categoria" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
                                <option value="">Selecione uma categoria</option>
                                <option value="Laticínios">Laticínios</option>
                                <option value="limpeza">Limpeza</option>
                                <option value="congelados">Congelados</option>
                                <option value="entalados">Enlatados</option>
                                <option value="cereais">Leguminosas e Cereais</option>
                                <option value="Carnes">Carnes</option>
                                <option value="Hortifruti">Hortifruti</option>
                                <option value="Padaria">Padaria</option>
                                <option value="Bebidas">Bebidas</option>
                            </select>
                        </div>

                        {{-- Quantidade + Data de Validade na mesma linha --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantidade" class="mb-1 block text-sm font-medium text-gray-700">
                                    Quantidade
                                </label>
                                <input
                                    id="quantidade"
                                    type="number"
                                    name="quantity" 
                                    min="0"
                                    placeholder="0"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
                            </div>

                            <div>
                                <label for="data_validade" class="mb-1 block text-sm font-medium text-gray-700">
                                    Data de Validade
                                </label>
                                <input
                                    id="data_validade"
                                    type="date"
                                    name="expiration_date" 
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]"    min="{{ date('Y-m-d') }}" max="2036-12-31">
                            </div>
                        </div>

                        {{-- Botões de ação --}}
                        <footer class="flex justify-end gap-3 pt-2">
                            <button
                                type="button"
                                @click="modalAberto = false"
                                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                class="rounded-lg bg-[#08273B] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0a3350]">
                                Adicionar
                            </button>
                        </footer>
                    </form>

                </div>
            </div>
            {{-- /MODAL --}}

        </div>

    </x-sidebar-nav-manager>
</x-app-layout>