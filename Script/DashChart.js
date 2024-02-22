(() => {
        'use strict'

        // Graphs
        const ctx = document.getElementById('myChart');

        //const phpAmount = <?php echo json_encode($chartData); ?>;
        // get chart data from local storage
        const chartData = JSON.parse(localStorage.getItem('chartData'));

        console.log(chartData);

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Sunday',
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday'
                ],
                datasets: [{
                    data: [
                        chartData[6],
                        chartData[0],
                        chartData[1],
                        chartData[2],
                        chartData[3],
                        chartData[4],
                        chartData[5]
                    ],
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#ffcd00',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffcd00'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        boxPadding: 3
                    }
                }
            }
        })
    })()