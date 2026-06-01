<x-app-layout>
    <x-sidebar-nav-user active="doacoes">
        {{-- Área principal de conteúdo da página --}}
        <main class="w-full bg-white px-8 py-8 min-h-screen">
            <h1 class="mb-8 text-2xl font-bold text-gray-800">Minhas Doações Solicitadas</h1>

            @if ($donationRequests->isEmpty())
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2m0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8m3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" stroke-width="0" fill="currentColor"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhuma doação solicitada</h3>
                    <p class="mt-2 text-sm text-gray-600">Comece a buscar doações na seção <strong>Buscar lojas</strong></p>
                    <a href="{{ route('user.buscar-lojas') }}" class="mt-4 inline-block rounded-lg bg-[#841A1A] px-6 py-2 text-sm font-medium text-white transition hover:bg-[#6b1515]">
                        Buscar doações
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($donationRequests as $request)
                        <article class="rounded-xl border border-gray-200 bg-gray-50 px-6 py-5 shadow-sm">
                            <header class="mb-4 flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            {{ $request->donation->batch->product->name }}
                                        </h3>
                                        <span class="rounded-full px-3 py-1 text-xs font-medium"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': '{{ $request->status }}' === 'pendente',
                                                'bg-green-100 text-green-800': '{{ $request->status }}' === 'aceito',
                                                'bg-red-100 text-red-800': '{{ $request->status }}' === 'recusado'
                                            }">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">De: <strong>{{ $request->donation->store->name }}</strong></p>
                                </div>
                            </header>

                            <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-4">
                                <div>
                                    <p class="text-xs text-gray-600">Quantidade</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $request->donation->quantity }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Vencimento</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $request->donation->batch->expiration_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Local</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $request->donation->store->city }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Solicitada em</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $request->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Endereço da loja -->
                            @if ($request->donation->store->rua && $request->donation->store->numero && $request->donation->store->bairro)
                                <div class="rounded-lg bg-blue-50 border border-blue-200 p-4 mb-4">
                                    <p class="text-sm font-semibold text-blue-900 mb-2">📍 Localização da Loja para Retirada:</p>
                                    <p class="text-sm text-blue-800 mb-1"><strong>{{ $request->donation->store->rua }}, {{ $request->donation->store->numero }}</strong></p>
                                    <p class="text-sm text-blue-800 mb-1">{{ $request->donation->store->bairro }} - {{ $request->donation->store->city }}</p>
                                    @if ($request->donation->store->cep)
                                        <p class="text-sm text-blue-800">CEP: {{ $request->donation->store->cep }}</p>
                                    @endif
                                </div>
                            @endif

                            @if ($request->status === 'pendente')
                                <div class="rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                                    Aguardando aprovação do gerente...
                                </div>
                            @elseif ($request->status === 'aceito')
                                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                                    ✓ Sua solicitação foi aprovada! Dirija-se ao local para retirada.
                                </div>
                            @elseif ($request->status === 'recusado')
                                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                                    ✗ Sua solicitação foi recusada pelo gerente.
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </main>

    </x-sidebar-nav-user>
</x-app-layout>
