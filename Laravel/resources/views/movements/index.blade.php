<x-app-layout>
    <x-sidebar-nav-manager active="movimentacoes">
        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div
                x-data="{
                    openCreateModal: false,
                    openEditModal: false,

                    editMovement: {
                        id: '',
                        product_id: '',
                        movement_type: '',
                        moved_quantity: '',
                        unit_price: '',
                        movement_date: ''
                    }
                }"
            >
                <!-- HEADER -->
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">
                        Gestão de movimentações
                    </h1>

                    <button
                        @click="openCreateModal = true"
                        class="bg-[#749048] hover:bg-[#46572b] transition duration-300 text-white px-4 py-2 rounded-lg"
                    >
                        Nova movimentação
                    </button>
                </div>

                <!-- SUCCESS MESSAGE -->
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- TABLE -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-[#749048] text-white">
                            <tr>
                                <th class="text-left p-4">ID</th>
                                <th class="text-left p-4">Producto</th>
                                <th class="text-left p-4">Categoria</th>
                                <th class="text-left p-4">Quantidade</th>
                                <th class="text-left p-4">Preço Unitário</th>
                                <th class="text-left p-4">Data</th>
                                <th class="text-left p-4">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($movements as $movement)
                                <tr class="border-t">
                                    <td class="p-4">
                                        {{ $movement->id }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movement->product->name }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movement->movement_type }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movement->moved_quantity }}
                                    </td>

                                    <td class="p-4">
                                        $
                                        {{ number_format($movement->unit_price, 2) }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movement->movement_date }}
                                    </td>

                                    <td class="p-4 flex gap-2">
                                        <!-- DELETE -->
                                        <form
                                            action="{{ route('movements.destroy', $movement) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                            >
                                                Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- CREATE MODAL -->
                <div
                    x-show="openCreateModal"
                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
                >
                    <div
                        @click.away="openCreateModal = false"
                        class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold">
                                Nova Movimentação
                            </h2>

                            <button
                                @click="openCreateModal = false"
                                class="text-gray-500 hover:text-gray-700"
                            >
                                ✕
                            </button>
                        </div>

                        <form
                            action="{{ route('movements.store') }}"
                            method="POST"
                            class="space-y-4"
                        >
                            @csrf

                            <!-- PRODUCT -->
                            <div>
                                <label class="block mb-1 font-medium">
                                    Producto
                                </label>

                                <select
                                    name="product_id"
                                    class="w-full border rounded-lg p-2"
                                    required
                                >
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                            @if($product->batch)
                                                ({{ $product->batch->batch_number }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- TYPE -->
                            <div>
                                <label class="block mb-1 font-medium">
                                    Categoria
                                </label>

                                <select
                                    name="movement_type"
                                    class="w-full border rounded-lg p-2"
                                    required
                                >
                                    <option value="Compra">Compra</option>
                                    <option value="Venda">Venda</option>
                                </select>
                            </div>

                            <!-- QUANTITY -->
                            <div>
                                <label class="block mb-1 font-medium">
                                    Quantidade
                                </label>

                                <input
                                    type="number"
                                    name="moved_quantity"
                                    class="w-full border rounded-lg p-2"
                                    required
                                >
                            </div>

                            <!-- UNIT PRICE -->
                            <div>
                                <label class="block mb-1 font-medium">
                                    Preço Unitário
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="unit_price"
                                    class="w-full border rounded-lg p-2"
                                    required
                                >
                            </div>

                            <!-- DATE -->
                            <div>
                                <label class="block mb-1 font-medium">
                                    Data
                                </label>

                                <input
                                    type="datetime-local"
                                    name="movement_date"
                                    class="w-full border rounded-lg p-2"
                                    required
                                >
                            </div>

                            <!-- BUTTONS -->
                            <div class="flex justify-end gap-2 pt-4">
                                <button
                                    type="button"
                                    @click="openCreateModal = false"
                                    class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg"
                                >
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
                                >
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar-nav-manager>
</x-app-layout>