<x-app-layout>
    <x-sidebar-nav-user active="home">

        <style>
            /* ── Boas-vindas ── */
            .bv-titulo  { font-size:26px; font-weight:400; color:#1f2937; line-height:1.2; }
            .bv-titulo strong { display:block; font-weight:700; }

            /* ── Card doação agendada ── */
            .card-agendada {
                display:flex; align-items:stretch; gap:0;
                background:white; border-radius:.7rem;
                box-shadow:0 2px 8px rgba(0,0,0,.09);
                overflow:hidden; margin-top:1.25rem;
            }
            .card-agendada-img { width:160px; flex-shrink:0; object-fit:cover; display:block; }
            .card-agendada-body { flex:1; padding:1rem 1.2rem; min-width:0; }
            .card-agendada-tag  { font-size:14px; font-weight:700; color:#841A1A; margin-bottom:.2rem; }
            .card-agendada-loja { font-size:13px; font-weight:700; color:#1f2937; }
            .card-agendada-desc { font-size:12px; color:#841A1A; margin:.35rem 0 .6rem; line-height:1.5; }
            .card-agendada-pills { display:flex; align-items:center; gap:1rem; }
            .card-pill { display:flex; align-items:center; gap:.3rem; font-size:12px; color:#4b5563; }

            .card-agendada-timer { flex-shrink:0; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.6rem; padding:1.2rem 1.5rem; border-left:1px solid #f0f0f0; min-width:170px; }
            .timer-label { font-size:14px; font-weight:700; color:#1f2937; text-align:center; }
            .timer-clock { font-size:34px; font-weight:700; color:#841A1A; letter-spacing:2px; line-height:1; font-variant-numeric:tabular-nums; }
            .btn-solicitar { width:100%; background:#789018; color:white; border:none; border-radius:20px; height:40px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; transition:background .15s; }
            .btn-solicitar:hover { background:#657c14; }
            .btn-recusar  { width:100%; background:white; color:#789018; border:2px solid #789018; border-radius:20px; height:40px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; transition:all .15s; }
            .btn-recusar:hover  { background:#f5f5f5; }

            /* ── Recentes ── */
            .secao-titulo { font-size:18px; font-weight:700; color:#1f2937; margin-top:2rem; margin-bottom:.75rem; }

            .lista { display:flex; flex-direction:column; gap:.5rem; }
            .doacao-card { background:white; border-radius:.55rem; box-shadow:0 1px 2px rgba(0,0,0,.07); overflow:hidden; }
            .doacao-item { display:flex; align-items:center; justify-content:space-between; padding:.75rem 1rem; }
            .doacao-left { display:flex; align-items:center; gap:.75rem; flex:1; min-width:0; }
            .doacao-titulo { font-size:14px; font-weight:600; color:#1f2937; }
            .doacao-meta   { font-size:12px; color:#6b7280; margin-top:.1rem; }

            .btn-detalhes {
                background:#841A1A; color:white; border:none; border-radius:15px;
                height:38px; padding:0 1rem 0 1.1rem;
                font-size:14px; font-weight:600; cursor:pointer;
                font-family:inherit; transition:background .15s;
                flex-shrink:0; display:flex; align-items:center; gap:.45rem;
            }
            .btn-detalhes:hover { background:#6e1616; }
            .btn-detalhes .seta { display:inline-flex; transition:transform .25s ease; }
            .doacao-card.open .btn-detalhes .seta { transform:rotate(180deg); }

            .doacao-detalhes {
                max-height:0; overflow:hidden;
                transition:max-height .3s ease, padding .3s ease;
                border-top:1px solid transparent; padding:0 1rem;
            }
            .doacao-card.open .doacao-detalhes {
                max-height:200px; padding:.85rem 1rem 1rem; border-top-color:#f0f0f0;
            }
            .det-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem; margin-bottom:.55rem; }
            .det-nome   { font-size:14px; font-weight:700; color:#1f2937; }
            .det-info   { display:flex; align-items:center; gap:1.25rem; }
            .det-pill   { display:flex; align-items:center; gap:.35rem; font-size:13px; color:#4b5563; }
            .det-endereco { font-size:12px; color:#6b7280; }

            /* ── Modal confirmação ── */
            .modal-overlay {
                display:none; position:fixed; inset:0;
                background:rgba(0,0,0,.45); z-index:200;
                align-items:center; justify-content:center;
            }
            .modal-overlay.open { display:flex; }
            .modal-box {
                background:white; border-radius:1rem;
                padding:2rem 1.75rem; max-width:360px; width:90%;
                box-shadow:0 20px 50px rgba(0,0,0,.25);
                text-align:center; animation:popIn .2s ease;
            }
            @keyframes popIn { from { transform:scale(.92); opacity:0; } to { transform:scale(1); opacity:1; } }
            .modal-icon  { font-size:36px; margin-bottom:.75rem; }
            .modal-titulo{ font-size:17px; font-weight:700; color:#1f2937; margin-bottom:.4rem; }
            .modal-desc  { font-size:13px; color:#6b7280; margin-bottom:1.5rem; line-height:1.5; }
            .modal-acoes { display:flex; gap:.75rem; }
            .modal-acoes button { flex:1; height:42px; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; border:none; transition:all .15s; }
            .btn-modal-confirm-sol { background:#789018; color:white; }
            .btn-modal-confirm-sol:hover { background:#657c14; }
            .btn-modal-confirm-rec { background:#841A1A; color:white; }
            .btn-modal-confirm-rec:hover { background:#6e1616; }
            .btn-modal-cancel  { background:#f3f4f6; color:#374151; }
            .btn-modal-cancel:hover { background:#e5e7eb; }

            /* ── Sem doação agendada ── */
            .sem-agendada { display:none; } /* back-end controla via @if */

            /* ── Responsivo ── */
            @media (max-width: 768px) {
                .card-agendada { flex-direction:column; }
                .card-agendada-img { width:100%; height:180px; }
                .card-agendada-timer { flex-direction:row; flex-wrap:wrap; border-left:none; border-top:1px solid #f0f0f0; padding:1rem; min-width:unset; justify-content:space-between; }
                .timer-label { font-size:13px; }
                .timer-clock { font-size:32px; }
                .modal-acoes { flex-direction:column; }
            }
            @media (max-width: 640px) {
                .bv-titulo { font-size:20px; }
                .doacao-item { flex-wrap:wrap; gap:.5rem; }
                .doacao-titulo { font-size:13px; }
                .doacao-meta   { font-size:11px; }
                .btn-detalhes  { height:34px; font-size:13px; padding:0 .75rem 0 .85rem; }
                .det-info { flex-wrap:wrap; gap:.6rem; }
            }
        </style>

        {{-- Boas-vindas --}}
        <p class="bv-titulo">Seja bem-vindo, <strong>{{ Auth::user()->name }}!</strong></p>

        {{-- ── Doação agendada (some quando não há nenhuma) ── --}}
        @if(isset($doacaoAgendada))
        <div class="card-agendada">
            <img class="card-agendada-img"
                 src="{{ $doacaoAgendada->imagem_url ?? asset('images/doacao-placeholder.jpg') }}"
                 alt="Foto da doação">

            <div class="card-agendada-body">
                <div class="card-agendada-tag">Doação agendada:</div>
                <div class="card-agendada-loja">{{ $doacaoAgendada->loja }} - {{ $doacaoAgendada->endereco }}</div>
                <div class="card-agendada-desc">{{ $doacaoAgendada->descricao }}</div>
                <div class="card-agendada-pills">
                    <span class="card-pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/><path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/></svg>
                        {{ \Carbon\Carbon::parse($doacaoAgendada->data)->format('d/m/Y') }}
                    </span>
                    <span class="card-pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/><path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ $doacaoAgendada->horario }}
                    </span>
                </div>
            </div>

            <div class="card-agendada-timer">
                <div class="timer-label">Tempo restante:</div>
                <div class="timer-clock" id="timerClock">--:--</div>
                <button class="btn-solicitar" onclick="abrirModal('solicitar')">Solicitar</button>
                <button class="btn-recusar"   onclick="abrirModal('recusar')">Recusar</button>
            </div>
        </div>

        {{-- dados para o JS do timer --}}
        <script>
            window._doacaoHorario = "{{ \Carbon\Carbon::parse($doacaoAgendada->data . ' ' . $doacaoAgendada->horario)->toISOString() }}";
            window._doacaoId      = {{ $doacaoAgendada->id }};
        </script>
        @endif
        {{-- fim doação agendada --}}

        {{-- ── Recentes ── --}}
        <div class="secao-titulo">Recente</div>

        <div class="lista">
            @forelse($doacoesRecentes as $doacao)
            <div class="doacao-card">
                <div class="doacao-item">
                    <div class="doacao-left">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z"
                                  stroke="#841A1A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <div class="doacao-titulo">{{ $doacao->titulo }}</div>
                            <div class="doacao-meta">
                                {{ $doacao->quantidade }} unidade(s) disponível
                                &bull; {{ $doacao->loja }}
                                &bull; {{ \Carbon\Carbon::parse($doacao->data)->format('d/m/Y') }}
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
                <div class="doacao-detalhes">
                    <div class="det-header">
                        <span class="det-nome">{{ $doacao->titulo }}</span>
                        <div class="det-info">
                            <span class="det-pill">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/><path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/></svg>
                                {{ \Carbon\Carbon::parse($doacao->data)->format('d/m/Y') }}
                            </span>
                            <span class="det-pill">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/><path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                {{ $doacao->horario ?? '09:00' }}
                            </span>
                        </div>
                    </div>
                    <div class="det-endereco">{{ $doacao->endereco }}</div>
                </div>
            </div>
            @empty
            <p style="color:#6b7280; font-size:14px;">Nenhuma doação recente encontrada.</p>
            @endforelse
        </div>

        {{-- ── Modal confirmação ── --}}
        <div class="modal-overlay" id="modalOverlay">
            <div class="modal-box" id="modalBox">
                <div class="modal-icon" id="modalIcon"></div>
                <div class="modal-titulo" id="modalTitulo"></div>
                <div class="modal-desc"   id="modalDesc"></div>
                <div class="modal-acoes">
                    <button id="btnConfirmar" onclick="confirmarAcao()"></button>
                    <button class="btn-modal-cancel" onclick="fecharModal()">Cancelar</button>
                </div>
            </div>
        </div>

        <script>
            /* ── Accordion detalhes ── */
            function toggleDetalhes(btn) {
                btn.closest('.doacao-card').classList.toggle('open');
            }

            /* ── Modal ── */
            let _acaoAtual = null;

            function abrirModal(acao) {
                _acaoAtual = acao;
                const icon   = document.getElementById('modalIcon');
                const titulo = document.getElementById('modalTitulo');
                const desc   = document.getElementById('modalDesc');
                const btnC   = document.getElementById('btnConfirmar');

                if (acao === 'solicitar') {
                    icon.textContent   = '🎁';
                    titulo.textContent = 'Confirmar solicitação';
                    desc.textContent   = 'Tem certeza que deseja solicitar esta doação? Você ficará responsável pela retirada no horário indicado.';
                    btnC.textContent   = 'Sim, solicitar';
                    btnC.className     = 'btn-modal-confirm-sol';
                } else {
                    icon.textContent   = '❌';
                    titulo.textContent = 'Confirmar recusa';
                    desc.textContent   = 'Tem certeza que deseja recusar esta doação? Ela poderá ser oferecida a outro donatário.';
                    btnC.textContent   = 'Sim, recusar';
                    btnC.className     = 'btn-modal-confirm-rec';
                }

                document.getElementById('modalOverlay').classList.add('open');
            }

            function fecharModal() {
                document.getElementById('modalOverlay').classList.remove('open');
                _acaoAtual = null;
            }

            function confirmarAcao() {
                if (!_acaoAtual || !window._doacaoId) return;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = _acaoAtual === 'solicitar'
                    ? `/doacoes/${window._doacaoId}/solicitar`
                    : `/doacoes/${window._doacaoId}/recusar`;
                const csrf = document.createElement('input');
                csrf.type  = 'hidden'; csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }

            /* Fechar clicando fora do modal */
            document.getElementById('modalOverlay').addEventListener('click', function(e) {
                if (e.target === this) fecharModal();
            });

            /* ── Countdown timer ── */
            (function() {
                const el = document.getElementById('timerClock');
                if (!el || !window._doacaoHorario) return;

                function tick() {
                    const diff = new Date(_doacaoHorario) - new Date();
                    if (diff <= 0) {
                        el.textContent = '00:00:00';
                        el.style.color = '#9ca3af';
                        return;
                    }
                    const h = String(Math.floor(diff / 3600000)).padStart(2,'0');
                    const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
                    const s = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
                    el.textContent = h + ':' + m + ':' + s;
                }
                tick();
                setInterval(tick, 1000);
            })();
        </script>

    </x-sidebar-nav-user>
</x-app-layout>
