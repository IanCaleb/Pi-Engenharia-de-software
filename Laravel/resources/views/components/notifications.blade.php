{{-- resources/views/components/notifications.blade.php --}}
<div class="relative" x-data="{ open: false }">
  <button @click="open = !open" class="relative p-2 text-white hover:bg-white/10 rounded-lg transition">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
    </svg>

    {{-- Badge --}}
    @if($unreadCount > 0)
      <span class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border-2 border-[#2d4a1e]">
        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
      </span>
    @endif
  </button>

  {{-- Dropdown --}}
  <div x-show="open" @click.outside="open = false" x-transition
       class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
      <span class="text-sm font-semibold text-gray-800">Notificações</span>
    </div>
    <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
      @forelse($notifications as $lote)
        <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer">
          
          {{-- Bolinha de status (vermelho para vencido, amarelo para próximo) --}}
          <span class="mt-1.5 w-2.5 h-2.5 rounded-full flex-shrink-0 {{ \Carbon\Carbon::parse($lote->expiration_date)->isPast() ? 'bg-red-500' : 'bg-amber-400' }}"></span>
          
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ $lote->product->name ?? 'Produto Indefinido' }}</p>
            <p class="text-xs text-gray-500">Lote: {{ $lote->batch_number }} | Qtd: {{ $lote->quantity }}</p>
          </div>
          
          {{-- Tag de status --}}
          <span class="text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0
            {{ \Carbon\Carbon::parse($lote->expiration_date)->isPast() ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
            {{ \Carbon\Carbon::parse($lote->expiration_date)->isPast() ? 'Vencido' : 'Próximo' }}
          </span>
          
        </div>
      @empty
        <p class="text-sm text-gray-400 text-center py-6">Nenhuma notificação</p>
      @endforelse
    </div>
  </div>
</div>

