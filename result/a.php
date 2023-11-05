<!DOCTYPE html>
<html>
<head>
    <title>Line Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Line Chart Example</h1>
    <canvas id="lineChart" width="400" height="200"></canvas>

    <script>
        var data = {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'Sample Line Chart',
                data: [10, 20, 30, 40, 50],
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 0, 0)', // Transparent background
                fill: false // No fill color
            }]
        };

        var ctx = document.getElementById('lineChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    x: {
                        display: true,
                        grid: {
                            drawOnChartArea: false, // Disable gridlines on the chart area
                        }
                    },
                    y: {
                        display: true,
                        grid: {
                            drawOnChartArea: false, // Disable gridlines on the chart area
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
