{{-- resources/views/components/sidebar-nav-user.blade.php --}}
@props([
'active' => 'home'
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

        {{-- Logo / Título --}}
        <div class="px-6 py-5 border-b border-white/20">
            <h2 class="text-2xl font-bold">ValidControl</h2>
            <p class="text-sm text-lime-100">Painel Gerencial</p>
        </div>

        {{-- Navegação --}}
        <nav class="mt-4 px-3 space-y-2">

            <a href="/user/home"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'home'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                📊 <span>Home</span>
            </a>

            <a href="/user/buscar-lojas"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'buscar-lojas'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                🎁 <span>Buscar lojas</span>
            </a>

            <a href="/user/doacoes"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
               {{ $active === 'doacoes'
                    ? 'bg-[#8B9C5C] font-medium'
                    : 'hover:bg-[#8B9C5C]' }}">
                📦 <span>Doações</span>
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