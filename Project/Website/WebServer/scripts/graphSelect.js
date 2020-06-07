var chartObject;

const DEFAULT_CHART_TYPE = 'bar';
var dataPoints = [1, 2, 3, 4, 5, 6, 1, 2, 3, 0];                                        /* Get Data from API */
var dataLabels = ['l1', 'l2', 'l3', 'l4', 'l5', 'l6', 'l7', 'l8', 'l9', 'l10'];         /* Get Data from API */

window.onload = function() {
    renderChart(DEFAULT_CHART_TYPE);
}

function notifyDataSetChanged(dataSet){
    console.log(dataSet);
}

function renderChart(chartType) {
    const canvasContext = document.getElementById('chart').getContext('2d');

    chartOptions = {
        type: chartType,
        data: {
            labels: dataLabels,
            datasets: [{
                label: '# of Votes',
                data: dataPoints,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    };

    if (chartObject !== undefined)
        chartObject.destroy();

    chartObject = new Chart(canvasContext, chartOptions);

    const graphDOMElement = document.getElementById('graph');
    chartObject.canvas.parentNode.style.height = graphDOMElement.style.height;
    chartObject.canvas.parentNode.style.width = graphDOMElement.style.width;
}