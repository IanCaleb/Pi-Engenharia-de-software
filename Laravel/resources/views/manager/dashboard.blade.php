<x-app-layout>
    <x-sidebar-nav-manager active="dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Cabeçalho --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold mb-2">Dashboard:</h1>
                        <p class="text-lg text-gray-600">Visão geral do controle de validade e doações</p>
                    </div>
                </div>

                {{-- Resumo de urgências --}}
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-red-100 border border-red-400 text-red-800 p-4 rounded-lg text-center">
                        <p class="text-2xl font-bold">{{ $expired }}</p>
                        <p class="text-sm font-semibold">Vencidos</p>
                    </div>
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-4 rounded-lg text-center">
                        <p class="text-2xl font-bold">{{ $warning }}</p>
                        <p class="text-sm font-semibold">Vencem em até 7 dias</p>
                    </div>
                    <div class="bg-green-100 border border-green-400 text-green-800 p-4 rounded-lg text-center">
                        <p class="text-2xl font-bold">{{ $safe }}</p>
                        <p class="text-sm font-semibold">Em dia</p>
                    </div>
                </div>

                {{-- Produtos que precisam de atenção --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Produtos que precisam de atenção:</h2>

                        @php
                            $urgent = $products->filter(fn($p) => $p->expirationStatus() !== 'safe');
                        @endphp

                        @if($urgent->isEmpty())
                            <p class="text-green-600 font-medium">Todos os produtos estão em dia!</p>
                        @else
                            <ul class="space-y-2">
                                @foreach($urgent as $product)
                                    @php
                                        $status = $product->expirationStatus();
                                        $badgeClass = $status === 'expired'
                                            ? 'bg-red-100 text-red-800 border border-red-400'
                                            : 'bg-yellow-100 text-yellow-800 border border-yellow-400';
                                    @endphp
                                    <li class="flex items-center justify-between border-b pb-2">
                                        <span class="font-medium">{{ $product->name }}</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                            {{ $product->expirationMessage() }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-sidebar-nav-manager>
</x-app-layout>