@extends('layout')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Post Counts per Category</h1>
    <div style="overflow-x: auto; white-space: nowrap;">
        <canvas id="tagPostCountsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('tagPostCountsChart').getContext('2d');
        const catUpdates = @json($catUpdates);
        
        const cats = catUpdates.map(update => update.cat);
        const counts = catUpdates.map(update => update.count);

        // Calculate canvas width based on number of categories
        const canvasWidth = cats.length * 24; // Adjust 50 as needed

        // Set canvas width and a fixed height
        const canvas = document.getElementById('tagPostCountsChart');
        canvas.width = canvasWidth;
        canvas.height = 700; // Set a fixed height

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cats,
                datasets: [{
                    label: '# of Posts',
                    data: counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
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
