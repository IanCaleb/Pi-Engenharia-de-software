{{-- resources/views/components/sidebar-nav-manager.blade.php --}}
@props([
'active' => 'dashboard'
])

<div
    x-data="{ open: false }"
    class="flex min-h-[calc(100vh-64px)] bg-gray-100">

    {{-- FUNDO ESCURO MOBILE (overlay) --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
        style="display: none;"></div>

    {{-- SIDEBAR — fixa abaixo da navbar (top-16) --}}
    <aside
        class="
            fixed top-16 left-0 z-40
            h-[calc(100vh-64px)] w-64
            bg-[#749048] text-white shadow-lg
            transform transition-transform duration-300
            md:translate-x-0
            overflow-y-auto
        "
        :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

        {{-- Botão fechar (apenas mobile) --}}
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
                📊 <span>Dashboard</span>
            </a>

            <a href="/manager/doacoes"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'doacoes'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                🎁 <span>Doações</span>
            </a>

            <a href="/manager/produtos"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'produtos'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                📦 <span>Produtos</span>
            </a>

        </nav>
    </aside>

    {{-- CONTEÚDO — empurrado 256px à direita no desktop --}}
    <main class="flex-1 w-full md:ml-64 min-h-[calc(100vh-64px)]">
        {{ $slot }}
    </main>

    {{-- BOTÃO HAMBURGUER MOBILE (fixo no canto inferior) --}}
    <button
        @click="open = true"
        class="md:hidden fixed bottom-4 left-4 z-50 bg-[#749048] text-white p-4 rounded-lg shadow-lg text-xl">
        ☰
    </button>

</div>