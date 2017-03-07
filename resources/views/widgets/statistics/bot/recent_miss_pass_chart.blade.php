<canvas id="chart-trend" height="205"></canvas>

@push('scripts')
<script type="text/javascript">
    var datasets = [];

    var data = {
        labels: ["{!! implode('","', $labels) !!}"],
        datasets: [
            {
                label: "Miss",
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: [{{ implode(', ', $miss) }}]
            },
            {
                label: "Pass",
                backgroundColor: "rgba(24,188,156,0.2)",
                borderColor: "rgba(24,188,156,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(24,188,156,0.4)",
                hoverBorderColor: "rgba(24,188,156,1)",
                data: [{{ implode(', ', $pass) }}]
            }
        ]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                stacked: true,
                ticks: {
                    autoSkip: true,
                    maxRotation: 0,
                    maxTicksLimit: 5
                }
            }],
            yAxes: [{
                stacked: true
            }]
        }
    };

    var myBarChart = new Chart($("#chart-trend"), {
        type: 'bar',
        data: data,
        options: options
    });
</script>
@endpush