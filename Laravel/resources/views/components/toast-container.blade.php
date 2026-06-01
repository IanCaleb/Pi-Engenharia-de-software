{{-- resources/views/components/toast-container.blade.php --}}
<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3">
  @foreach($toasts as $toast)
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-10"
         class="relative flex items-start gap-3 w-80 bg-white rounded-xl shadow-lg px-4 py-3 overflow-hidden
           {{ $toast['type'] === 'expired' ? 'border-l-4 border-red-500' : 'border-l-4 border-amber-400' }}">
      <span class="text-lg mt-0.5">
        {{ $toast['type'] === 'expired' ? '🔴' : '🟡' }}
      </span>
      <div class="flex-1">
        <p class="text-sm font-semibold text-gray-800">
          {{ $toast['type'] === 'expired' ? 'Produto vencido!' : 'Próximo do vencimento' }}
        </p>
        <p class="text-xs text-gray-500">{{ $toast['message'] }}</p>
      </div>
      <button @click="show = false" class="text-gray-300 hover:text-gray-500 text-base">✕</button>
      {{-- Barra de progresso --}}
      <div class="absolute bottom-0 left-0 h-[3px] {{ $toast['type'] === 'expired' ? 'bg-red-500' : 'bg-amber-400' }}"
           x-ref="bar"
           x-init="$el.style.transition = 'width 5s linear'; $nextTick(() => $el.style.width = '0%')"
           style="width: 100%">
      </div>
    </div>
  @endforeach
</div>
