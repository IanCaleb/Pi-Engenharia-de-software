{{-- resources/views/components/sidebar-nav.blade.php --}}
@props([
    'active' => 'dashboard'
])

<div 
    x-data="{ open: false }"
    class="flex min-h-screen bg-gray-100"
>
    {{-- BOTÃO MOBILE --}}
    <button
        @click="open = true"
        class="md:hidden fixed bottom-4 left-4 z-40 bg-[#749048] text-white p-5 rounded-lg shadow-lg"
    >
        ☰
    </button>

    {{-- FUNDO ESCURO MOBILE --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
    ></div>

    {{-- SIDEBAR --}}
    <aside
        class="
            fixed md:static top-0 left-0 z-50
            h-[100vh] w-64
            bg-[#749048] text-white shadow-lg
            transform transition-transform duration-300
            md:translate-x-0
        "
        :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
        {{-- TOPO MOBILE --}}
        <div class="md:hidden flex justify-end p-4">
            <button
                @click="open = false"
                class="text-white text-2xl"
            >
                ✕
            </button>
        </div>

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-white/20">
            <h2 class="text-2xl font-bold">ValidControl</h2>
            <p class="text-sm text-lime-100">Painel Gerencial</p>
        </div>

        {{-- Navegação --}}
        <nav class="mt-4 px-3 space-y-2">

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

    {{-- CONTEÚDO --}}
    <main class="flex-1 w-full md:ml-0">
        {{ $slot }}
    </main>
</div>