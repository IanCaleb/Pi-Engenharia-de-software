@php
// ==============================
// BALANÇO DE MOVIMENTAÇÕES (ÚLTIMOS 4 MESES)
// ==============================

$movimentacoes = require app_path('../database/Lista-Produtos/movimentacoes.php');

$mensal = [];

$mesesPT = [
    1=>'Jan',2=>'Fev',3=>'Mar',4=>'Abr',5=>'Mai',6=>'Jun',
    7=>'Jul',8=>'Ago',9=>'Set',10=>'Out',11=>'Nov',12=>'Dez'
];

$agora = new DateTime();
$inicio = (clone $agora)->modify('-3 months')->modify('first day of this month');

// 🔹 percorre movimentações
foreach ($movimentacoes as $mov) {
    $dataMov = new DateTime($mov['data_movimentacao']);

    // 🔥 filtro: só últimos 4 meses
    if ($dataMov < $inicio || $dataMov > $agora) {
        continue;
    }

    $mesNumero = (int)$dataMov->format('n');

    if (!isset($mensal[$mesNumero])) {
        $mensal[$mesNumero] = [
            'label' => $mesesPT[$mesNumero],
            'compras' => 0,
            'vendas' => 0,
            'desperdicios' => 0,
        ];
    }

    switch ($mov['tipo_movimentacao']) {
        case 'compra':
            $mensal[$mesNumero]['compras'] += $mov['quantidade'];
            break;

        case 'venda':
            $mensal[$mesNumero]['vendas'] += $mov['quantidade'];
            break;

        case 'vencimento':
        case 'desperdicio':
            $mensal[$mesNumero]['desperdicios'] += $mov['quantidade'];
            break;
    }
}

// 🔹 garante os 4 meses mesmo sem dados
for ($i = 3; $i >= 0; $i--) {
    $dataRef = (clone $agora)->modify("-$i months");
    $mesNumero = (int)$dataRef->format('n');

    if (!isset($mensal[$mesNumero])) {
        $mensal[$mesNumero] = [
            'label' => $mesesPT[$mesNumero],
            'compras' => 0,
            'vendas' => 0,
            'desperdicios' => 0,
        ];
    }
}

// 🔹 ordena corretamente
ksort($mensal);

// 🔹 separa para o gráfico
$labels = array_column($mensal, 'label');
$compras = array_column($mensal, 'compras');
$vendas = array_column($mensal, 'vendas');
$desperdicios = array_column($mensal, 'desperdicios');
@endphp

@php
// ==============================
// TAXA DE PERDA (ÚLTIMOS 4 MESES)
// ==============================

$mensalPerda = [];

$mesesPT = [
    1=>'Jan',2=>'Fev',3=>'Mar',4=>'Abr',5=>'Mai',6=>'Jun',
    7=>'Jul',8=>'Ago',9=>'Set',10=>'Out',11=>'Nov',12=>'Dez'
];

$agora = new DateTime();
$inicio = (clone $agora)->modify('-3 months')->modify('first day of this month');

// 🔹 percorre movimentações
foreach ($movimentacoes as $mov) {
    $dataMov = new DateTime($mov['data_movimentacao']);

    // 🔥 filtro: só últimos 4 meses
    if ($dataMov < $inicio || $dataMov > $agora) {
        continue;
    }

    $mesNumero = (int)$dataMov->format('n');

    if (!isset($mensalPerda[$mesNumero])) {
        $mensalPerda[$mesNumero] = [
            'label' => $mesesPT[$mesNumero],
            'entrada' => 0,
            'perda' => 0,
        ];
    }

    switch ($mov['tipo_movimentacao']) {
        case 'compra':
            $mensalPerda[$mesNumero]['entrada'] += $mov['quantidade'];
            break;

        case 'vencimento':
        case 'desperdicio':
            $mensalPerda[$mesNumero]['perda'] += $mov['quantidade'];
            break;
    }
}

// 🔹 garante os 4 meses mesmo sem dados
for ($i = 3; $i >= 0; $i--) {
    $dataRef = (clone $agora)->modify("-$i months");
    $mesNumero = (int)$dataRef->format('n');

    if (!isset($mensalPerda[$mesNumero])) {
        $mensalPerda[$mesNumero] = [
            'label' => $mesesPT[$mesNumero],
            'entrada' => 0,
            'perda' => 0,
        ];
    }
}

// 🔹 ordena
ksort($mensalPerda);

// 🔹 gera arrays finais
$lossLabels = [];
$lossData = [];

foreach ($mensalPerda as $mes) {
    $lossLabels[] = $mes['label'];

    $taxa = $mes['entrada'] > 0
        ? ($mes['perda'] / $mes['entrada']) * 100
        : 0;

    $lossData[] = round($taxa, 2);
}
@endphp

@php
// ==============================
// VENCIMENTOS POR CATEGORIA (ÚLTIMOS 4 MESES)
// ==============================

$movimentacoes = require app_path('../database/Lista-Produtos/movimentacoes.php');

$categorias = [];

$agora = new DateTime();
$inicio = (clone $agora)->modify('-3 months')->modify('first day of this month');

foreach ($movimentacoes as $mov) {

    $dataMov = new DateTime($mov['data_movimentacao']);

    // 🔥 filtro: últimos 4 meses
    if ($dataMov < $inicio || $dataMov > $agora) {
        continue;
    }

    // 🔥 filtro: apenas perdas
    if (!in_array($mov['tipo_movimentacao'], ['vencimento', 'desperdicio'])) {
        continue;
    }

    $categoria = $mov['Produto']['category'] ?? 'Outros';

    if (!isset($categorias[$categoria])) {
        $categorias[$categoria] = 0;
    }

    $categorias[$categoria] += $mov['quantidade'];
}

// 🔹 ordena da maior para menor
arsort($categorias);

// 🔹 limita a 4 categorias
$limite = 4;

$topCategorias = array_slice($categorias, 0, $limite, true);
$outros = array_slice($categorias, $limite);

// 🔹 agrupa restante em "Outros"
if (!empty($outros)) {
    $topCategorias['Outros'] = array_sum($outros);
}

// 🔹 dados finais
$catLabels = array_keys($topCategorias);
$catData = array_values($topCategorias);
@endphp

@php
// ==============================
// PRODUTOS COM MAIOR ROTATIVIDADE (LISTA)
// ==============================

$movimentacoes = require app_path('../database/Lista-Produtos/movimentacoes.php');

$produtos = [];

foreach ($movimentacoes as $mov) {
    $produtoId = $mov['Produto']['id'];
    $produtoNome = $mov['Produto']['name'];

    if (!isset($produtos[$produtoId])) {
        $produtos[$produtoId] = [
            'nome' => $produtoNome,
            'compras' => [],
            'tempos' => []
        ];
    }

    $data = new DateTime($mov['data_movimentacao']);

    if ($mov['tipo_movimentacao'] === 'compra') {
        $produtos[$produtoId]['compras'][] = $data;
    }

    if ($mov['tipo_movimentacao'] === 'venda') {

        if (!empty($produtos[$produtoId]['compras'])) {
            $dataCompra = array_shift($produtos[$produtoId]['compras']);

            $dias = $dataCompra->diff($data)->days;

            $produtos[$produtoId]['tempos'][] = $dias;
        }
    }
}

// 🔹 calcula média e formata
$rotatividade = [];

foreach ($produtos as $produto) {

    if (count($produto['tempos']) === 0) continue;

    $mediaDias = array_sum($produto['tempos']) / count($produto['tempos']);

    // converte para semanas
    $semanas = $mediaDias / 7;

    $rotatividade[] = [
        'nome' => $produto['nome'],
        'tempo' => round($semanas, 1) . ' semanas'
    ];
}

// 🔹 ordena (mais rápido primeiro)
usort($rotatividade, fn($a, $b) => 
    floatval($a['tempo']) <=> floatval($b['tempo'])
);

// 🔹 limita (top 4, por exemplo)
$topRotatividade = array_slice($rotatividade, 0, 4);
@endphp

@php
// ==============================
// PRODUTOS COM MENOR ROTATIVIDADE (LISTA)
// ==============================

$movimentacoes = require app_path('../database/Lista-Produtos/movimentacoes.php');

$produtos = [];

foreach ($movimentacoes as $mov) {
    $produtoId = $mov['Produto']['id'];
    $produtoNome = $mov['Produto']['name'];

    if (!isset($produtos[$produtoId])) {
        $produtos[$produtoId] = [
            'nome' => $produtoNome,
            'compras' => [],
            'tempos' => []
        ];
    }

    $data = new DateTime($mov['data_movimentacao']);

    if ($mov['tipo_movimentacao'] === 'compra') {
        $produtos[$produtoId]['compras'][] = $data;
    }

    if ($mov['tipo_movimentacao'] === 'venda') {

        if (!empty($produtos[$produtoId]['compras'])) {
            $dataCompra = array_shift($produtos[$produtoId]['compras']);

            $dias = $dataCompra->diff($data)->days;

            $produtos[$produtoId]['tempos'][] = $dias;
        }
    }
}

// 🔹 calcula média
$rotatividade = [];

foreach ($produtos as $produto) {

    if (count($produto['tempos']) === 0) continue;

    $mediaDias = array_sum($produto['tempos']) / count($produto['tempos']);
    $semanas = $mediaDias / 7;

    $rotatividade[] = [
        'nome' => $produto['nome'],
        'tempo' => round($semanas, 1) . ' semanas',
        'valor' => $semanas // usado pra ordenação
    ];
}

// 🔴 diferença principal: ordem invertida
usort($rotatividade, fn($a, $b) => 
    $b['valor'] <=> $a['valor']
);

// 🔹 pega os 4 mais lentos
$slowRotatividade = array_slice($rotatividade, 0, 4);

// 🔹 remove campo auxiliar
$slowRotatividade = array_map(function ($item) {
    return [
        'nome' => $item['nome'],
        'tempo' => $item['tempo']
    ];
}, $slowRotatividade);

@endphp


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

                    <x-stats-cards :cards="[
                        [
                            'title' => 'Produtos Monitorados',
                            'value' => '1,067',
                            'change' => '+12%',
                            'description' => 'este mês'
                        ],
                        [
                            'title' => 'Próximos do vencimento',
                            'value' => '87',
                            'change' => '',
                            'description' => 'Próximos 7 dias'
                        ],
                        [
                            'title' => 'Doações realizadas',
                            'value' => '15 Doações',
                            'change' => '+21%',
                            'description' => 'este mês'
                        ],
                        [
                            'title' => 'Prejuizo por vencimentos',
                            'value' => 'R$ 345.00',
                            'change' => '+6%',
                            'description' => 'este mês'
                        ]
                    ]" />

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

                        <x-next-losses :items="[
                            ['nome' => 'Leite integral', 'validade' => 'Vence em 5 dias'],
                            ['nome' => 'Arroz', 'validade' => 'Vence em 6 dias'],
                            ['nome' => 'Macarrão', 'validade' => 'Vence em 6 dias'],
                            ['nome' => 'Leite integral', 'validade' => 'Vence em 5 dias'],
                            ['nome' => 'Arroz', 'validade' => 'Vence em 6 dias'],
                            ['nome' => 'Macarrão', 'validade' => 'Vence em 6 dias']
                        ]"/>

                    </div>

                    
                </div>
            </div>
        </div>
    </x-sidebar-nav-manager>
</x-app-layout>