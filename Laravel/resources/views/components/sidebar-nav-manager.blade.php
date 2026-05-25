{{-- resources/views/components/sidebar-nav-manager.blade.php --}}
@props([
'active' => 'dashboard'
])

<div
    x-data="{ open: false }"
    class="flex min-h-screen bg-gray-100 "
>
    {{-- BOTÃO MOBILE --}}
    <button
        @click="open = true"
        class="md:hidden fixed bottom-4 left-4 z-40 bg-[#749048] text-white p-5 rounded-lg shadow-lg"
    >
        ☰
    </button>

    {{-- FUNDO ESCURO MOBILE (overlay) --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
        style="display: none;"></div>

    {{-- SIDEBAR --}}
    <aside class="
    fixed md:sticky
    top-0 md:top-16
    left-0 z-50
    h-screen md:h-[calc(100vh-4rem)]
    w-64
    bg-[#749048] text-white shadow-lg
"
        :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
        {{-- TOPO MOBILE --}}
        <div class="md:hidden flex justify-end p-4">
            <button
                @click="open = false"
                class="text-white text-2xl">
                ✕
            </button>
        </div>

        {{-- Usuário --}}
        <div class="px-6 py-5 border-b border-white/20 flex items-center gap-3">
            {{-- Avatar com inicial do nome --}}
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-lg uppercase shrink-0">
                {{ mb_substr(auth()->user()?->name ?? 'U', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="font-semibold text-white truncate leading-tight">
                    {{ auth()->user()?->name ?? 'Usuário' }}
                </p>
                <p class="text-xs text-lime-100 leading-tight">Painel Gerencial</p>
            </div>
        </div>

        {{-- Navegação --}}
        <nav class="mt-4 px-3 space-y-2" aria-label="Menu do gerente">

            <a href="/manager/dashboard"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'dashboard'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                <img src="{{asset('svgs/dashboard.svg')}}"> <span>Dashboard</span>
            </a>

            <a href="/manager/doacoes"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'doacoes'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                <img src="{{asset('svgs/gift.svg')}}"> <span>Doações</span>
            </a>

            <a href="/manager/produtos"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'produtos'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                <img src="{{asset('svgs/package.svg')}}"> <span>Produtos</span>
            </a>

            <a href="/manager/movements"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'movimentacoes'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                <img src="{{asset('svgs/move.svg')}}"> <span>Movimentações</span>
            </a>
            </a>

        </nav>
    </aside>
    
    {{-- CONTEÚDO --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- BOTÃO HAMBURGUER MOBILE (fixo no canto inferior) --}}
    <button
        @click="open = true"
        class="md:hidden fixed bottom-4 left-4 z-50 bg-[#749048] text-white p-4 rounded-lg shadow-lg text-xl">
        ☰
    </button>

</div>