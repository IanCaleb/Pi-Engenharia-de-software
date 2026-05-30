<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Notifications extends Component
{
    public $notifications;
    public $unreadCount;

    public function __construct()
    {
        $this->loadNotifications();
    }

    private function loadNotifications()
    {
        $user = Auth::user();
        
        if (!$user) {
            $this->notifications = collect();
            $this->unreadCount = 0;
            return;
        }

        // Busca todos os lotes do usuário logado
        $batches = \App\Models\Batch::with('product')
            ->whereHas('product', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('quantity', '>', 0)
            ->orderBy('expiration_date', 'asc')
            ->get();

        $today = Carbon::today();
        $soon = Carbon::today()->addDays(7);
        $recently = Carbon::today()->subDays(7);

        // Notificações: próximas do vencimento ou acabaram de vencer
        $this->notifications = $batches
            ->filter(function ($batch) use ($today, $soon, $recently) {
                $exp = Carbon::parse($batch->expiration_date);
                // vence nos próximos 7 dias OU venceu nos últimos 7 dias
                return ($exp >= $today && $exp <= $soon)
                    || ($exp >= $recently && $exp < $today);
            });

        $this->unreadCount = $this->notifications->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.notifications');
    }
}
