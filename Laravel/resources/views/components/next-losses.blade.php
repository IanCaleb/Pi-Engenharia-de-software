@props(['items' => []])

<div class="p-4 rounded-xl shadow-md md:shadow-lg">
    <h3 class="mb-3 text-base font-semibold">Proximas perdas</h3>

    @foreach ($items as $index => $item)
        <div class="flex justify-between items-center border border-[#dbdbdb] p-2.5 rounded-lg mb-2">
            <div class="flex gap-2.5">
                <strong>{{ $index + 1 }}</strong>
                <span >
                    {{ $item['nome'] }}
                </span>
            </div>

            <span class="text-gray-600">
                {{ $item['validade'] }}
            </span>
        </div>
    @endforeach
</div>

