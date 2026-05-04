<div class="rounded-2xl p-4 flex flex-col h-full shadow-md md:shadow-lg">
    
    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            {{ $title ?? 'Distribuição por Categoria' }}
        </h2>
    </div>

    <!-- Chart -->
    <div class="relative flex-1 min-h-[260px]">
        <canvas id="{{ $chartId }}"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('{{ $chartId }}').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($data),
                backgroundColor: [
                    '#7C3AED', // roxo
                    '#A855F7',
                    '#FBBF24', // amarelo
                    '#34D399', // verde
                    '#F97316'  // laranja
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '65%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 16
                    }
                }
            }
        }
    });
});
</script>

