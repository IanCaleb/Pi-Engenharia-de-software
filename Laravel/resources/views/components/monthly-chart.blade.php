<div class="rounded-2xl p-4 shadow-md md:shadow-lg">
    
    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            {{ $title ?? 'Tendências Mensais' }}
        </h2>
        <span class="text-sm text-gray-500">
            {{ $subtitle ?? 'Últimos meses' }}
        </span>
    </div>

    <!-- Chart -->
    <div class="relative h-58 sm:h-72 lg:h-80">
        <canvas id="{{ $chartId }}"></canvas>
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('{{ $chartId }}').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Compras',
                    data: @json($compras),
                    backgroundColor: '#6B8E23',
                    borderRadius: 6
                },
                {
                    label: 'Vendas',
                    data: @json($vendas),
                    backgroundColor: '#0F2A3D',
                    borderRadius: 6
                },
                {
                    label: 'Desperdícios',
                    data: @json($desperdicios),
                    backgroundColor: '#8B1A1A',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb'
                    }
                }
            }
        }
    });
});
</script>