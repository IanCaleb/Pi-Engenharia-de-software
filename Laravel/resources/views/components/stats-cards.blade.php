<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ($cards as $index => $card)

        @php
            $isPositive = str_contains($card['change'], '+');
            $isFirst = $index === 0;

            $textColor = $isFirst
                ? 'text-white'
                : ($isPositive ? 'text-green-500' : 'text-red-500');

            $baseText = $isFirst
                ? 'text-white'
                : 'text-gray-800';

            $subText = $isFirst
                ? 'text-white/80'
                : ($isPositive ? 'text-gray-500' : 'text-red-500');
        @endphp

        <div class="
            rounded-2xl p-4 shadow-md md:shadow-lg flex flex-col justify-between
            transition-all duration-300 ease-out
            hover:-translate-y-1 hover:shadow-lg hover:shadow-[#46572b]/20
            {{ $isFirst ? 'bg-[#0c3957]' : 'bg-white' }}
        ">
            
            <!-- Topo -->
            <div class="flex items-start justify-between">
                <span class="text-sm {{ $baseText }}">
                    {{ $card['title'] }}
                </span>

                <!-- Ícone -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-4 h-4 {{ $textColor }}" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke="currentColor">
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M7 17L17 7M17 7H7M17 7V17" />
                </svg>
            </div>

            <!-- Valor -->
            <div class="mt-2 text-2xl font-semibold {{ $baseText }}">
                {{ $card['value'] }}
            </div>

            <!-- Rodapé -->
            <div class="mt-2 text-sm {{ $subText }}">
                <span class="{{ $textColor }} font-medium">
                    {{ $card['change'] }}
                </span>
                <span class="{{ $textColor }}">
                    {{ $card['description'] }}
                </span>
            </div>

        </div>
    @endforeach
</div>