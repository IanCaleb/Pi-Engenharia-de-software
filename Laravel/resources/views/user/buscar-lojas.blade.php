<x-app-layout>
    <x-sidebar-nav-user active="buscar-lojas">

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

                @if ($lojasProximas->isEmpty())
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-6 py-8 text-center">
                        <p class="text-sm text-gray-600">Nenhuma doação disponível no momento.</p>
                    </div>
                @else
                <ul class="space-y-3 list-none p-0">
                    @foreach ($lojasProximas as $doacao)
                    <li>
                        <article x-data="{ aberto: false }" class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 shadow-sm">

                            <header class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-4">
                                    <figure class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white shadow-sm text-base m-0" aria-hidden="true">
                                        🎁
                                    </figure>
                                    <div class="min-w-0">
                                        <h3 class="truncate font-semibold text-gray-800 text-base m-0">{{ $doacao->store->name }}</h3>
                                        <p class="truncate text-xs text-gray-500 m-0">{{ $doacao->store->city }} • Disponível • {{ $doacao->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                               <button type="button"
                                    @click="aberto = !aberto"
                                    :aria-expanded="aberto.toString()"
                                    :class="aberto ? 'w-9 h-9 bg-transparent text-[#841A1A]' : 'px-5 py-2 rounded-full bg-[#841A1A] text-white'"
                                    class="inline-flex items-center justify-center shrink-0 whitespace-nowrap text-sm font-medium transition-all duration-200 rounded-full hover:opacity-80 focus:outline-none">
                                
                                <!-- Quando estiver FECHADO (!aberto), mostra o texto "Detalhes" -->
                                <span x-show="!aberto">
                                    Detalhes
                                </span>

                                <!-- Quando estiver ABERTO (aberto), mostra apenas o ícone 'X' em vermelho -->
                                <span x-show="aberto" x-cloak class="inline-flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </span>
                            </button>
                            </header>

                            <section x-show="aberto" x-transition class="ml-[52px] mt-4 space-y-3" aria-label="Detalhes da doação">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $doacao->batch->product->name }}</h4>
                                    <p class="text-xs text-gray-600">Quantidade: {{ $doacao->quantity }} unidades</p>
                                    <p class="text-xs text-gray-600">Vencimento: {{ $doacao->batch->expiration_date->format('d/m/Y') }}</p>
                                </div>

                                <!-- Endereço da loja -->
                                @if ($doacao->store->rua && $doacao->store->numero && $doacao->store->bairro)
                                    <div class="rounded-lg bg-blue-50 border border-blue-200 p-3">
                                        <p class="text-xs font-semibold text-blue-900 mb-1">📍 Localização da Loja:</p>
                                        <p class="text-xs text-blue-800">{{ $doacao->store->rua }}, {{ $doacao->store->numero }}</p>
                                        <p class="text-xs text-blue-800">{{ $doacao->store->bairro }} - {{ $doacao->store->city }}</p>
                                        @if ($doacao->store->cep)
                                            <p class="text-xs text-blue-800">CEP: {{ $doacao->store->cep }}</p>
                                        @endif
                                    </div>
                                @endif

                                <form action="{{ route('donation-requests.store') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="donation_id" value="{{ $doacao->id }}">
                                    <button type="submit"
                                            class="w-full rounded-full bg-[#841A1A] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                                            Solicitar esta doação
                                    </button>
                                </form>
                            </section>

                        </article>
                    </li>
                    @endforeach
                </ul>
                @endif
            </section>

            {{-- ── Seção: Últimas Lojas ── --}}
            <section aria-labelledby="titulo-ultimas">
                <h2 id="titulo-ultimas" class="mb-4 text-lg font-semibold text-gray-800">Últimas Lojas:</h2>

                @if ($ultimasLojas->isEmpty())
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-6 py-8 text-center">
                        <p class="text-sm text-gray-600">Nenhuma doação disponível.</p>
                    </div>
                @else
                <ul class="space-y-3 list-none p-0">
                    @foreach ($ultimasLojas as $doacao)
                    <li>
                        <article x-data="{ aberto: false }" class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 shadow-sm">

                            <header class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-4">
                                    <figure class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white shadow-sm text-base m-0" aria-hidden="true">
                                        🎁
                                    </figure>
                                    <div class="min-w-0">
                                        <h3 class="truncate font-semibold text-gray-800 text-base m-0">{{ $doacao->store->name }}</h3>
                                        <p class="truncate text-xs text-gray-500 m-0">{{ $doacao->store->city }} • Disponível • {{ $doacao->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <button type="button"
                                    @click="aberto = !aberto"
                                    :aria-expanded="aberto.toString()"
                                    :class="aberto ? 'w-9 h-9 bg-transparent text-[#841A1A]' : 'px-5 py-2 rounded-full bg-[#841A1A] text-white'"
                                    class="inline-flex items-center justify-center shrink-0 whitespace-nowrap text-sm font-medium transition-all duration-200 rounded-full hover:opacity-80 focus:outline-none">
                                
                                <!-- Quando estiver FECHADO (!aberto), mostra o texto "Detalhes" -->
                                <span x-show="!aberto">
                                    Detalhes
                                </span>

                                <!-- Quando estiver ABERTO (aberto), mostra apenas o ícone 'X' em vermelho -->
                                <span x-show="aberto" x-cloak class="inline-flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </span>
                            </button>
                            </header>

                            <section x-show="aberto" x-transition class="ml-[52px] mt-4 space-y-3" aria-label="Detalhes da doação">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $doacao->batch->product->name }}</h4>
                                    <p class="text-xs text-gray-600">Quantidade: {{ $doacao->quantity }} unidades</p>
                                    <p class="text-xs text-gray-600">Vencimento: {{ $doacao->batch->expiration_date->format('d/m/Y') }}</p>
                                </div>

                                <!-- Endereço da loja -->
                                @if ($doacao->store->rua && $doacao->store->numero && $doacao->store->bairro)
                                    <div class="rounded-lg bg-blue-50 border border-blue-200 p-3">
                                        <p class="text-xs font-semibold text-blue-900 mb-1">📍 Localização da Loja:</p>
                                        <p class="text-xs text-blue-800">{{ $doacao->store->rua }}, {{ $doacao->store->numero }}</p>
                                        <p class="text-xs text-blue-800">{{ $doacao->store->bairro }} - {{ $doacao->store->city }}</p>
                                        @if ($doacao->store->cep)
                                            <p class="text-xs text-blue-800">CEP: {{ $doacao->store->cep }}</p>
                                        @endif
                                    </div>
                                @endif

                                <form action="{{ route('donation-requests.store') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="donation_id" value="{{ $doacao->id }}">
                                    <button type="submit"
                                            class="w-full rounded-full bg-[#841A1A] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                                            Solicitar esta doação
                                    </button>
                                </form>
                            </section>

                        </article>
                    </li>
                    @endforeach
                </ul>
                @endif
            </section>

        </main>

        <script>
            document.getElementById('btn-filtro')?.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('toggle-filtro'));
            });
        </script>

    </x-sidebar-nav-user>
</x-app-layout>