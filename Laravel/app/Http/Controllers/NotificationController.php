<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Exibe a tela completa de notificações (novas e antigas)
     */
    public function index()
    {
        // Busca todos os lotes do gerente logado
        $batches = \App\Models\Batch::with('product')
            ->whereHas('product', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->where('quantity', '>', 0)
            ->orderBy('expiration_date', 'asc')
            ->get();

        $today    = Carbon::today();
        $soon     = Carbon::today()->addDays(7);
        $recently = Carbon::today()->subDays(7);  // "antigas": venceram nos últimos 7 dias

        // ── Novas (não lidas): próximos do vencimento ou acabaram de vencer ──
        $newNotifications = $batches
            ->filter(function ($batch) use ($today, $soon, $recently) {
                $exp = Carbon::parse($batch->expiration_date);
                // vence nos próximos 7 dias OU venceu nos últimos 7 dias
                return ($exp >= $today && $exp <= $soon)
                    || ($exp >= $recently && $exp < $today);
            })
            ->map(function ($batch) use ($today) {
                $exp  = Carbon::parse($batch->expiration_date);
                $diff = $today->diffInDays($exp, false); // negativo = já venceu

                return [
                    'id'           => $batch->id,
                    'product_name' => $batch->product->name,
                    'batch_number' => $batch->batch_number,
                    'type'         => $diff < 0 ? 'expired' : 'warning',
                    'message'      => $diff < 0
                        ? 'Venceu há ' . abs($diff) . ' dia(s)'
                        : ($diff === 0 ? 'Vence hoje!' : 'Vence em ' . $diff . ' dia(s)'),
                    'date'         => $exp->format('d/m/Y'),
                    'quantity'     => $batch->quantity,
                    'read_at'      => null, // novas = não lidas
                ];
            })
            ->values();

        // ── Antigas (lidas): venceram há mais de 7 dias ──
        $oldNotifications = $batches
            ->filter(function ($batch) use ($recently) {
                $exp = Carbon::parse($batch->expiration_date);
                return $exp < $recently; // venceu há mais de 7 dias
            })
            ->map(function ($batch) use ($today) {
                $exp  = Carbon::parse($batch->expiration_date);
                $diff = $today->diffInDays($exp);

                return [
                    'id'           => $batch->id,
                    'product_name' => $batch->product->name,
                    'batch_number' => $batch->batch_number,
                    'type'         => 'expired',
                    'message'      => 'Venceu há ' . $diff . ' dia(s)',
                    'date'         => $exp->format('d/m/Y'),
                    'quantity'     => $batch->quantity,
                    'read_at'      => now(), // antigas = já lidas
                ];
            })
            ->values();

        // Contadores para o header
        $unreadCount = $newNotifications->count();
        $totalCount  = $newNotifications->count() + $oldNotifications->count();

        return view('notifications.index', compact(
            'newNotifications',
            'oldNotifications',
            'unreadCount',
            'totalCount'
        ));
    }
}
