<canvas id="chart-trend" height="180"></canvas>

@push('scripts')
<script type="text/javascript">
    var datasets = [];

    var recipientsChanges = [{{ implode(', ', $recipients) }}];

    var data = {
        labels: ["{!! implode('","', $labels) !!}"],
        datasets: [
            {
                label: "Total recipients",
                backgroundColor: "rgba(24,188,156,0.2)",
                borderColor: "rgba(24,188,156,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(24,188,156,0.4)",
                hoverBorderColor: "rgba(24,188,156,1)",
                data: [{{ implode(', ', $totals) }}]
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
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel + " ("
                            + (recipientsChanges[tooltipItem.index] > 0 ? "+" : "") +
                            + recipientsChanges[tooltipItem.index] +
                            ")";
                },
            }
        }
    };

    var myBarChart = new Chart($("#chart-trend"), {
        type: 'bar',
        data: data,
        options: options
    });
</script>
@endpush