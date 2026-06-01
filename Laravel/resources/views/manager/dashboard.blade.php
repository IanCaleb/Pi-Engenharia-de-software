<x-app-layout>
    <x-sidebar-nav-manager active="dashboard">
        <div class="py-12">
            <div class="flex flex-col items-center max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Cabeçalho --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl sm:rounded-lg mb-6 p-6 w-[92vw] md:w-full">
                    <div class="mb-4">
                        <h1 class="text-3xl font-bold mb-2">Dashboard:</h1>
                        <p class="text-lg text-gray-600">Visão geral do controle de validade e doações</p>
                    </div>

                    <x-fillters-dashboard>
                        <x-slot name="filters">
                            
                            <!-- Select: Últimos 30 dias -->
                            <select class="bg-white border border-gray-300 rounded-full px-8 py-2 text-sm">
                                <option>Últimos 30 dias</option>
                                <option>Últimos 7 dias</option>
                                <option>Hoje</option>
                            </select>

                            <!-- Select: Categorias -->
                            <select class="bg-white border border-gray-300 rounded-full px-8 py-2 text-sm">
                                <option>Categorias</option>
                                <option>Alimentos</option>
                                <option>Bebidas</option>
                            </select>

                        </x-slot>
                    </x-fillters-dashboard>
                    
                    <x-stats-cards :cards="$cards" />

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    
                        <x-monthly-chart
                            chartId="graficoMensal"
                            title="Tendências Mensais"
                            subtitle="Últimos meses"
                            :labels="$labels"
                            :compras="$compras"
                            :vendas="$vendas"
                            :desperdicios="$desperdicios"
                        />

                        <x-loss-rate-chart
                            chartId="taxaPerda"
                            title="Taxa de Perda"
                            subtitle="Evolução mensal da taxa de desperdícios"
                            :labels="$lossLabels"
                            :data="$lossData"
                        />

                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <x-category-pie-chart
                            chartId="graficoCategorias"
                            title="Distribuição por Categoria"
                            :labels="$catLabels"
                            :data="$catData"
                        />

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <x-rotative-list 
                                :items="$topRotatividade"
                                type="top"
                            />

                            <x-rotative-list 
                                :items="$slowRotatividade"
                                type="bottom"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <x-excessive-list :items="[
                                ['nome' => 'Leite integral', 'perda' => '30%'],
                                ['nome' => 'Arroz', 'perda' => '30%'],
                                ['nome' => 'Macarrão', 'perda' => '30%'],
                                ['nome' => 'Leite integral', 'perda' => '30%'],
                                ['nome' => 'Arroz', 'perda' => '30%'],
                                ['nome' => 'Macarrão', 'perda' => '30%']
                            ]" 
                            type="bottom"
                            />
                            <x-excessive-list :items="[
                                ['nome' => 'Leite integral', 'perda' => '10%'],
                                ['nome' => 'Arroz', 'perda' => '10%'],
                                ['nome' => 'Macarrão', 'perda' => '10%'],
                                ['nome' => 'Leite integral', 'perda' => '10%'],
                                ['nome' => 'Arroz', 'perda' => '10%'],
                                ['nome' => 'Macarrão', 'perda' => '10%']
                            ]" 
                            type="top"
                            />
                        </div>

                        <x-next-losses :items="$nextLosses" />

                    </div>

                    
                </div>
            </div>
        </div>
    </x-sidebar-nav-manager>
</x-app-layout>