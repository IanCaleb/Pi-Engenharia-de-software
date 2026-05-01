<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buscar Lojas - ValidControl</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body class="bg-[#1f1f1f] text-[#222]">

    @php
    /*
    * Em produção, esses dados virão do controller:
    * $lojasProximas = App\Models\Loja::proximas(auth()->user())->get();
    * $ultimasLojas = App\Models\Loja::recentes()->get();
    * $cidadeSelecionada = request('cidade');
    */

    $lojasProximas = [
        [
            'nome'      => 'Açaí Atacadista',
            'cidade'    => 'Juazeiro do Norte',
            'status'    => 'Disponível',
            'data'      => '30/03/2026',
            'remessa'   => [
                'titulo'   => 'Remessa de Frutas',
                'data'     => '30/03/2026',
                'hora'     => '09:00',
                'endereco' => 'Av. Padre Cícero, 4.400 - São José, Juazeiro do Norte - CE, 63024-015',
            ],
        ],
        [
            'nome'      => 'Atacadão',
            'cidade'    => 'Juazeiro do Norte',
            'status'    => 'Disponível',
            'data'      => '10/02/2026',
            'remessa'   => [
                'titulo'   => 'Entrega de Hortaliças',
                'data'     => '02/04/2026',
                'hora'     => '14:30',
                'endereco' => 'Rua São Pedro, 1.250 - Centro, Juazeiro do Norte - CE, 63010-010',
            ],
        ],
        [
            'nome'      => 'Rcarvalho - Loja 01',
            'cidade'    => 'Juazeiro do Norte',
            'status'    => 'Disponível',
            'data'      => '20/01/2026',
            'remessa'   => [
                'titulo'   => 'Transporte de Grãos',
                'data'     => '05/04/2026',
                'hora'     => '07:45',
                'endereco' => 'Av. Leão Sampaio, 2.100 - Lagoa Seca, Juazeiro do Norte - CE, 63040-000',
            ],
        ],
        [
            'nome'      => 'Supermercado Diniz - loja 01',
            'cidade'    => 'Juazeiro do Norte',
            'status'    => 'Disponível',
            'data'      => '05/01/2026',
            'remessa'   => [
                'titulo'   => 'Coleta de Verduras',
                'data'     => '07/04/2026',
                'hora'     => '16:20',
                'endereco' => 'Rua do Cruzeiro, 980 - Salesianos, Juazeiro do Norte - CE, 63050-250',
            ],
        ],
    ];

    $ultimasLojas = [
        [
            'nome'    => 'Açaí Atacadista',
            'cidade'  => 'Juazeiro do Norte',
            'status'  => 'Disponível',
            'data'    => '05/03/2026',
            'remessa' => [
                'titulo'   => 'Distribuição de Legumes',
                'data'     => '10/04/2026',
                'hora'     => '11:10',
                'endereco' => 'Av. Ailton Gomes, 3.300 - Pirajá, Juazeiro do Norte - CE, 63034-000',
            ],
        ],
        [
            'nome'    => 'Atacadão',
            'cidade'  => 'Juazeiro do Norte',
            'status'  => 'Disponível',
            'data'    => '10/02/2026',
            'remessa' => [
                'titulo'   => 'Entrega de Hortaliças',
                'data'     => '02/04/2026',
                'hora'     => '14:30',
                'endereco' => 'Rua São Pedro, 1.250 - Centro, Juazeiro do Norte - CE, 63010-010',
            ],
        ],
        [
            'nome'    => 'Supermercado Diniz - loja 04',
            'cidade'  => 'Juazeiro do Norte',
            'status'  => 'Disponível',
            'data'    => '20/01/2026',
            'remessa' => [
                'titulo'   => 'Transporte de Grãos',
                'data'     => '05/04/2026',
                'hora'     => '07:45',
                'endereco' => 'Av. Leão Sampaio, 2.100 - Lagoa Seca, Juazeiro do Norte - CE, 63040-000',
            ],
        ],
        [
            'nome'    => 'Supermercado Diniz - loja 05',
            'cidade'  => 'Crato - CE',
            'status'  => 'Disponível',
            'data'    => '05/01/2026',
            'remessa' => [
                'titulo'   => 'Coleta de Verduras',
                'data'     => '07/04/2026',
                'hora'     => '16:20',
                'endereco' => 'Rua do Cruzeiro, 980 - Salesianos, Juazeiro do Norte - CE, 63050-250',
            ],
        ],
    ];
    @endphp

    <div class="min-h-screen">
        <div class="w-full overflow-hidden bg-white">

            {{-- ═══════════════ TOPBAR ═══════════════ --}}
            <header class="flex h-[70px] items-center justify-between bg-[#08273B] px-8 text-white">
                <div class="flex items-center gap-3">
                    {{-- Ícone carrinho --}}
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none">
                        <path d="M4 5h14l-1.2 7.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.7L5.2 5Z" stroke="white" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M9 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM16 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" stroke="white" stroke-width="1.8" />
                        <path d="M3 3h2l.2 2" stroke="white" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                    <span class="text-xl font-semibold tracking-tight">ValidControl</span>
                </div>

                <div class="flex items-center gap-8">
                    {{-- Sino --}}
                    <button class="transition hover:scale-105">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.7 19a2 2 0 0 1-3.4 0" stroke="white" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                    </button>

                    {{-- Avatar --}}
                    <button class="grid h-11 w-11 place-items-center rounded-full bg-white text-[#1e2d16] transition hover:scale-105">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                            <path d="M20 21a8 8 0 0 0-16 0" stroke="#1e2d16" stroke-width="1.7" stroke-linecap="round" />
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="#1e2d16" stroke-width="1.7" />
                        </svg>
                    </button>
                </div>
            </header>

            <div class="flex min-h-[760px]">

                {{-- ═══════════════ SIDEBAR ═══════════════ --}}
                <aside class="w-[240px] bg-[#789747] px-3 py-4 text-white">
                    <button class="mb-8 ml-1 text-[#063242]">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" />
                        </svg>
                    </button>

                    <nav class="space-y-3">
                        {{-- Home --}}
                        <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z" stroke="white" stroke-width="1.6" stroke-linejoin="round" />
                                <path d="M9 21V12h6v9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Home
                        </a>

                        {{-- Buscar lojas — ativo --}}
                        <a href="#" class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/20 px-5 py-3 text-[17px] font-medium text-black shadow-sm">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7" />
                                <path d="M21 21l-3.5-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                            Buscar lojas
                        </a>

                        {{-- Doações --}}
                        <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Doações
                        </a>
                    </nav>
                </aside>

                {{-- ═══════════════ CONTEÚDO PRINCIPAL ═══════════════ --}}
                <main class="flex-1 bg-white px-10 py-8">

                    {{-- Barra de busca --}}
                    <div class="mb-8 flex items-center gap-3">
                        <div class="flex flex-1 items-center overflow-hidden rounded-full border border-gray-300 bg-white shadow-sm">
                            <input
                                type="text"
                                name="busca"
                                placeholder="Encontre insumos"
                                value="{{ request('busca') }}"
                                class="flex-1 border-none bg-transparent px-5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">
                            <button class="flex h-10 w-14 items-center justify-center rounded-r-full bg-[#08273B] text-white transition hover:bg-[#0a3350]">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="7" stroke="white" stroke-width="2" />
                                    <path d="M21 21l-3.5-3.5" stroke="white" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>

                        {{-- Botão filtro — abre o painel de filtros --}}
                        <button
                            id="btn-filtro"
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50"
                            title="Filtros">
                            <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none">
                                <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>

                        {{-- Painel de filtros (oculto por padrão, Alpine.js) --}}
                        <div
                            id="painel-filtro"
                            x-data="{ aberto: false, cidade: '' }"
                            x-show="aberto"
                            @toggle-filtro.window="aberto = !aberto"
                            @click.outside="aberto = false"
                            x-transition
                            class="absolute right-[calc(50%-560px+40px)] top-[130px] z-50 w-[220px] rounded-xl border border-gray-200 bg-white shadow-lg"
                            style="display: none;">
                            <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>

                            <div class="px-4 py-3">
                                <button
                                    @click="cidade = cidade === '' ? 'ativo' : ''"
                                    class="flex w-full items-center justify-between text-sm font-medium text-[#1e2d16]">
                                    <span>Cidade</span>
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                <div x-show="cidade !== ''" x-transition class="mt-3 space-y-2">
                                    @foreach (['Juazeiro do Norte', 'Crato', 'Barbalha'] as $cidade)
                                    <button
                                        class="w-full rounded-full border px-4 py-1.5 text-sm transition
                                            {{ request('cidade') === $cidade
                                                ? 'border-[#8B1A1A] bg-[#8B1A1A] text-white'
                                                : 'border-gray-300 text-gray-700 hover:border-[#8B1A1A] hover:text-[#8B1A1A]' }}">
                                        {{ $cidade }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Seção: Próximo de você ── --}}
                    <section class="mb-8">
                        <h2 class="mb-4 text-lg font-semibold text-[#1e2d16]">Próximo de você:</h2>

                        <div class="space-y-3">
                            @foreach ($lojasProximas as $loja)
                            <div
                                x-data="{ aberto: false }"
                                class="rounded-xl border border-gray-100 bg-gray-50 px-5 py-4 shadow-sm"
                            >
                                {{-- Linha principal --}}
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        {{-- Ícone presente --}}
                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white shadow-sm">
                                            <svg class="h-5 w-5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#1e2d16]">{{ $loja['nome'] }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $loja['cidade'] }} • {{ $loja['status'] }} • {{ $loja['data'] }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Botão: alterna entre Detalhes / Solicitar doação --}}
                                    <button
                                        @click="aberto = !aberto"
                                        x-text="aberto ? 'Solicitar doação' : 'Detalhes'"
                                        :class="aberto
                                            ? 'rounded-full bg-[#8B1A1A] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#721515]'
                                            : 'rounded-full bg-[#8B1A1A] px-6 py-2 text-sm font-medium text-white transition hover:bg-[#721515]'"
                                    ></button>
                                </div>

                                {{-- Detalhes expandidos (remessa) — visível apenas quando aberto --}}
                                @if (isset($loja['remessa']))
                                <div x-show="aberto" x-transition class="mt-4 ml-[52px] space-y-1">
                                    <div class="flex items-center gap-3 text-sm font-semibold text-[#1e2d16]">
                                        <span>{{ $loja['remessa']['titulo'] }}</span>

                                        {{-- Data --}}
                                        <span class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                            <svg class="h-3.5 w-3.5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7" />
                                                <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                            </svg>
                                            {{ $loja['remessa']['data'] }}
                                        </span>

                                        {{-- Hora --}}
                                        <span class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                            <svg class="h-3.5 w-3.5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7" />
                                                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                            </svg>
                                            {{ $loja['remessa']['hora'] }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-gray-500">{{ $loja['remessa']['endereco'] }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- ── Seção: Últimas Lojas ── --}}
                    <section>
                        <h2 class="mb-4 text-lg font-semibold text-[#1e2d16]">Ultimas Lojas:</h2>

                        <div class="space-y-3">
                            @foreach ($ultimasLojas as $loja)
                            <div
                                x-data="{ aberto: false }"
                                class="rounded-xl border border-gray-100 bg-gray-50 px-5 py-4 shadow-sm"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white shadow-sm">
                                            <svg class="h-5 w-5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#1e2d16]">{{ $loja['nome'] }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $loja['cidade'] }} • {{ $loja['status'] }} • {{ $loja['data'] }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Botão: alterna entre Detalhes / Solicitar doação --}}
                                    <button
                                        @click="aberto = !aberto"
                                        x-text="aberto ? 'Solicitar doação' : 'Detalhes'"
                                        :class="aberto
                                            ? 'rounded-full bg-[#8B1A1A] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#721515]'
                                            : 'rounded-full bg-[#8B1A1A] px-6 py-2 text-sm font-medium text-white transition hover:bg-[#721515]'"
                                    ></button>
                                </div>

                                {{-- Detalhes expandidos (remessa) --}}
                                @if (isset($loja['remessa']))
                                <div x-show="aberto" x-transition class="mt-4 ml-[52px] space-y-1">
                                    <div class="flex items-center gap-3 text-sm font-semibold text-[#1e2d16]">
                                        <span>{{ $loja['remessa']['titulo'] }}</span>

                                        {{-- Data --}}
                                        <span class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                            <svg class="h-3.5 w-3.5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7" />
                                                <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                            </svg>
                                            {{ $loja['remessa']['data'] }}
                                        </span>

                                        {{-- Hora --}}
                                        <span class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                            <svg class="h-3.5 w-3.5 text-[#8B1A1A]" viewBox="0 0 24 24" fill="none">
                                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7" />
                                                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                            </svg>
                                            {{ $loja['remessa']['hora'] }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-gray-500">{{ $loja['remessa']['endereco'] }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </section>

                </main>
            </div>
        </div>
    </div>

    <script>
        // Conecta botão de filtro ao Alpine
        document.getElementById('btn-filtro')?.addEventListener('click', () => {
            window.dispatchEvent(new CustomEvent('toggle-filtro'));
        });
    </script>

</body>

</html>