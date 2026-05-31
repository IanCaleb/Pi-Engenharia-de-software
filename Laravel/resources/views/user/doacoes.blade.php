<x-app-layout>
    <x-sidebar-nav-user active="doacoes">

        {{-- Wrapper com padding responsivo (o <main> do sidebar não tem padding próprio) --}}
        <div class="p-4 sm:p-6">

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Doações:</h1>

            <div class="flex flex-col gap-2 mt-4">

                @isset($doacoes)
                    @forelse($doacoes as $doacao)
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
                                        {{ $doacao->store->name ?? 'Loja não informada' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">
                                        {{ $doacao->batch->product->category ?? 'Categoria não informada' }}
                                        &bull; {{ ucfirst($doacao->status) }}
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
                                        Vence: {{ $exp->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center gap-1 text-xs sm:text-sm text-gray-600">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                            <path d="M20 12v8H4v-8M22 7H2v5h20V7Z" stroke="#841A1A" stroke-width="1.7"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ $doacao->quantity }} unidade(s)
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">
                                Lote nº {{ $doacao->batch->batch_number ?? 'N/A' }}
                                &bull; Categoria: {{ $doacao->batch->product->category ?? 'N/A' }}
                            </p>
                        </div>

                    </details>
                    @empty
                    <p class="text-sm text-gray-500 mt-2">Nenhuma doação encontrada.</p>
                    @endforelse
                @else
                    <p class="text-sm text-gray-500 mt-2">Nenhuma doação encontrada.</p>
                @endisset

            </div>

        </div>{{-- fim wrapper padding --}}

    </x-sidebar-nav-user>
</x-app-layout>
