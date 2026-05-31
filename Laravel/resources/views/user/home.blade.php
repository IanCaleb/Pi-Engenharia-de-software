<x-app-layout>
    <x-sidebar-nav-user active="home">

        {{-- Wrapper com padding responsivo (o <main> do sidebar não tem padding próprio) --}}
        <div class="p-4 sm:p-6">

            {{-- Boas-vindas --}}
            <p class="text-xl sm:text-2xl font-normal text-gray-800 leading-snug">
                Seja bem-vindo,
                <strong class="block font-bold">{{ Auth::user()->name }}!</strong>
            </p>

            {{-- ── Doação agendada ── --}}
            @isset($doacaoAgendada)
            @php
                $expira        = \Carbon\Carbon::parse($doacaoAgendada->batch->expiration_date ?? now());
                $diasRestantes = max(0, (int) \Carbon\Carbon::now()->diffInDays($expira, false));
            @endphp

            <div class="flex flex-col sm:flex-row items-stretch bg-white rounded-xl shadow-md overflow-hidden mt-5">

                {{-- Imagem --}}
                <img src="{{ asset('images/doacao-placeholder.jpg') }}"
                     alt="Foto da doação"
                     class="w-full sm:w-36 md:w-44 h-44 sm:h-auto object-cover flex-shrink-0">

                {{-- Corpo --}}
                <div class="flex-1 p-4 min-w-0">
                    <p class="text-sm font-bold text-[#841A1A]">Doação agendada:</p>
                    <p class="text-sm font-bold text-gray-800 mt-0.5">
                        {{ $doacaoAgendada->store->name ?? 'Loja não informada' }}
                    </p>
                    <p class="text-xs text-[#841A1A] mt-1.5 leading-relaxed">
                        {{ $doacaoAgendada->batch->product->name ?? 'Produto não informado' }}
                        — {{ $doacaoAgendada->quantity }} unidade(s)
                    </p>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="flex items-center gap-1 text-xs text-gray-500">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/>
                                <path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                            {{ $expira->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center gap-1 text-xs text-gray-500">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/>
                                <path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Vence em {{ $diasRestantes }} dia(s)
                        </span>
                    </div>
                </div>

                {{-- Painel validade + solicitar --}}
                <div class="flex flex-row sm:flex-col items-center justify-between sm:justify-center gap-3
                            border-t sm:border-t-0 sm:border-l border-gray-100
                            px-4 py-3 sm:px-5 sm:min-w-[160px]">
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold text-gray-800">Validade:</p>
                        <p class="text-lg sm:text-2xl font-bold text-[#841A1A] tracking-wide tabular-nums leading-tight">
                            {{ $expira->format('d/m/Y') }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('donation-requests.store') }}" class="w-full sm:w-auto">
                        @csrf
                        <input type="hidden" name="donation_id" value="{{ $doacaoAgendada->id }}">
                        <button type="submit"
                                class="w-full bg-[#789018] hover:bg-[#657c14] text-white text-sm font-semibold
                                       rounded-full px-5 py-2 transition-colors cursor-pointer whitespace-nowrap">
                            Solicitar
                        </button>
                    </form>
                </div>
            </div>
            @endisset

            {{-- ── Recentes ── --}}
            <h2 class="text-base sm:text-lg font-bold text-gray-800 mt-8 mb-3">Recente</h2>

            <div class="flex flex-col gap-2">
                @isset($doacoesRecentes)
                    @forelse($doacoesRecentes as $doacao)
                    @php
                        $exp = \Carbon\Carbon::parse($doacao->batch->expiration_date ?? now());
                    @endphp
                    <details class="bg-white rounded-lg shadow-sm overflow-hidden group">

                        <summary class="flex items-center justify-between px-3 sm:px-4 py-3 cursor-pointer list-none gap-2">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="flex-shrink-0">
                                    <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z"
                                          stroke="#841A1A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $doacao->batch->product->name ?? 'Produto não informado' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">
                                        {{ $doacao->quantity }} un.
                                        &bull; {{ $doacao->store->name ?? 'Loja não informada' }}
                                        &bull; {{ $exp->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <span class="flex-shrink-0 bg-[#841A1A] text-white text-xs sm:text-sm font-semibold
                                         rounded-full px-3 sm:px-4 py-1.5 flex items-center gap-1">
                                Detalhes
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                     class="transition-transform duration-200 group-open:rotate-180">
                                    <path d="M6 9l6 6 6-6" stroke="white" stroke-width="2.2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </summary>

                        <div class="border-t border-gray-100 px-3 sm:px-4 py-3">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-1.5">
                                <span class="text-sm font-bold text-gray-800">
                                    {{ $doacao->batch->product->name ?? 'Produto não informado' }}
                                </span>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex items-center gap-1 text-xs sm:text-sm text-gray-600">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#841A1A" stroke-width="1.7"/>
                                            <path d="M3 9h18M8 2v4M16 2v4" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round"/>
                                        </svg>
                                        {{ $exp->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center gap-1 text-xs sm:text-sm text-gray-600">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="12" r="9" stroke="#841A1A" stroke-width="1.7"/>
                                            <path d="M12 7v5l3 3" stroke="#841A1A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Lote: {{ $doacao->batch->batch_number ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">
                                Categoria: {{ $doacao->batch->product->category ?? 'N/A' }}
                                &bull; Status: {{ ucfirst($doacao->status) }}
                            </p>
                        </div>

                    </details>
                    @empty
                    <p class="text-sm text-gray-500 mt-2">Nenhuma doação recente encontrada.</p>
                    @endforelse
                @else
                    <p class="text-sm text-gray-500 mt-2">Nenhuma doação recente encontrada.</p>
                @endisset
            </div>

        </div>{{-- fim wrapper padding --}}

    </x-sidebar-nav-user>
</x-app-layout>
