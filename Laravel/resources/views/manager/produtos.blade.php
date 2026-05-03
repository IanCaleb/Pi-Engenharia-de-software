<x-app-layout>
    <x-sidebar-nav-manager active="produtos">
        @php
        $produtos = [
        ['nome' => 'Pão Integral', 'categoria' => 'Padaria', 'quantidade' => 20, 'validade' => '14/04/2026', 'adicionado' => '14/03/2026', 'dias' => 18, 'status' => 'ok'],
        ['nome' => 'Iogurte Natural', 'categoria' => 'Laticínios', 'quantidade' => 30, 'validade' => '20/03/2026', 'adicionado' => '09/03/2026', 'dias' => -6, 'status' => 'vencido'],
        ['nome' => 'Leite Integral 1L','categoria' => 'Laticínios', 'quantidade' => 45, 'validade' => '24/03/2026', 'adicionado' => '28/02/2026', 'dias' => -2, 'status' => 'critico'],
        ['nome' => 'Pão Integral', 'categoria' => 'Padaria', 'quantidade' => 20, 'validade' => '14/04/2026', 'adicionado' => '14/03/2026', 'dias' => 18, 'status' => 'ok'],
        ['nome' => 'Iogurte Natural', 'categoria' => 'Laticínios', 'quantidade' => 30, 'validade' => '20/03/2026', 'adicionado' => '09/03/2026', 'dias' => -6, 'status' => 'vencido'],
        ['nome' => 'Leite Integral 1L','categoria' => 'Laticínios', 'quantidade' => 45, 'validade' => '24/03/2026', 'adicionado' => '28/02/2026', 'dias' => -2, 'status' => 'critico'],
        ['nome' => 'Pão Integral', 'categoria' => 'Padaria', 'quantidade' => 20, 'validade' => '14/04/2026', 'adicionado' => '14/03/2026', 'dias' => 18, 'status' => 'ok'],
        ['nome' => 'Iogurte Natural', 'categoria' => 'Laticínios', 'quantidade' => 30, 'validade' => '20/03/2026', 'adicionado' => '09/03/2026', 'dias' => -6, 'status' => 'vencido'],
        ['nome' => 'Leite Integral 1L','categoria' => 'Laticínios', 'quantidade' => 45, 'validade' => '24/03/2026', 'adicionado' => '28/02/2026', 'dias' => -2, 'status' => 'critico'],
        ];
        @endphp

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

            {{-- ── Barra de busca ── --}}
            <div class="mb-8">
                <label for="busca-produto" class="sr-only">Buscar produtos</label>
                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-2.5 shadow-sm">
                    <svg class="h-4 w-4 shrink-0 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                        <path d="M21 21l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <input
                        id="busca-produto"
                        type="search"
                        placeholder="Buscar produtos..."
                        class="flex-1 border-none bg-transparent text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">
                </div>
            </div>

            {{-- ── Grade de produtos ── --}}
            <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3" role="list">

                @foreach ($produtos as $produto)

                @php
                // Badge de vencimento
                if ($produto['status'] === 'vencido') {
                $badgeBg = 'bg-red-500';
                $badgeText = 'text-white';
                $showBtn = true;
                } elseif ($produto['status'] === 'critico') {
                $badgeBg = 'bg-yellow-400';
                $badgeText = 'text-gray-900';
                $showBtn = true;
                } else {
                $badgeBg = 'bg-gray-100';
                $badgeText = 'text-gray-700';
                $showBtn = false;
                }

                $labelDias = $produto['dias'] >= 0
                ? 'Vence em ' . $produto['dias'] . ' dias'
                : 'Vencido há ' . abs($produto['dias']) . ' dias';
                @endphp

                <li class="flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    {{-- Topo do card --}}
                    <div class="mb-4 flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            {{-- Ícone produto --}}
                            <svg class="h-5 w-5 shrink-0 text-gray-700" viewBox="0 0 24 24" fill="none">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <h2 class="font-bold text-gray-900">{{ $produto['nome'] }}</h2>
                        </div>

                        @if ($produto['status'] !== 'ok')
                        {{-- Ícone de alerta para produtos próximos do vencimento --}}
                        <svg class="h-5 w-5 shrink-0 text-orange-400" viewBox="0 0 24 24" fill="none" aria-label="Atenção: produto próximo ao vencimento">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8" />
                            <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        @endif
                    </div>

                    {{-- Categoria --}}
                    <p class="mb-4 text-sm text-gray-500">{{ $produto['categoria'] }}</p>

                    {{-- Dados do produto --}}
                    <dl class="mb-4 space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Quantidade:</dt>
                            <dd class="font-semibold text-gray-800">{{ $produto['quantidade'] }} unidades</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Validade:</dt>
                            <dd class="font-semibold text-gray-800">{{ $produto['validade'] }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Adicionado em:</dt>
                            <dd class="font-semibold text-gray-800">{{ $produto['adicionado'] }}</dd>
                        </div>
                    </dl>

                    {{-- Badge de dias --}}
                    <span class="mb-4 inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badgeBg }} {{ $badgeText }}">
                        {{ $labelDias }}
                    </span>

                    {{-- Botão doação (apenas para críticos/vencidos) --}}
                    @if ($showBtn)
                    <button
                        type="button"
                        class="mt-auto w-full rounded-lg bg-[#08273B] py-2.5 text-sm font-semibold text-white transition hover:bg-[#0a3350]">
                        Disponibilizar para Doação
                    </button>
                    @endif

                </li>

                @endforeach

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

                    {{-- Formulário --}}
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
                                name="nome"
                                placeholder="Ex: Leite Integral 1L"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
                        </div>

                        {{-- Categoria --}}
                        <div>
                            <label for="categoria" class="mb-1 block text-sm font-medium text-gray-700">
                                Categoria
                            </label>
                            <input
                                id="categoria"
                                type="text"
                                name="categoria"
                                placeholder="Ex: Laticínios"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
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
                                    name="quantidade"
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
                                    name="data_validade"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-[#749048] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#749048]">
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