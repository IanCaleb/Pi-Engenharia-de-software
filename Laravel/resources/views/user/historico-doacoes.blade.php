<x-app-layout>
    <x-sidebar-nav-user active="doacoes">

        <style>
            .lista { display:flex; flex-direction:column; gap:.5rem; margin-top:1rem; }

            /* Card wrapper */
            .doacao-card { background:white; border-radius:.55rem; box-shadow:0 1px 2px rgba(0,0,0,.07); overflow:hidden; }

            /* Linha principal */
            .doacao-item { display:flex; align-items:center; justify-content:space-between; padding:.75rem 1rem; }
            .doacao-left { display:flex; align-items:center; gap:.75rem; flex:1; min-width:0; }
            .doacao-titulo { font-size:14px; font-weight:600; color:#1f2937; }
            .doacao-meta   { font-size:12px; color:#6b7280; margin-top:.1rem; }

            /* Botão detalhes com seta */
            .btn-detalhes {
                background:#841A1A; color:white; border:none; border-radius:15px;
                height:38px; padding:0 1rem 0 1.1rem;
                font-size:14px; font-weight:600; cursor:pointer;
                font-family:inherit; transition:background .15s;
                flex-shrink:0; display:flex; align-items:center; gap:.45rem;
            }
            .btn-detalhes:hover { background:#6e1616; }
            .btn-detalhes .seta {
                display:inline-flex; transition:transform .25s ease;
            }
            .doacao-card.open .btn-detalhes .seta { transform:rotate(180deg); }

            /* Painel expandido */
            .doacao-detalhes {
                max-height: 0;
                overflow: hidden;
                transition: max-height .3s ease, padding .3s ease;
                border-top: 1px solid transparent;
                padding: 0 1rem;
            }
            .doacao-card.open .doacao-detalhes {
                max-height: 200px;
                padding: .85rem 1rem 1rem;
                border-top-color: #f0f0f0;
            }

            /* Conteúdo do painel */
            .det-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem; margin-bottom:.55rem; }
            .det-nome { font-size:14px; font-weight:700; color:#1f2937; }
            .det-info { display:flex; align-items:center; gap:1.25rem; }
            .det-pill { display:flex; align-items:center; gap:.35rem; font-size:13px; color:#4b5563; }
            .det-endereco { font-size:12px; color:#6b7280; margin-top:.1rem; }

            /* Responsividade */
            @media (max-width: 640px) {
                .doacao-item  { flex-wrap:wrap; gap:.5rem; }
                .doacao-titulo { font-size:13px; }
                .doacao-meta   { font-size:11px; }
                .btn-detalhes  { height:34px; font-size:13px; padding:0 .75rem 0 .85rem; }
                .det-info { flex-wrap:wrap; gap:.6rem; }
            }
        </style>

        <h1 style="font-size:32px; font-weight:700;">Doações:</h1>

        <div class="lista">

            @forelse($doacoes as $doacao)
            <div class="doacao-card">
                <!-- Linha principal -->
                <div class="doacao-item">
                    <div class="doacao-left">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z"
                                  stroke="#841A1A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <div class="doacao-titulo">{{ $doacao->loja }}</div>
                            <div class="doacao-meta">
                                {{ $doacao->cidade }} &bull; Disponível &bull; {{ \Carbon\Carbon::parse($doacao->data)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    <button class="btn-detalhes" onclick="toggleDetalhes(this)">
                        Detalhes
                        <span class="seta">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Painel expandido -->
                <div class="doacao-detalhes">
                    <div class="det-header">
                        <span class="det-nome">{{ $doacao->titulo }}</span>
                        <div class="det-info">
                            <span class="det-pill">
                                <!-- ícone calendário -->
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/>
                                    <path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($doacao->data)->format('d/m/Y') }}
                            </span>
                            <span class="det-pill">
                                <!-- ícone relógio -->
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/>
                                    <path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                {{ $doacao->horario ?? '09:00' }}
                            </span>
                        </div>
                    </div>
                    <div class="det-endereco">{{ $doacao->endereco }}</div>
                </div>
            </div>
            @empty
            <p style="color:#6b7280; margin-top:1rem; font-size:14px;">Nenhuma doação encontrada.</p>
            @endforelse

        </div>

        <script>
            function toggleDetalhes(btn) {
                const card = btn.closest('.doacao-card');
                card.classList.toggle('open');
            }
        </script>

    </x-sidebar-nav-user>
</x-app-layout>
