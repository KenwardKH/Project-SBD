@extends('layout')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Monthly Post Updates</h1>
    <canvas id="monthlyPostUpdatesChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyPostUpdatesChart').getContext('2d');
        const monthlyUpdates = @json($monthlyUpdates);
        
        const periods = monthlyUpdates.map(update => update.period);
        const counts = monthlyUpdates.map(update => update.count);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: periods,
                datasets: [{
                    label: '# of Updated Posts',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
