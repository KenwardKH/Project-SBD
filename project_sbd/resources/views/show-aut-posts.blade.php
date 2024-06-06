@extends('layout')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Post Counts per Author</h1>
    <canvas id="autPostCountsChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('autPostCountsChart').getContext('2d');
        const autUpdates = @json($autUpdates);
        
        const auts = autUpdates.map(update => update.aut);
        const counts = autUpdates.map(update => update.count);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: auts,
                datasets: [{
                    label: '# of Posts',
                    data: counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        type: 'category',
                        grid: {
                            display: false
                        },
                        ticks: {
                            autoSkip: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
