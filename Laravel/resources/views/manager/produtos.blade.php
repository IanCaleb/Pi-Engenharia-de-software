<x-app-layout>
    <x-sidebar-nav-manager active="produtos">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

                {{-- Listagem de produtos --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold mb-4">Produtos:</h1>
                        <p class="text-lg text-gray-600 mb-6">Gerencie os produtos e suas validades!</p>

                        @if($products->isEmpty())
                            <p class="text-gray-500">Nenhum produto cadastrado ainda.</p>
                        @else
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-2 px-4">Produto</th>
                                        <th class="py-2 px-4">Categoria</th>
                                        <th class="py-2 px-4">Quantidade</th>
                                        <th class="py-2 px-4">Validade</th>
                                        <th class="py-2 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        @php
                                            $status = $product->expirationStatus();
                                            $message = $product->expirationMessage();

                                            $rowClass = match($status) {
                                                'expired' => 'bg-red-50',
                                                'warning' => 'bg-yellow-50',
                                                default   => 'bg-white',
                                            };

                                            $badgeClass = match($status) {
                                                'expired' => 'bg-red-100 text-red-800 border border-red-400',
                                                'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-400',
                                                default   => 'bg-green-100 text-green-800 border border-green-400',
                                            };
                                        @endphp
                                        <tr class="border-b {{ $rowClass }}">
                                            <td class="py-2 px-4 font-medium">{{ $product->name }}</td>
                                            <td class="py-2 px-4">{{ $product->category }}</td>
                                            <td class="py-2 px-4">{{ $product->quantity }}</td>
                                            <td class="py-2 px-4">{{ $product->expiration_date->format('d/m/Y') }}</td>
                                            <td class="py-2 px-4">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                    {{ $message }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-sidebar-nav-manager>
</x-app-layout>