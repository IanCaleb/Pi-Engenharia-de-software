<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doações - ValidControl</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#1f1f1f] text-[#222]" style="font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;">

<div class="min-h-screen">
    <div class="w-full min-h-screen overflow-hidden bg-white">

        <!-- Topbar -->
        <header class="flex h-[70px] items-center justify-between bg-[#08273b] px-6 text-white">
            <div class="flex items-center gap-3">
                <!-- Hamburguer mobile -->
                <button class="mr-1 md:hidden" onclick="toggleSidebar()">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <!-- Logo -->
                <svg class="h-8 w-8 shrink-0" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5h14l-1.2 7.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.7L5.2 5Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M9 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM16 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" stroke="white" stroke-width="1.8"/>
                    <path d="M3 3h2l.2 2" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <span class="text-xl font-semibold tracking-tight">ValidControl</span>
            </div>

            <div class="flex items-center gap-6">
                <button class="transition hover:scale-105">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.7 19a2 2 0 0 1-3.4 0" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </button>
                <button class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-white transition hover:scale-105">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21a8 8 0 0 0-16 0" stroke="#1e2d16" stroke-width="1.7" stroke-linecap="round"/>
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="#1e2d16" stroke-width="1.7"/>
                    </svg>
                </button>
            </div>
        </header>

        <div class="flex min-h-[calc(100vh-70px)]">

            <!-- Sidebar Desktop -->
            <aside id="sidebar-desktop" class="hidden md:flex md:w-[240px] flex-col bg-[#749048] px-3 py-4 text-white transition-all duration-300">
                <button class="mb-8 ml-1 text-[#063242]" onclick="toggleDesktopSidebar()">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                </button>

                <nav class="space-y-3">
                    <a href="#" class="flex items-center gap-4 rounded-lg border border-white/10 bg-white/15 px-5 py-3 text-[17px] font-medium text-white shadow-sm"
                       onmouseenter="this.querySelector('.ni').style.color='#1e1e1e'; this.querySelector('.nt').style.color='#1e1e1e';"
                       onmouseleave="this.querySelector('.ni').style.color='white'; this.querySelector('.nt').style.color='white';">
                        <svg class="ni h-5 w-5" style="color:white;" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="nt" style="color:white;">Doações</span>
                    </a>

                    <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="4" y="4" width="7" height="7" rx="1"/>
                            <rect x="13" y="4" width="7" height="7" rx="1"/>
                            <rect x="4" y="13" width="7" height="7" rx="1"/>
                            <rect x="13" y="13" width="7" height="7" rx="1"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M21 16V8l-9-5-9 5v8l9 5 9-5Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M3.5 8.5 12 13l8.5-4.5M12 21v-8" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Produtos
                    </a>
                </nav>
            </aside>

            <!-- Sidebar Mobile Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 hidden" onclick="toggleSidebar()"></div>

            <!-- Sidebar Mobile -->
            <aside id="sidebar-mobile" class="fixed inset-y-0 left-0 z-50 w-[240px] bg-[#749048] px-3 py-4 text-white hidden">
                <button class="mb-8 ml-1 text-[#063242]" onclick="toggleSidebar()">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                </button>
                <nav class="space-y-3">
                    <a href="#" class="flex items-center gap-4 rounded-lg border border-white/10 bg-white/15 px-5 py-3 text-[17px] font-medium text-white shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Doações
                    </a>
                    <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="4" y="4" width="7" height="7" rx="1"/>
                            <rect x="13" y="4" width="7" height="7" rx="1"/>
                            <rect x="4" y="13" width="7" height="7" rx="1"/>
                            <rect x="13" y="13" width="7" height="7" rx="1"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M21 16V8l-9-5-9 5v8l9 5 9-5Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M3.5 8.5 12 13l8.5-4.5M12 21v-8" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Produtos
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden bg-white px-5 py-5 lg:px-10">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-[#242424]">Doações</h1>
                    <p class="text-sm text-zinc-500">Gerencie as solicitações de doações e produtos disponíveis</p>
                </div>

                <!-- Seção 1: Produtos Disponíveis -->
                <section class="mb-6 rounded-xl border border-zinc-200 bg-white p-4 shadow-md">
                    <h2 class="text-lg font-bold text-[#242424]">Produtos Disponíveis para Doação</h2>
                    <p class="mb-4 text-sm text-zinc-500">Produtos próximos ao vencimento que podem ser doados</p>

                    <div class="space-y-3">
                        @php
                        $produtosDisponiveis = [
                            ['nome' => 'Leite Integral 1L', 'unidades' => 30, 'vencimento' => '24/03/2026', 'solicitacoes' => 3],
                            ['nome' => 'Iogurte Natural', 'unidades' => 10, 'vencimento' => '30/03/2026', 'solicitacoes' => 3],
                            ['nome' => 'Presunto Fatiado', 'unidades' => 13, 'vencimento' => '21/03/2026', 'solicitacoes' => 3],
                        ];
                        @endphp

                        @foreach($produtosDisponiveis as $produto)
                        <div class="flex flex-col gap-3 rounded-xl border border-zinc-300 bg-white px-4 py-3 shadow-sm md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-zinc-100">
                                    <svg class="h-5 w-5 text-zinc-700" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-[#000000]">{{ $produto['nome'] }}</p>
                                    <p class="text-xs text-[#000000]">{{ $produto['unidades'] }} unidades disponíveis &bull; Vence em {{ $produto['vencimento'] }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 md:flex-row md:items-center">
                                <span class="inline-flex w-fit items-center rounded-full bg-[#841a1a] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">
                                    {{ $produto['solicitacoes'] }} solicitações
                                </span>
                                <button class="rounded-lg bg-[#08273b] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#0a3350] whitespace-nowrap">
                                    Ver Solicitações
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Seção 2: Solicitações de Doações -->
                <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-md">
                    <h2 class="text-lg font-bold text-[#242424]">Solicitações de Doações</h2>
                    <p class="mb-4 text-sm text-zinc-500">Lojas e instituições que solicitaram produtos</p>

                    <div class="space-y-4">
                        @php
                        $solicitacoes = [
                            ['produto' => 'Leite Integral 1L', 'instituicao' => 'Mercado Bom Preço', 'quantidade' => '15 unidades', 'validade' => '26/03/2026', 'solicitado' => '18/03/2026', 'status' => 'Pendente'],
                            ['produto' => 'Iogurte Natural', 'instituicao' => 'Instituto Esperança', 'quantidade' => '20 unidades', 'validade' => '20/03/2026', 'solicitado' => '17/03/2026', 'status' => 'Aceito'],
                            ['produto' => 'Pão Integral', 'instituicao' => 'Lar dos idosos', 'quantidade' => '10 unidades', 'validade' => '14/04/2026', 'solicitado' => '14/03/2026', 'status' => 'Concluído'],
                            ['produto' => 'Presunto Fatiado', 'instituicao' => 'ONG Alimentar', 'quantidade' => '12 unidades', 'validade' => '21/03/2026', 'solicitado' => '18/03/2026', 'status' => 'Pendente'],
                            ['produto' => 'Queijo Minas', 'instituicao' => 'Casa de Apoio São José', 'quantidade' => '8 unidades', 'validade' => '27/03/2026', 'solicitado' => '16/03/2026', 'status' => 'Aceito'],
                        ];
                        @endphp

                        @foreach($solicitacoes as $s)
                        <div class="rounded-xl border bg-white p-4
                            @if($s['status'] === 'Pendente') border-[#841a1a]
                            @elseif($s['status'] === 'Aceito') border-[#08273b]
                            @else border-[#749048] @endif">

                            <!-- Cabeçalho -->
                            <div class="mb-2 flex items-start justify-between">
                                <div class="flex items-start gap-1">
                                    <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-zinc-100 mt-0.5">
                                        <svg class="h-4 w-4 text-zinc-700" viewBox="0 0 24 24" fill="none">
                                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col gap-0.5">
                                        <p class="font-bold text-[#000000]">{{ $s['produto'] }}</p>
                                        <div class="flex items-center gap-1 text-xs text-[#000000]">
                                            <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 21h18M3 7v14M21 7v14M6 11h2m-2 4h2m8-4h2m-2 4h2M9 21V11h6v10M3 7l9-4 9 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            {{ $s['instituicao'] }}
                                        </div>
                                    </div>
                                </div>

                                @if($s['status'] === 'Pendente')
                                    <span class="rounded-full bg-[#841a1a] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Pendente</span>
                                @elseif($s['status'] === 'Aceito')
                                    <span class="rounded-full bg-[#08273b] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Aceito</span>
                                @else
                                    <span class="rounded-full bg-[#749048] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Concluído</span>
                                @endif
                            </div>

                            <!-- Infos -->
                            <div class="mb-3 w-full text-sm" style="display:grid; grid-template-columns: 0.8fr 1.1fr 1.1fr; width:100%;">
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-zinc-400">Quantidade</p>
                                    <p class="font-bold text-[#000000]">
                                        <span class="md:hidden">{{ str_replace('unidades', 'uni.', $s['quantidade']) }}</span>
                                        <span class="hidden md:inline">{{ $s['quantidade'] }}</span>
                                    </p>
                                </div>
                                <div style="text-align:center;">
                                    <p class="text-[10px] font-bold uppercase text-zinc-400">Validade</p>
                                    <p class="font-bold text-[#000000]">{{ $s['validade'] }}</p>
                                </div>
                                <div style="text-align:right;">
                                    <p class="text-[10px] font-bold uppercase text-zinc-400">Solicitado</p>
                                    <p class="font-bold text-[#000000]">{{ $s['solicitado'] }}</p>
                                </div>
                            </div>

                            <!-- Botões -->
                            @if($s['status'] === 'Pendente')
                            <div class="flex flex-col gap-2 md:grid md:grid-cols-2">
                                <button class="w-full rounded-lg bg-[#841a1a] py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">Recusar</button>
                                <button class="w-full rounded-lg bg-[#749048] py-2 text-sm font-medium text-white transition hover:bg-[#5e7a3a]">Aceitar solicitação</button>
                            </div>
                            @elseif($s['status'] === 'Aceito')
                            <button class="w-full rounded-lg bg-[#08273b] py-2 text-sm font-medium text-white transition hover:bg-[#0a3350]">Marcar como retirado</button>
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
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar-mobile');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('hidden');
    overlay.classList.toggle('hidden');
}

function toggleDesktopSidebar() {
    const sidebar = document.getElementById('sidebar-desktop');
    const nav = sidebar.querySelector('nav');
    const isCollapsed = sidebar.dataset.collapsed === 'true';

    if (isCollapsed) {
        sidebar.style.width = '240px';
        nav.style.display = '';
        sidebar.dataset.collapsed = 'false';
    } else {
        sidebar.style.width = '56px';
        nav.style.display = 'none';
        sidebar.dataset.collapsed = 'true';
    }
}
</script>

</body>
<!-- Identificação da interface: Doações ValidControl -->
</html>