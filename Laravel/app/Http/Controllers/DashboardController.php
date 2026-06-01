<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Batch;
use App\Models\Movement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function formatChange($current, $previous)
    {
        if ($previous <= 0) {
            return 'Sem dados';
        }

        $variation = round(
            (($current - $previous) / $previous) * 100,
            1
        );

        return ($variation > 0 ? '+' : '')
            . $variation
            . '% do que no mês passado';
    }

    public function index()
    {
        $userId = Auth::id();

        $lastMonth = now()->copy()->subMonth();

        // =========================
        // PRODUTOS MONITORADOS
        // =========================

        $activeProducts = Product::where('user_id', $userId)
            ->where('status', 'ativo')
            ->count();

        $currentMonthActive = Product::where('user_id', $userId)
            ->where('status', 'ativo')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $previousMonthActive = Product::where('user_id', $userId)
            ->where('status', 'ativo')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        // =========================
        // PRÓXIMOS DO VENCIMENTO
        // =========================

        $expiringProducts = Batch::whereHas(
                'product',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->whereBetween(
                'expiration_date',
                [
                    now(),
                    now()->copy()->addDays(7)
                ]
            )
            ->count();

        // =========================
        // DOAÇÕES REALIZADAS
        // =========================

        $currentMonthDonations = Movement::where(
                'movement_type',
                'Doação'
            )
            ->whereHas(
                'product',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->whereMonth('movement_date', now()->month)
            ->whereYear('movement_date', now()->year)
            ->count();

        $previousMonthDonations = Movement::where(
                'movement_type',
                'Doação'
            )
            ->whereHas(
                'product',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->whereMonth('movement_date', $lastMonth->month)
            ->whereYear('movement_date', $lastMonth->year)
            ->count();

        // =========================
        // PREJUÍZO POR VENCIMENTO
        // =========================

        $currentMonthLoss = Movement::where(
                'movement_type',
                'Expiração'
            )
            ->whereHas(
                'product',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->whereMonth('movement_date', now()->month)
            ->whereYear('movement_date', now()->year)
            ->get()
            ->sum(function ($movement) {
                return $movement->unit_price
                    * $movement->moved_quantity;
            });

        $previousMonthLoss = Movement::where(
                'movement_type',
                'Expiração'
            )
            ->whereHas(
                'product',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->whereMonth('movement_date', $lastMonth->month)
            ->whereYear('movement_date', $lastMonth->year)
            ->get()
            ->sum(function ($movement) {
                return $movement->unit_price
                    * $movement->moved_quantity;
            });

        // =========================
        // CARDS
        // =========================

        $cards = [
            [
                'title' => 'Produtos Monitorados',
                'value' => $activeProducts,
                'change' => $this->formatChange(
                    $currentMonthActive,
                    $previousMonthActive
                ),
                'description' => ''
            ],

            [
                'title' => 'Próximos do vencimento',
                'value' => $expiringProducts,
                'change' => '',
                'description' => 'próximos 7 dias'
            ],

            [
                'title' => 'Doações realizadas',
                'value' => $currentMonthDonations,
                'change' => $this->formatChange(
                    $currentMonthDonations,
                    $previousMonthDonations
                ),
                'description' => ''
            ],

            [
                'title' => 'Prejuízo por vencimentos',
                'value' => 'R$ ' . number_format(
                    $currentMonthLoss,
                    2,
                    ',',
                    '.'
                ),
                'change' => $this->formatChange(
                    $currentMonthLoss,
                    $previousMonthLoss
                ),
                'description' => ''
            ]
        ];

        // =========================
        // TENDÊNCIAS MENSAIS
        // =========================

        $mesesPT = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez',
        ];

        $mensal = [];

        // Cria os últimos 4 meses zerados
        for ($i = 3; $i >= 0; $i--) {

            $data = now()->subMonths($i);

            $chave = $data->format('Y-m');

            $mensal[$chave] = [
                'label' => $mesesPT[$data->month],
                'compras' => 0,
                'vendas' => 0,
                'desperdicios' => 0,
            ];
        }

        $inicio = now()
            ->subMonths(3)
            ->startOfMonth();

        $movements = Movement::with('product')
            ->whereHas('product', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('movement_date', '>=', $inicio)
            ->get();

        foreach ($movements as $movement) {

            $chave = \Carbon\Carbon::parse(
                $movement->movement_date
            )->format('Y-m');

            if (!isset($mensal[$chave])) {
                continue;
            }

            switch ($movement->movement_type) {

                case 'Compra':
                    $mensal[$chave]['compras']
                        += $movement->moved_quantity;
                    break;

                case 'Venda':
                    $mensal[$chave]['vendas']
                        += $movement->moved_quantity;
                    break;

                case 'Expiração':
                case 'Doação':
                    $mensal[$chave]['desperdicios']
                        += $movement->moved_quantity;
                    break;
            }
        }

        $labels = array_column($mensal, 'label');

        $compras = array_column(
            $mensal,
            'compras'
        );

        $vendas = array_column(
            $mensal,
            'vendas'
        );

        $desperdicios = array_column(
            $mensal,
            'desperdicios'
        );

        // =========================
        // TAXA DE PERDA
        // =========================

        $mensalPerda = [];

        // Cria os últimos 4 meses zerados
        for ($i = 3; $i >= 0; $i--) {

            $data = now()->subMonths($i);

            $chave = $data->format('Y-m');

            $mensalPerda[$chave] = [
                'label' => $mesesPT[$data->month],
                'entrada' => 0,
                'perda' => 0,
            ];
        }

        foreach ($movements as $movement) {

            $chave = \Carbon\Carbon::parse(
                $movement->movement_date
            )->format('Y-m');

            if (!isset($mensalPerda[$chave])) {
                continue;
            }

            switch ($movement->movement_type) {

                case 'Compra':
                    $mensalPerda[$chave]['entrada']
                        += $movement->moved_quantity;
                    break;

                case 'Expiração':
                    $mensalPerda[$chave]['perda']
                        += $movement->moved_quantity;
                    break;
            }
        }

        $lossLabels = [];
        $lossData = [];

        foreach ($mensalPerda as $mes) {

            $lossLabels[] = $mes['label'];

            $taxa = $mes['entrada'] > 0
                ? ($mes['perda'] / $mes['entrada']) * 100
                : 0;

            $lossData[] = round($taxa, 2);
        }


        // =========================
        // VENCIMENTOS POR CATEGORIA
        // =========================

        $categorias = [];

        foreach ($movements as $movement) {

            // Apenas movimentações de expiração
            if ($movement->movement_type !== 'Expiração') {
                continue;
            }

            $categoria = $movement->product->category ?? 'Outros';

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = 0;
            }

            $categorias[$categoria] += $movement->moved_quantity;
        }

        // Ordena da maior para menor
        arsort($categorias);

        // Limita às 4 maiores categorias
        $limite = 4;

        $topCategorias = array_slice(
            $categorias,
            0,
            $limite,
            true
        );

        $outros = array_slice(
            $categorias,
            $limite,
            null,
            true
        );

        // Agrupa o restante em "Outros"
        if (!empty($outros)) {
            $topCategorias['Outros'] = array_sum($outros);
        }

        $catLabels = array_keys($topCategorias);
        $catData = array_values($topCategorias);

        // =========================
        // PRODUTOS COM MAIOR ROTATIVIDADE
        // =========================

        $movements = Movement::with('product')
            ->whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('movement_date')
            ->get();

        $produtos = [];

        foreach ($movements as $movement) {

            if (!$movement->product) {
                continue;
            }

            $nomeProduto = trim($movement->product->name);

            if (!isset($produtos[$nomeProduto])) {
                $produtos[$nomeProduto] = [
                    'nome' => $nomeProduto,
                    'compras' => [],
                    'tempos' => []
                ];
            }

            $data = \Carbon\Carbon::parse($movement->movement_date);

            if ($movement->movement_type === 'Compra') {
                $produtos[$nomeProduto]['compras'][] = $data;
            }

            if ($movement->movement_type === 'Venda') {

                if (!empty($produtos[$nomeProduto]['compras'])) {

                    $dataCompra =
                        array_shift($produtos[$nomeProduto]['compras']);

                    $dias = $dataCompra->diffInDays($data);

                    $produtos[$nomeProduto]['tempos'][] = $dias;
                }
            }
        }

        $rotatividade = [];

        foreach ($produtos as $produto) {

            if (count($produto['tempos']) === 0) {
                continue;
            }

            $mediaDias =
                array_sum($produto['tempos'])
                / count($produto['tempos']);

            $semanas = $mediaDias / 7;

            $rotatividade[] = [
                'nome' => $produto['nome'],
                'tempo' => round($semanas, 1) . ' semanas',
                'valor' => $semanas,
            ];
        }

        usort(
            $rotatividade,
            fn ($a, $b) => $a['valor'] <=> $b['valor']
        );

        $topRotatividade = array_slice(
            $rotatividade,
            0,
            6
        );

        $topRotatividade = array_map(function ($item) {
            return [
                'nome' => $item['nome'],
                'tempo' => $item['tempo'],
            ];
        }, $topRotatividade);



        // =========================
        // PRODUTOS COM MENOR ROTATIVIDADE
        // =========================

        $slowRotatividade = $rotatividade;

        usort(
            $slowRotatividade,
            fn ($a, $b) => $b['valor'] <=> $a['valor']
        );

        $slowRotatividade = array_slice(
            $slowRotatividade,
            0,
            6
        );

        $slowRotatividade = array_map(function ($item) {
            return [
                'nome' => $item['nome'],
                'tempo' => $item['tempo'],
            ];
        }, $slowRotatividade);

        // =========================
        // PRÓXIMOS VENCIMENTOS
        // =========================

        $nextLosses = Batch::with('product')
            ->whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereDate('expiration_date', '>=', today())
            ->orderBy('expiration_date')
            ->take(6)
            ->get()
            ->map(function ($batch) {
                return [
                    'nome' => $batch->product->name,
                    'validade' => $batch->expirationMessage(),
                ];
            })
            ->toArray();

        return view(
            'manager.dashboard',
            compact(
                'cards',
                'labels',
                'compras',
                'vendas',
                'desperdicios',
                'lossLabels',
                'lossData',
                'catLabels',
                'catData',
                'topRotatividade',
                'slowRotatividade',
                'nextLosses',
            )
        );
    }
}