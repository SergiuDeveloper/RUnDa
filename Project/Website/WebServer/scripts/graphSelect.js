var chartObject;

const DEFAULT_CHART_TYPE = 'bar';
var currentChartType = DEFAULT_CHART_TYPE;

const monthsArray = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

var dataPoints;
var dataLabels;

function notifyDatasetChanged(dataset) {
    dataPoints = [];
    dataLabels = [];

    let isFirstDataPoint = true;
    let previousDataPointValue;

    dataset.Data.DataPoints.forEach((dataPoint) => {
        if (!isFirstDataPoint)
            for (let dataPointIterator = previousDataPointValue; dataPointIterator < dataPoint; ++dataPointIterator)
                dataPoints.push(0);
        else
            isFirstDataPoint = false;

        dataPoints.push(dataPoint.Y);
        dataLabels.push(`${monthsArray[dataPoint.X % 12]} ${Math.floor(dataPoint.X / 12)}`);

        previousDataPointValue = dataPoint;
    });

    renderChart(currentChartType);
}

function renderChart(chartType) {
    const canvasContext = document.getElementById('chart').getContext('2d');

    const [chartSegmentsBackgroundColors, chartSegmentsBorderColors] = (['line', 'radar'].includes(chartType) ? ['rgba(0, 0, 255, 0.6)', 'rgba(0, 255, 0, 1.0)'] : getChartSegmentsColors());

    const chartOptions = {
        type: chartType,
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Unemployee Count',
                data: dataPoints,
                backgroundColor: chartSegmentsBackgroundColors,
                borderColor: chartSegmentsBorderColors,
                pointRadius: 10,
                pointHoverRadius: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    min: Math.min.apply(null, dataPoints)
                }]
            }
        }
    };

    if (chartObject !== undefined)
        chartObject.destroy();

    chartObject = new Chart(canvasContext, chartOptions);

    currentChartType = chartType;
}

function getChartSegmentsColors() {
    const maxDataPointValue = Math.max.apply(null, dataPoints);
    const minDataPointValue = Math.min.apply(null, dataPoints.filter((dataPoint) => dataPoint > 0));

    const dataPointsRange = maxDataPointValue - minDataPointValue;

    let chartSegmentsBackgroundColors = [];
    let chartSegmentsBorderColors = [];

    dataPoints.forEach((dataPoint) => {
        chartSegmentsBackgroundColors.push(`rgba(${255 * ((dataPoint - minDataPointValue) / dataPointsRange)}, 0, ${255 * ((maxDataPointValue - dataPoint) / dataPointsRange)}, 0.75`);
        chartSegmentsBorderColors.push(`rgba(${255 * ((dataPoint - minDataPointValue) / dataPointsRange)}, 0, ${255 * ((maxDataPointValue - dataPoint) / dataPointsRange)}, 1`);
    });

    return [chartSegmentsBackgroundColors, chartSegmentsBorderColors];
}

function getPredictedDataPoints() {

}