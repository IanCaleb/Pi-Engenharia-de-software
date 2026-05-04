<div class="rounded-2xl p-4 shadow-md md:shadow-lg">
    
    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            {{ $title ?? 'Taxa de Perda' }}
        </h2>
        <span class="text-sm text-gray-500">
            {{ $subtitle ?? 'Evolução mensal' }}
        </span>
    </div>

    <!-- Chart -->
    <div class="relative h-58 sm:h-72 lg:h-80">
        <canvas id="{{ $chartId }}"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('{{ $chartId }}').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Taxa de perda',
                    data: @json($data),
                    borderColor: '#6B8E23',
                    backgroundColor: 'rgba(107,142,35,0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#6B8E23'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
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