<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return view(
            'manager.dashboard',
            compact('cards')
        );
    }
}