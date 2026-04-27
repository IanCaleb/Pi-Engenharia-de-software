<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ValidControl — Produtos</title>

    {{-- Tailwind via CDN (substitua pelo seu build em produção) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- date-fns via CDN para cálculo de dias --}}
    <script src="https://cdn.jsdelivr.net/npm/date-fns@3/cdn.min.js"></script>

    {{-- Lucide icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        * { font-family: 'Open Sans', sans-serif; box-sizing: border-box; }

        /* ── Status Badge colors ── */
        .badge-ok       { background:#EAF2DC; color:#749048; }
        .badge-warning  { background:#FEF9C3; color:#A16207; }
        .badge-critical { background:#FDECEA; color:#841A1A; }

        /* ── Scrollbar fina na main ── */
        main::-webkit-scrollbar { width: 5px; }
        main::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="m-0 p-0 bg-gray-50">

{{-- ╔══════════════════════════════════════════════════════╗
     ║  WRAPPER PRINCIPAL — flex coluna, altura 100vh       ║
     ╚══════════════════════════════════════════════════════╝ --}}
<div class="flex flex-col h-screen overflow-hidden">

    {{-- ══════════════════════════════════════════
         TOPBAR
         Fundo: #08273B | Borda inferior: 3px #749048
    ══════════════════════════════════════════ --}}
    <header class="w-full flex-shrink-0 h-14 bg-[#08273B] flex items-center justify-between px-6 z-10"
            style="border-bottom: 3px solid #749048;">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5">
            {{-- Shield SVG --}}
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                 stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L4 6v6c0 4.4 3.3 8.5 8 9.5 4.7-1 8-5.1 8-9.5V6L12 2z"/>
                <polyline points="9 12 11 14 15 10"/>
            </svg>
            <span class="text-white text-base font-bold tracking-wide">ValidControl</span>
        </div>

        {{-- Ícones direita --}}
        <div class="flex items-center gap-3">
            {{-- Sino --}}
            <button class="w-9 h-9 rounded-full border border-white/25 flex items-center justify-center hover:bg-white/10 transition-colors">
                <i data-lucide="bell" class="w-[17px] h-[17px] text-white"></i>
            </button>
            {{-- Avatar --}}
            <div class="w-9 h-9 rounded-full bg-[#3a4f60] border border-white/20 flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
        </div>
    </header>

    {{-- ══════════════════════════════════════════
         ROW: SIDEBAR + CONTENT
    ══════════════════════════════════════════ --}}
    <div class="flex flex-1 overflow-hidden">

        {{-- ── SIDEBAR ── --}}
        <aside class="w-[200px] flex-shrink-0 bg-[#749048] flex flex-col">

            {{-- Hamburguer --}}
            <div class="px-4 pt-4 pb-2">
                <button class="text-white/80 hover:text-white transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 pb-4">
                <ul class="space-y-1">
                    {{-- Item: Doações --}}
                    <li class="flex items-center gap-2.5 mx-3 px-3 py-[10px] text-[13px] font-semibold cursor-pointer rounded-[10px] transition-colors duration-150 text-white/85 hover:bg-white/15 hover:text-white">
                        <i data-lucide="gift" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        Doações
                    </li>
                    {{-- Item: Dashboard --}}
                    <li class="flex items-center gap-2.5 mx-3 px-3 py-[10px] text-[13px] font-semibold cursor-pointer rounded-[10px] transition-colors duration-150 text-white/85 hover:bg-white/15 hover:text-white">
                        <i data-lucide="layout-dashboard" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        Dashboard
                    </li>
                    {{-- Item: Produtos (ATIVO) --}}
                    <li class="flex items-center gap-2.5 mx-3 px-3 py-[10px] text-[13px] font-semibold cursor-pointer rounded-[10px] transition-colors duration-150 bg-[#4a5e2a] text-white">
                        <i data-lucide="grid-3x3" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        Produtos
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- ── PAGE CONTENT ── --}}
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">

            {{-- Page header --}}
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-[28px] font-bold text-[#08273B] leading-tight">
                        Listagem de Produtos
                    </h1>
                    <p class="text-[13px] text-gray-500 mt-0.5">
                        Gerencie os produtos e suas validades
                    </p>
                </div>
                <button onclick="openModal()"
                        class="flex items-center gap-2 bg-[#08273B] hover:bg-[#0f3d5e] text-white text-[13px] font-bold px-5 h-[42px] rounded-[15px] transition-colors duration-150 flex-shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Adicionar Produto
                </button>
            </div>

            {{-- Search bar --}}
            <div class="relative mb-5">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text"
                       id="searchInput"
                       placeholder="Buscar produtos..."
                       oninput="filterProducts()"
                       class="w-full h-[42px] pl-10 pr-4 bg-white border border-gray-200 rounded-[10px] text-[13px] text-gray-500 placeholder:text-gray-400 outline-none focus:border-[#749048] transition-colors" />
            </div>

            {{-- Grid de produtos --}}
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- ─────────────────────────────────────────────────────────
                     BLADE: iterar sobre $products vindo do Controller.
                     Exemplo de uso no Controller:
                         return view('products.index', ['products' => Product::all()]);

                     Enquanto não há backend, os cards são gerados via JS
                     (veja a seção <script> abaixo).
                ───────────────────────────────────────────────────────── --}}

                {{--
                @foreach($products as $product)
                    @php
                        $now   = now();
                        $expiry = \Carbon\Carbon::parse($product->expiry_date);
                        $days  = $now->diffInDays($expiry, false);
                        $status = $product->status; // 'ok' | 'warning' | 'critical'
                    @endphp

                    <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col gap-2"
                         data-name="{{ strtolower($product->name) }}"
                         data-category="{{ strtolower($product->category) }}">

                        <!-- Header -->
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="package-2" class="w-[18px] h-[18px] text-[#749048] flex-shrink-0"></i>
                                <div>
                                    <p class="text-[12px] text-gray-400 leading-none mb-0.5">{{ $product->category }}</p>
                                    <h3 class="text-[18px] font-bold text-[#08273B] leading-tight">{{ $product->name }}</h3>
                                </div>
                            </div>
                            @if($status !== 'ok')
                                <i data-lucide="heart" class="w-4 h-4 text-[#841A1A] flex-shrink-0 mt-1"></i>
                            @endif
                        </div>

                        <hr class="border-gray-100" />

                        <!-- Info rows -->
                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] text-gray-400">Quantidade:</span>
                                <span class="text-[13px] font-semibold text-[#08273B]">{{ $product->quantity }} unidades</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] text-gray-400">Validade:</span>
                                <span class="text-[13px] font-semibold text-[#08273B]">{{ $expiry->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] text-gray-400">Adicionado em:</span>
                                <span class="text-[13px] font-semibold text-[#08273B]">{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <!-- Status badge -->
                        <div class="pt-1">
                            @if($status === 'critical')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold badge-critical">
                                    Vence em {{ $days }} dias
                                </span>
                            @elseif($status === 'warning')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold badge-warning">
                                    Vence em {{ $days }} dias
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold badge-ok">
                                    Vence em {{ $days }} dias
                                </span>
                            @endif
                        </div>

                        <!-- Botão doação -->
                        @if($status !== 'ok')
                            <button class="w-full h-[54px] mt-1 bg-[#08273B] hover:bg-[#0f3d5e] text-white text-[13px] font-bold rounded-[15px] transition-colors duration-150">
                                Disponibilizar para Doação
                            </button>
                        @endif
                    </div>
                @endforeach
                --}}

            </div>

            {{-- Empty state --}}
            <p id="emptyState" class="hidden text-center text-gray-400 text-[14px] mt-12">
                Nenhum produto encontrado.
            </p>
        </main>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL — Adicionar Produto
     Equivale ao <Dialog> do shadcn/ui
══════════════════════════════════════════ --}}
<div id="modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
     onclick="closeModalOnBackdrop(event)">

    <div class="bg-white rounded-2xl p-7 w-[444px] max-w-[95vw] shadow-2xl"
         id="modalBox">

        {{-- Header --}}
        <h2 class="text-[22px] font-bold text-[#08273B]">Adicionar Novo Produto</h2>
        <p class="text-[12px] text-gray-500 mt-0.5 mb-6">
            Preencha os dados do produto para adicionar ao sistema
        </p>

        {{-- Form --}}
        <div class="flex flex-col gap-4">
            {{-- Nome --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-[13px] font-semibold text-[#08273B]">Nome do Produto</label>
                <input type="text" placeholder="Ex: Leite Integral 1L"
                       class="w-full h-[54px] px-4 border border-gray-200 rounded-[15px] bg-gray-50 text-[14px] text-gray-700 placeholder:text-gray-300 outline-none focus:border-[#749048] focus:bg-white transition-colors" />
            </div>

            {{-- Categoria --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-[13px] font-semibold text-[#08273B]">Categoria</label>
                <input type="text" placeholder="Ex: Laticínios"
                       class="w-full h-[54px] px-4 border border-gray-200 rounded-[15px] bg-gray-50 text-[14px] text-gray-700 placeholder:text-gray-300 outline-none focus:border-[#749048] focus:bg-white transition-colors" />
            </div>

            {{-- Quantidade + Validade --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[13px] font-semibold text-[#08273B]">Quantidade</label>
                    <input type="number" placeholder="0"
                           class="w-full h-[54px] px-4 border border-gray-200 rounded-[15px] bg-gray-50 text-[14px] text-gray-700 placeholder:text-gray-300 outline-none focus:border-[#749048] focus:bg-white transition-colors" />
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[13px] font-semibold text-[#08273B]">Data de Validade</label>
                    <input type="text" placeholder="dd/mm/aaaa"
                           class="w-full h-[54px] px-4 border border-gray-200 rounded-[15px] bg-gray-50 text-[14px] text-gray-700 placeholder:text-gray-300 outline-none focus:border-[#749048] focus:bg-white transition-colors" />
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div class="flex gap-3 mt-6">
            <button onclick="closeModal()"
                    class="flex-1 h-[54px] bg-white border border-gray-200 hover:bg-gray-50 text-[14px] font-bold text-gray-600 rounded-[15px] transition-colors">
                Cancelar
            </button>
            <button onclick="closeModal()"
                    class="flex-1 h-[54px] bg-[#08273B] hover:bg-[#0f3d5e] text-white text-[14px] font-bold rounded-[15px] transition-colors">
                Adicionar
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     JAVASCRIPT
     • Mock data (remova quando usar o @foreach Blade)
     • Filtro de busca
     • Modal
     • Lucide icons init
══════════════════════════════════════════ --}}
<script>
/* ── Mock data — mesmos dados do TSX ──────────────────── */
const mockProducts = [
    { id:1, name:"Leite Integral 1L",  category:"Laticínios", quantity:45, expiryDate:"2026-03-25", addedDate:"2026-03-01", status:"warning"  },
    { id:2, name:"Iogurte Natural",    category:"Laticínios", quantity:30, expiryDate:"2026-03-21", addedDate:"2026-03-10", status:"critical" },
    { id:3, name:"Pão Integral",       category:"Padaria",    quantity:20, expiryDate:"2026-04-15", addedDate:"2026-03-15", status:"ok"       },
    { id:4, name:"Queijo Minas",       category:"Laticínios", quantity:15, expiryDate:"2026-03-28", addedDate:"2026-03-05", status:"ok"       },
    { id:5, name:"Presunto Fatiado",   category:"Frios",      quantity:25, expiryDate:"2026-03-22", addedDate:"2026-03-08", status:"warning"  },
    { id:6, name:"Pão Integral",       category:"Padaria",    quantity:20, expiryDate:"2026-04-15", addedDate:"2026-03-15", status:"ok"       },
];

/* ── Helpers ───────────────────────────────────────────── */
function diffInDays(dateStr) {
    const now    = new Date();
    const expiry = new Date(dateStr);
    return Math.round((expiry - now) / (1000 * 60 * 60 * 24));
}

function formatDate(dateStr) {
    const [y, m, d] = dateStr.split('-');
    return `${d}/${m}/${y}`;
}

function badgeClass(status) {
    if (status === 'critical') return 'badge-critical';
    if (status === 'warning')  return 'badge-warning';
    return 'badge-ok';
}

/* ── Renderiza os cards ────────────────────────────────── */
function renderCards(list) {
    const grid  = document.getElementById('productsGrid');
    const empty = document.getElementById('emptyState');

    if (list.length === 0) {
        grid.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }
    empty.classList.add('hidden');

    grid.innerHTML = list.map(p => {
        const days      = diffInDays(p.expiryDate);
        const showDonate = p.status !== 'ok';

        return `
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col gap-2"
             data-name="${p.name.toLowerCase()}" data-category="${p.category.toLowerCase()}">

            <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="package-2" class="w-[18px] h-[18px] text-[#749048] flex-shrink-0"></i>
                    <div>
                        <p class="text-[12px] text-gray-400 leading-none mb-0.5">${p.category}</p>
                        <h3 class="text-[18px] font-bold text-[#08273B] leading-tight">${p.name}</h3>
                    </div>
                </div>
                ${showDonate ? '<i data-lucide="heart" class="w-4 h-4 text-[#841A1A] flex-shrink-0 mt-1"></i>' : ''}
            </div>

            <hr class="border-gray-100" />

            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between items-center">
                    <span class="text-[13px] text-gray-400">Quantidade:</span>
                    <span class="text-[13px] font-semibold text-[#08273B]">${p.quantity} unidades</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[13px] text-gray-400">Validade:</span>
                    <span class="text-[13px] font-semibold text-[#08273B]">${formatDate(p.expiryDate)}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[13px] text-gray-400">Adicionado em:</span>
                    <span class="text-[13px] font-semibold text-[#08273B]">${formatDate(p.addedDate)}</span>
                </div>
            </div>

            <div class="pt-1">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold ${badgeClass(p.status)}">
                    Vence em ${days} dias
                </span>
            </div>

            ${showDonate ? `
            <button class="w-full h-[54px] mt-1 bg-[#08273B] hover:bg-[#0f3d5e] text-white text-[13px] font-bold rounded-[15px] transition-colors duration-150">
                Disponibilizar para Doação
            </button>` : ''}
        </div>`;
    }).join('');

    // Reinicia os ícones Lucide nos novos elementos
    lucide.createIcons();
}

/* ── Filtro ────────────────────────────────────────────── */
function filterProducts() {
    const term = document.getElementById('searchInput').value.toLowerCase();
    const filtered = mockProducts.filter(p =>
        p.name.toLowerCase().includes(term) ||
        p.category.toLowerCase().includes(term)
    );
    renderCards(filtered);
}

/* ── Modal ─────────────────────────────────────────────── */
function openModal()  { document.getElementById('modal').classList.remove('hidden'); }
function closeModal() { document.getElementById('modal').classList.add('hidden'); }
function closeModalOnBackdrop(e) {
    if (e.target === document.getElementById('modal')) closeModal();
}

/* ── Init ──────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    renderCards(mockProducts);
    lucide.createIcons();
});
</script>

</body>
</html>