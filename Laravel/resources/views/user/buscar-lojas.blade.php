<x-app-layout>
    <x-sidebar-nav-user active="buscar-lojas">
        @php
        $lojasProximas = [
            ['nome' => 'Açaí Atacadista', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '30/03/2026',
             'remessa' => ['titulo' => 'Remessa de Frutas', 'data' => '30/03/2026', 'hora' => '09:00', 'endereco' => 'Av. Padre Cícero, 4.400 - São José, Juazeiro do Norte - CE, 63024-015']],
            ['nome' => 'Atacadão', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '10/02/2026',
             'remessa' => ['titulo' => 'Entrega de Hortaliças', 'data' => '02/04/2026', 'hora' => '14:30', 'endereco' => 'Rua São Pedro, 1.250 - Centro, Juazeiro do Norte - CE, 63010-010']],
            ['nome' => 'Rcarvalho - Loja 01', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '20/01/2026',
             'remessa' => ['titulo' => 'Transporte de Grãos', 'data' => '05/04/2026', 'hora' => '07:45', 'endereco' => 'Av. Leão Sampaio, 2.100 - Lagoa Seca, Juazeiro do Norte - CE, 63040-000']],
            ['nome' => 'Supermercado Diniz - loja 01', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '05/01/2026',
             'remessa' => ['titulo' => 'Coleta de Verduras', 'data' => '07/04/2026', 'hora' => '16:20', 'endereco' => 'Rua do Cruzeiro, 980 - Salesianos, Juazeiro do Norte - CE, 63050-250']],
        ];

        $ultimasLojas = [
            ['nome' => 'Açaí Atacadista', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '05/03/2026',
             'remessa' => ['titulo' => 'Distribuição de Legumes', 'data' => '10/04/2026', 'hora' => '11:10', 'endereco' => 'Av. Ailton Gomes, 3.300 - Pirajá, Juazeiro do Norte - CE, 63034-000']],
            ['nome' => 'Atacadão', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '10/02/2026',
             'remessa' => ['titulo' => 'Entrega de Hortaliças', 'data' => '02/04/2026', 'hora' => '14:30', 'endereco' => 'Rua São Pedro, 1.250 - Centro, Juazeiro do Norte - CE, 63010-010']],
            ['nome' => 'Supermercado Diniz - loja 04', 'cidade' => 'Juazeiro do Norte', 'status' => 'Disponível', 'data' => '20/01/2026',
             'remessa' => ['titulo' => 'Transporte de Grãos', 'data' => '05/04/2026', 'hora' => '07:45', 'endereco' => 'Av. Leão Sampaio, 2.100 - Lagoa Seca, Juazeiro do Norte - CE, 63040-000']],
            ['nome' => 'Supermercado Diniz - loja 05', 'cidade' => 'Crato - CE', 'status' => 'Disponível', 'data' => '05/01/2026',
             'remessa' => ['titulo' => 'Coleta de Verduras', 'data' => '07/04/2026', 'hora' => '16:20', 'endereco' => 'Rua do Cruzeiro, 980 - Salesianos, Juazeiro do Norte - CE, 63050-250']],
        ];
        @endphp

        {{-- Área principal de conteúdo da página --}}
        <main class="w-full bg-white px-8 py-8 min-h-screen">

            {{-- ── Barra de busca ── --}}
            <search class="relative mb-8 flex items-center gap-3" role="search" aria-label="Buscar lojas">
                <form
                    method="GET"
                    action="/user/buscar-lojas"
                    class="flex flex-1 items-center overflow-hidden rounded-full border border-gray-300 bg-white shadow-sm"
                    role="search">

                    <label for="campo-busca" class="sr-only">Encontre insumos</label>
                    <input
                        id="campo-busca"
                        type="search"
                        name="busca"
                        placeholder="Encontre insumos"
                        value="{{ request('busca') }}"
                        class="flex-1 border-none bg-transparent px-5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">

                    <button
                        type="submit"
                        aria-label="Buscar"
                        class="flex h-10 w-14 items-center justify-center rounded-r-full bg-[#08273B] text-white transition hover:bg-[#0a3350]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" stroke="white" stroke-width="2" />
                            <path d="M21 21l-3.5-3.5" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </form>

                {{-- Botão filtro --}}
                <button
                    id="btn-filtro"
                    type="button"
                    aria-expanded="false"
                    aria-controls="painel-filtro"
                    aria-label="Abrir filtros"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50">
                    <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                {{-- Painel de filtros --}}
                <aside
                    id="painel-filtro"
                    x-data="{ aberto: false, cidade: '' }"
                    x-show="aberto"
                    @toggle-filtro.window="aberto = !aberto"
                    @click.outside="aberto = false"
                    x-transition
                    aria-label="Painel de filtros"
                    class="absolute right-0 top-12 z-50 w-[220px] rounded-xl border border-gray-200 bg-white shadow-lg"
                    style="display: none;">

                    <header class="flex items-center border-b border-gray-100 px-4 py-3">
                        <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span class="ml-2 text-sm font-medium text-gray-700">Filtros</span>
                    </header>

                    <fieldset class="px-4 py-3 border-none">
                        <legend class="sr-only">Filtrar por cidade</legend>

                        <button
                            type="button"
                            @click="cidade = cidade === '' ? 'ativo' : ''"
                            class="flex w-full items-center justify-between text-sm font-medium text-[#841A1A]"
                            aria-expanded="false">
                            <span>Cidade</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <ul x-show="cidade !== ''" x-transition class="mt-3 space-y-2 list-none p-0">
                            @foreach (['Juazeiro do Norte', 'Crato', 'Barbalha'] as $cidade)
                            <li>
                                <button
                                    type="button"
                                    class="w-full rounded-full border px-4 py-1.5 text-sm transition
                                        {{ request('cidade') === $cidade
                                            ? 'border-[#841A1A] bg-[#841A1A] text-white'
                                            : 'border-gray-300 text-gray-700 hover:border-[#841A1A] hover:text-[#841A1A]' }}">
                                    {{ $cidade }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </fieldset>
                </aside>
            </search>

            {{-- ── Seção: Próximo de você ── --}}
            <section class="mb-8" aria-labelledby="titulo-proximas">
                <h2 id="titulo-proximas" class="mb-4 text-lg font-semibold text-gray-800">Próximo de você:</h2>

                <ul class="space-y-3 list-none p-0">
                    @foreach ($lojasProximas as $loja)
                    <li>
                        <article x-data="{ aberto: false }" class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 shadow-sm">

                            <header class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-4">
                                    <figure class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white shadow-sm text-base m-0" aria-hidden="true">
                                        🎁
                                    </figure>
                                    <div class="min-w-0">
                                        <h3 class="truncate font-semibold text-gray-800 text-base m-0">{{ $loja['nome'] }}</h3>
                                        <p class="truncate text-xs text-gray-500 m-0">{{ $loja['cidade'] }} • {{ $loja['status'] }} • {{ $loja['data'] }}</p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    @click="aberto = !aberto"
                                    :aria-expanded="aberto.toString()"
                                    x-text="aberto ? 'Solicitar doação' : 'Detalhes'"
                                    class="shrink-0 whitespace-nowrap rounded-full bg-[#841A1A] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                                </button>
                            </header>

                            @if (isset($loja['remessa']))
                            <section x-show="aberto" x-transition class="ml-[52px] mt-4 space-y-1" aria-label="Detalhes da remessa">
                                <header class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <h4 class="text-sm font-semibold text-gray-800 m-0">{{ $loja['remessa']['titulo'] }}</h4>

                                    <time
                                        datetime="{{ $loja['remessa']['data'] }}"
                                        class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-[#841A1A]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7" />
                                            <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                        </svg>
                                        {{ $loja['remessa']['data'] }}
                                    </time>

                                    <time
                                        datetime="{{ $loja['remessa']['hora'] }}"
                                        class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-[#841A1A]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7" />
                                            <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                        </svg>
                                        {{ $loja['remessa']['hora'] }}
                                    </time>
                                </header>
                                <address class="text-xs leading-relaxed text-gray-500 not-italic">{{ $loja['remessa']['endereco'] }}</address>
                            </section>
                            @endif

                        </article>
                    </li>
                    @endforeach
                </ul>
            </section>

            {{-- ── Seção: Últimas Lojas ── --}}
            <section aria-labelledby="titulo-ultimas">
                <h2 id="titulo-ultimas" class="mb-4 text-lg font-semibold text-gray-800">Últimas Lojas:</h2>

                <ul class="space-y-3 list-none p-0">
                    @foreach ($ultimasLojas as $loja)
                    <li>
                        <article x-data="{ aberto: false }" class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 shadow-sm">

                            <header class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-4">
                                    <figure class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white shadow-sm text-base m-0" aria-hidden="true">
                                        🎁
                                    </figure>
                                    <div class="min-w-0">
                                        <h3 class="truncate font-semibold text-gray-800 text-base m-0">{{ $loja['nome'] }}</h3>
                                        <p class="truncate text-xs text-gray-500 m-0">{{ $loja['cidade'] }} • {{ $loja['status'] }} • {{ $loja['data'] }}</p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    @click="aberto = !aberto"
                                    :aria-expanded="aberto.toString()"
                                    x-text="aberto ? 'Solicitar doação' : 'Detalhes'"
                                    class="shrink-0 whitespace-nowrap rounded-full bg-[#841A1A] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                                </button>
                            </header>

                            @if (isset($loja['remessa']))
                            <section x-show="aberto" x-transition class="ml-[52px] mt-4 space-y-1" aria-label="Detalhes da remessa">
                                <header class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <h4 class="text-sm font-semibold text-gray-800 m-0">{{ $loja['remessa']['titulo'] }}</h4>

                                    <time
                                        datetime="{{ $loja['remessa']['data'] }}"
                                        class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-[#841A1A]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7" />
                                            <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                        </svg>
                                        {{ $loja['remessa']['data'] }}
                                    </time>

                                    <time
                                        datetime="{{ $loja['remessa']['hora'] }}"
                                        class="flex items-center gap-1 text-xs font-normal text-gray-500">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-[#841A1A]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7" />
                                            <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                                        </svg>
                                        {{ $loja['remessa']['hora'] }}
                                    </time>
                                </header>
                                <address class="text-xs leading-relaxed text-gray-500 not-italic">{{ $loja['remessa']['endereco'] }}</address>
                            </section>
                            @endif

                        </article>
                    </li>
                    @endforeach
                </ul>
            </section>

        </main>

        <script>
            document.getElementById('btn-filtro')?.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('toggle-filtro'));
            });
        </script>

    </x-sidebar-nav-user>
</x-app-layout>