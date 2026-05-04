<x-app-layout>
    <x-sidebar-nav-manager active="doacoes">

        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

            {{-- Mensagens de sucesso/erro --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Título --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Doações</h1>
                <p class="text-sm text-gray-500">Gerencie as solicitações de doações e produtos disponíveis</p>
            </div>

            {{-- Seção 1: Produtos Disponíveis para Doação --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-6">
                <h2 class="text-lg font-bold text-gray-900">Produtos Disponíveis para Doação</h2>
                <p class="text-sm text-gray-500 mb-4">Produtos próximos ao vencimento que podem ser doados</p>

                <div class="space-y-3">
                    @forelse($donations as $donation)
                    <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white shadow-sm">
                                <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $donation->batch->product->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $donation->quantity }} unidades disponíveis
                                    &bull;
                                    Vence em {{ $donation->batch->expiration_date->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 md:flex-row md:items-center">
                            <span class="inline-flex w-fit items-center rounded-full bg-[#841a1a] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">
                                {{ $donation->requests->where('status', 'pendente')->count() }} solicitações
                            </span>
                            <a href="#solicitacoes" class="rounded-lg bg-[#08273b] px-4 py-2 text-sm font-medium text-white text-center transition hover:bg-[#0a3350] whitespace-nowrap">
                                Ver Solicitações
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-sm text-gray-500 py-4">Nenhuma doação disponível no momento.</p>
                    @endforelse
                </div>
            </div>

            {{-- Seção 2: Solicitações de Doações --}}
            <div id="solicitacoes" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h2 class="text-lg font-bold text-gray-900">Solicitações de Doações</h2>
                <p class="text-sm text-gray-500 mb-4">Lojas e instituições que solicitaram produtos</p>

                <div class="space-y-4">
                    @forelse($donationRequests as $req)
                    <div class="rounded-xl border bg-white p-4
                        @if($req->status === 'pendente') border-[#841a1a]
                        @elseif($req->status === 'aceito') border-[#08273b]
                        @else border-[#749048] @endif">

                        {{-- Cabeçalho --}}
                        <div class="mb-3 flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-gray-100">
                                    <svg class="h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 12v8H4v-8M22 7H2v5h20V7ZM12 20V7M12 7H7.5a2.5 2.5 0 1 1 2.2-3.7L12 7ZM12 7h4.5a2.5 2.5 0 1 0-2.2-3.7L12 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $req->donation->batch->product->name }}</p>
                                    <div class="flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 21h18M3 7v14M21 7v14M6 11h2m-2 4h2m8-4h2m-2 4h2M9 21V11h6v10M3 7l9-4 9 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ $req->donatario->name ?? 'Solicitante #'.$req->donatario_id }}
                                    </div>
                                </div>
                            </div>

                            @if($req->status === 'pendente')
                                <span class="rounded-full bg-[#841a1a] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Pendente</span>
                            @elseif($req->status === 'aceito')
                                <span class="rounded-full bg-[#08273b] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Aceito</span>
                            @else
                                <span class="rounded-full bg-[#749048] px-3 py-1 text-xs font-semibold text-white whitespace-nowrap">Concluído</span>
                            @endif
                        </div>

                        {{-- Infos --}}
                        <div class="mb-3 w-full text-sm" style="display:grid; grid-template-columns: 0.8fr 1.1fr 1.1fr; width:100%;">
                            <div>
                                <p class="text-[10px] font-bold uppercase text-gray-400">Quantidade</p>
                                <p class="font-bold text-gray-900">
                                    <span class="md:hidden">{{ $req->donation->quantity }} uni.</span>
                                    <span class="hidden md:inline">{{ $req->donation->quantity }} unidades</span>
                                </p>
                            </div>
                            <div style="text-align:center;">
                                <p class="text-[10px] font-bold uppercase text-gray-400">Validade</p>
                                <p class="font-bold text-gray-900">{{ $req->donation->batch->expiration_date->format('d/m/Y') }}</p>
                            </div>
                            <div style="text-align:right;">
                                <p class="text-[10px] font-bold uppercase text-gray-400">Solicitado</p>
                                <p class="font-bold text-gray-900">{{ $req->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        {{-- Botões --}}
                        @if($req->status === 'pendente')
                        <div class="flex flex-col gap-2 md:grid md:grid-cols-2">
                            <form action="{{ route('donations.updateStatus', $req->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="recusado">
                                <button type="submit" class="w-full rounded-lg bg-[#841a1a] py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                                    Recusar
                                </button>
                            </form>
                            <form action="{{ route('donations.updateStatus', $req->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="aceito">
                                <button type="submit" class="w-full rounded-lg bg-[#749048] py-2 text-sm font-medium text-white transition hover:bg-[#5e7a3a]">
                                    Aceitar solicitação
                                </button>
                            </form>
                        </div>
                        @elseif($req->status === 'aceito')
                        <form action="{{ route('donations.concluir', $req->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full rounded-lg bg-[#08273b] py-2 text-sm font-medium text-white transition hover:bg-[#0a3350]">
                                Marcar como retirado
                            </button>
                        </form>
                        @endif

                    </div>
                    @empty
                    <p class="text-center text-sm text-gray-500 py-4">Nenhuma solicitação recebida ainda.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </x-sidebar-nav-manager>
</x-app-layout>
