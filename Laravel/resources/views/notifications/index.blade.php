{{-- resources/views/notifications/index.blade.php --}}
<x-app-layout>
    <x-sidebar-nav-manager active="notifications">

        <div class="py-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- ── CABEÇALHO ── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                🔔 Notificações
                                @if($unreadCount > 0)
                                    <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                @endif
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $totalCount }} notificações no total
                                @if($unreadCount > 0)
                                    · <span class="text-red-600 font-medium">{{ $unreadCount }} não lida(s)</span>
                                @endif
                            </p>
                        </div>

                        {{-- Legenda --}}
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span> Vencido
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span> Próximo do vencimento
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-300 inline-block"></span> Antiga / Lida
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ── NOVAS NOTIFICAÇÕES ── --}}
                <section class="mb-8" id="novas-notificacoes">
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-3 px-1">
                        🆕 Novas — {{ $newNotifications->count() }} item(s)
                    </h2>

                    @if($newNotifications->isEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                            <p class="text-4xl mb-3">✅</p>
                            <p class="text-gray-600 font-medium">Nenhuma notificação nova</p>
                            <p class="text-sm text-gray-400 mt-1">Todos os produtos estão dentro do prazo.</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-3">
                            @foreach($newNotifications as $notif)
                                <div id="notif-{{ $notif['id'] }}"
                                     class="group bg-white rounded-2xl shadow-sm border border-gray-100
                                            hover:shadow-md hover:-translate-y-0.5
                                            transition-all duration-200 ease-out
                                            {{ $notif['type'] === 'expired' ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-amber-400' }}">
                                    <div class="flex items-start gap-4 px-5 py-4">

                                        {{-- Ícone de status --}}
                                        <div class="mt-0.5 flex-shrink-0">
                                            @if($notif['type'] === 'expired')
                                                <span class="flex items-center justify-center w-9 h-9 rounded-full bg-red-50 text-red-500 text-lg">🔴</span>
                                            @else
                                                <span class="flex items-center justify-center w-9 h-9 rounded-full bg-amber-50 text-amber-500 text-lg">🟡</span>
                                            @endif
                                        </div>

                                        {{-- Conteúdo --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-0.5">
                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $notif['product_name'] }}
                                                </p>
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                                                    {{ $notif['type'] === 'expired'
                                                        ? 'bg-red-50 text-red-700'
                                                        : 'bg-amber-50 text-amber-700' }}">
                                                    {{ $notif['type'] === 'expired' ? 'Vencido' : 'Próximo' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $notif['message'] }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                Lote: <span class="font-mono">{{ $notif['batch_number'] }}</span>
                                                · Qty: {{ $notif['quantity'] }}
                                                · Validade: {{ $notif['date'] }}
                                            </p>
                                        </div>

                                        {{-- Data / tempo --}}
                                        <div class="text-right text-xs text-gray-400 flex-shrink-0 mt-0.5">
                                            <span class="block font-medium {{ $notif['type'] === 'expired' ? 'text-red-500' : 'text-amber-500' }}">
                                                {{ $notif['date'] }}
                                            </span>
                                            <span class="block text-[11px] text-gray-400 mt-0.5">Não lida</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- ── NOTIFICAÇÕES ANTIGAS ── --}}
                <section id="notificacoes-antigas">
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-3 px-1">
                        📂 Antigas — {{ $oldNotifications->count() }} item(s)
                    </h2>

                    @if($oldNotifications->isEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                            <p class="text-gray-400 text-sm">Nenhuma notificação antiga registrada.</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-3">
                            @foreach($oldNotifications as $notif)
                                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 opacity-70
                                            hover:opacity-100 hover:shadow-md hover:-translate-y-0.5
                                            transition-all duration-200 ease-out
                                            border-l-4 border-l-gray-300">
                                    <div class="flex items-start gap-4 px-5 py-4">

                                        {{-- Ícone lida --}}
                                        <div class="mt-0.5 flex-shrink-0">
                                            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-400 text-lg">⚪</span>
                                        </div>

                                        {{-- Conteúdo --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-0.5">
                                                <p class="text-sm font-medium text-gray-600 truncate">
                                                    {{ $notif['product_name'] }}
                                                </p>
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">
                                                    Vencido
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-400">{{ $notif['message'] }}</p>
                                            <p class="text-xs text-gray-300 mt-0.5">
                                                Lote: <span class="font-mono">{{ $notif['batch_number'] }}</span>
                                                · Qty: {{ $notif['quantity'] }}
                                                · Validade: {{ $notif['date'] }}
                                            </p>
                                        </div>

                                        {{-- Data --}}
                                        <div class="text-right text-xs text-gray-400 flex-shrink-0 mt-0.5">
                                            <span class="block font-medium text-gray-400">{{ $notif['date'] }}</span>
                                            <span class="block text-[11px] text-gray-300 mt-0.5">Lida</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- ── VOLTAR AO DASHBOARD ── --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('manager.dashboard') }}"
                       class="inline-flex items-center gap-2 text-sm text-[#749048] font-medium hover:underline transition">
                        ← Voltar ao Dashboard
                    </a>
                </div>

            </div>
        </div>

    </x-sidebar-nav-manager>
</x-app-layout>
