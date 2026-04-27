<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mercado 2</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .dashboard-card {
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.14);
        }

        .donut-chart {
            width: 190px;
            height: 190px;
            border-radius: 50%;
            background:
                conic-gradient(
                    #9333ea 0deg 126deg,
                    #22c55e 126deg 216deg,
                    #facc15 216deg 288deg,
                    #8b5cf6 288deg 324deg,
                    #f97316 324deg 360deg
                );
            position: relative;
        }

        .donut-chart::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            inset: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="bg-[#1f1f1f] text-[#222]">

@php
    $cards = [
        [
            'title' => 'Produtos Monitorados',
            'value' => '1.067',
            'subtitle' => '+12% este mês',
            'valueColor' => 'text-[#789547]',
            'iconColor' => 'text-[#789547]',
            'danger' => false,
        ],
        [
            'title' => 'Próxim. do vencimento',
            'value' => '87',
            'subtitle' => 'Próximos 7 dias',
            'valueColor' => 'text-red-500',
            'iconColor' => 'text-red-500',
            'danger' => true,
        ],
        [
            'title' => 'Doações realizadas',
            'value' => '21',
            'subtitle' => '+12% este mês',
            'valueColor' => 'text-[#789547]',
            'iconColor' => 'text-[#789547]',
            'danger' => false,
        ],
        [
            'title' => 'Aproveitamento',
            'value' => '94%',
            'subtitle' => '+12% este mês',
            'valueColor' => 'text-[#789547]',
            'iconColor' => 'text-[#789547]',
            'danger' => false,
        ],
    ];

    $months = [
        ['month' => 'Set', 'produtos' => 380, 'doacoes' => 230, 'desperdicios' => 70],
        ['month' => 'Out', 'produtos' => 450, 'doacoes' => 185, 'desperdicios' => 100],
        ['month' => 'Nov', 'produtos' => 525, 'doacoes' => 210, 'desperdicios' => 35],
        ['month' => 'Dez', 'produtos' => 485, 'doacoes' => 270, 'desperdicios' => 25],
    ];

    $vencimentos = [
        ['produto' => 'Leite Integral 1L', 'dias' => '8 dias'],
        ['produto' => 'Leite Integral 1L', 'dias' => '8 dias'],
        ['produto' => 'Leite Integral 1L', 'dias' => '8 dias'],
        ['produto' => 'Leite Integral 1L', 'dias' => '8 dias'],
    ];
@endphp

<div class="min-h-screen p-6 lg:p-8">

    <div class="mb-2 text-xs text-zinc-500">
        Dashboard - Mercado 2
    </div>

    <div class="mx-auto max-w-[1180px] overflow-hidden bg-white shadow-2xl">

        <!-- Topbar -->
        <header class="flex h-[70px] items-center justify-between bg-[#1e2d16] px-8 text-white">
            <div class="flex items-center gap-3">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5h14l-1.2 7.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.7L5.2 5Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M9 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM16 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" stroke="white" stroke-width="1.8"/>
                    <path d="M3 3h2l.2 2" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M13 8h5l-6 8h-5l6-8Z" stroke="white" stroke-width="1.4" stroke-linejoin="round"/>
                </svg>

                <span class="text-xl font-semibold tracking-tight">
                    ValidControl
                </span>
            </div>

            <div class="flex items-center gap-8">
                <button class="transition hover:scale-105">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.7 19a2 2 0 0 1-3.4 0" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </button>

                <button class="grid h-11 w-11 place-items-center rounded-full bg-white text-[#1e2d16] transition hover:scale-105">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21a8 8 0 0 0-16 0" stroke="#1e2d16" stroke-width="1.7" stroke-linecap="round"/>
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="#1e2d16" stroke-width="1.7"/>
                    </svg>
                </button>
            </div>
        </header>

        <div class="flex min-h-[760px]">

            <!-- Sidebar -->
            <aside class="w-[240px] bg-[#789747] px-3 py-4 text-white">
                <button class="mb-8 ml-1 text-[#063242]">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                </button>

                <nav class="space-y-3">
                    <a href="#" class="flex items-center gap-4 rounded-2xl px-5 py-3 text-[17px] text-white transition hover:bg-white/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Doações
                    </a>

                    <a href="#" class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/20 px-5 py-3 text-[17px] font-medium text-black shadow-sm">
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

            <!-- Main -->
            <main class="flex-1 bg-white px-14 py-7">

                <!-- Title -->
                <div class="mb-4 flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-[#242424]">
                            Dashboard:
                        </h1>
                        <p class="text-[15px] text-[#2c2c2c]">
                            Visão geral do controle de validade e doações
                        </p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap gap-4">
                        <button class="flex h-9 items-center gap-3 rounded-full bg-white px-5 text-sm text-[#789747] shadow-md">
                            Últimos 30 dias
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path d="m6 9 6 6 6-6" stroke="#789747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <button class="flex h-9 items-center gap-10 rounded-full bg-white px-5 text-sm text-[#789747] shadow-md">
                            Categorias
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path d="m6 9 6 6 6-6" stroke="#789747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <button class="flex h-9 items-center gap-10 rounded-full bg-white px-5 text-sm text-[#789747] shadow-md">
                            Unidades
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path d="m6 9 6 6 6-6" stroke="#789747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <button class="flex h-9 items-center gap-2 rounded-full bg-[#789747] px-6 text-sm font-medium text-white shadow-sm transition hover:bg-[#66843d]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3v12M8 11l4 4 4-4M4 17v3h16v-3" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Importar CSV
                    </button>
                </div>

                <!-- Cards -->
                <section class="mb-6 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                    @foreach($cards as $card)
                        <div class="dashboard-card rounded-xl border border-zinc-200 bg-white px-3 py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-[16px] text-zinc-500">
                                    {{ $card['title'] }}
                                </p>

                                @if($card['danger'])
                                    <svg class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="none">
                                        <path d="M7 7h10v10M7 17 17 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 text-[#789747]" viewBox="0 0 24 24" fill="none">
                                        <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="mt-1 text-2xl font-bold {{ $card['valueColor'] }}">
                                {{ $card['value'] }}
                            </div>

                            <p class="mt-1 text-xs {{ $card['danger'] ? 'text-red-500' : 'text-[#789747]' }}">
                                {{ $card['subtitle'] }}
                            </p>
                        </div>
                    @endforeach
                </section>

                <!-- Charts Row -->
                <section class="mb-6 grid grid-cols-1 gap-5 xl:grid-cols-[1.1fr_1fr]">

                    <!-- Bar Chart -->
                    <div class="dashboard-card rounded-xl border border-zinc-200 bg-white p-4">
                        <h2 class="text-xl font-medium text-[#222]">
                            Tendências Mensais
                        </h2>
                        <p class="text-xs text-zinc-500">
                            Últimos 5 meses
                        </p>

                        <div class="mt-5">
                            <div class="relative h-[185px] border-b border-l border-zinc-300 pl-8">
                                <div class="absolute left-0 top-0 h-full w-full">
                                    <div class="absolute left-8 right-0 top-0 border-t border-zinc-200"></div>
                                    <div class="absolute left-8 right-0 top-1/4 border-t border-zinc-200"></div>
                                    <div class="absolute left-8 right-0 top-2/4 border-t border-zinc-200"></div>
                                    <div class="absolute left-8 right-0 top-3/4 border-t border-zinc-200"></div>

                                    <span class="absolute left-0 top-[-8px] text-[10px] text-zinc-500">600</span>
                                    <span class="absolute left-0 top-[42px] text-[10px] text-zinc-500">450</span>
                                    <span class="absolute left-0 top-[91px] text-[10px] text-zinc-500">100</span>
                                    <span class="absolute left-0 bottom-[-5px] text-[10px] text-zinc-500">0</span>
                                </div>

                                <div class="relative z-10 flex h-full items-end justify-around gap-7 px-8">
                                    @foreach($months as $item)
                                        <div class="flex h-full flex-col items-center justify-end">
                                            <div class="flex h-full items-end gap-3">
                                                <div class="w-[18px] bg-[#789747]" style="height: {{ $item['produtos'] / 600 * 100 }}%;"></div>
                                                <div class="w-[18px] bg-[#22311d]" style="height: {{ $item['doacoes'] / 600 * 100 }}%;"></div>
                                                <div class="w-[18px] bg-[#8fd3a3]" style="height: {{ $item['desperdicios'] / 600 * 100 }}%;"></div>
                                            </div>

                                            <span class="mt-2 text-[10px] text-zinc-500">
                                                {{ $item['month'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-3 flex justify-center gap-4 text-[10px] text-zinc-600">
                                <div class="flex items-center gap-1">
                                    <span class="h-2 w-2 bg-[#789747]"></span>
                                    Produtos
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="h-2 w-2 bg-[#22311d]"></span>
                                    Doações
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="h-2 w-2 bg-[#8fd3a3]"></span>
                                    Desperdícios
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Line Chart -->
                    <div class="dashboard-card rounded-xl border border-zinc-200 bg-white p-4">
                        <h2 class="text-xl font-medium text-[#222]">
                            Taxa de Eficiência
                        </h2>
                        <p class="text-xs text-zinc-500">
                            Evolução mensal da taxa de aproveitamento
                        </p>

                        <div class="mt-5">
                            <svg viewBox="0 0 440 210" class="h-[220px] w-full">
                                <line x1="45" y1="10" x2="420" y2="10" stroke="#e5e7eb"/>
                                <line x1="45" y1="60" x2="420" y2="60" stroke="#e5e7eb"/>
                                <line x1="45" y1="110" x2="420" y2="110" stroke="#e5e7eb"/>
                                <line x1="45" y1="160" x2="420" y2="160" stroke="#e5e7eb"/>

                                <line x1="45" y1="10" x2="45" y2="185" stroke="#d1d5db"/>
                                <line x1="45" y1="185" x2="420" y2="185" stroke="#9ca3af"/>

                                <text x="8" y="14" font-size="10" fill="#71717a">600</text>
                                <text x="8" y="64" font-size="10" fill="#71717a">450</text>
                                <text x="8" y="114" font-size="10" fill="#71717a">100</text>
                                <text x="20" y="188" font-size="10" fill="#71717a">0</text>

                                <polyline
                                    points="70,185 110,140 155,135 205,95 270,95 330,65 385,48"
                                    fill="none"
                                    stroke="#789747"
                                    stroke-width="2"
                                />

                                <circle cx="110" cy="140" r="3" fill="#789747"/>
                                <circle cx="205" cy="95" r="3" fill="#789747"/>
                                <circle cx="270" cy="95" r="3" fill="#789747"/>
                                <circle cx="385" cy="48" r="3" fill="#789747"/>

                                <text x="105" y="202" font-size="10" fill="#71717a">Set</text>
                                <text x="202" y="202" font-size="10" fill="#71717a">Out</text>
                                <text x="268" y="202" font-size="10" fill="#71717a">Nov</text>
                                <text x="382" y="202" font-size="10" fill="#71717a">Dez</text>
                            </svg>
                        </div>
                    </div>
                </section>

                <!-- Bottom Row -->
                <section class="grid grid-cols-1 gap-5 xl:grid-cols-[1.1fr_1fr]">

                    <!-- Donut -->
                    <div class="dashboard-card rounded-xl border border-zinc-200 bg-white p-4">
                        <h2 class="mb-4 text-xl font-medium text-[#222]">
                            Distribuição por Categoria
                        </h2>

                        <div class="relative flex min-h-[190px] items-center justify-center">
                            <div class="donut-chart"></div>

                            <span class="absolute left-[70px] top-[28px] text-xs text-zinc-500 underline underline-offset-2">
                                Laticínios 10%
                            </span>

                            <span class="absolute left-[70px] top-[66px] text-xs text-zinc-500 underline underline-offset-2">
                                Padaria 10%
                            </span>

                            <span class="absolute left-[70px] bottom-[58px] text-xs text-zinc-500 underline underline-offset-2">
                                Frios 20%
                            </span>

                            <span class="absolute right-[40px] top-[72px] text-xs text-zinc-500 underline underline-offset-2">
                                Outros 35%
                            </span>

                            <span class="absolute right-[30px] bottom-[18px] text-xs text-zinc-500 underline underline-offset-2">
                                Frutas 25%
                            </span>
                        </div>
                    </div>

                    <!-- Expiring -->
                    <div class="dashboard-card rounded-xl border border-zinc-200 bg-white p-3">
                        <div class="mb-2 flex items-center justify-between px-1">
                            <h2 class="text-xl font-medium text-[#222]">
                                Próximos vencimentos
                            </h2>

                            <span class="text-sm text-zinc-500">
                                Vence em:
                            </span>
                        </div>

                        <div class="space-y-2">
                            @foreach($vencimentos as $item)
                                <div class="flex items-center justify-between rounded-xl bg-zinc-200 px-3 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-6 w-6 place-items-center rounded-full bg-[#789747] text-sm font-bold text-white">
                                            1
                                        </span>

                                        <span class="text-sm text-[#333]">
                                            {{ $item['produto'] }}
                                        </span>
                                    </div>

                                    <span class="text-sm text-[#333]">
                                        {{ $item['dias'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </section>

            </main>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('button');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.add('scale-95');

                setTimeout(() => {
                    button.classList.remove('scale-95');
                }, 120);
            });
        });
    });
</script>

</body>
</html>