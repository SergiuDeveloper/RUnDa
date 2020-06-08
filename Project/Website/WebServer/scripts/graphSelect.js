var chartObject;

const DEFAULT_CHART_TYPE = 'bar';
var currentChartType = DEFAULT_CHART_TYPE;

const MONTHS_ARRAY = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

const PREDICTED_MONTHS_COUNT = 12;

var dataPointsMaxXValue;
var dataPoints;
var dataLabels;
var predictionCoefficients;
var predictionSubtrahend;

function notifyDatasetChanged(dataset, regressionType) {
    dataPoints = [];
    dataLabels = [];

    let isFirstDataPoint = true;
    let previousDataPointValue;

    dataPointsMaxXValue = dataset.DataPoints[dataset.DataPoints.length - 1].X;
    dataset.DataPoints.forEach((dataPoint) => {
        if (!isFirstDataPoint)
            for (let dataPointIterator = previousDataPointValue; dataPointIterator < dataPoint; ++dataPointIterator)
                dataPoints.push(NaN);
        else
            isFirstDataPoint = false;

        dataPoints.push(dataPoint.Y);
        dataLabels.push(`${MONTHS_ARRAY[(dataPoint.X - 1) % 12]} ${Math.floor((dataPoint.X - 1) / 12)}`);

        previousDataPointValue = dataPoint;
    });

    for (let predictedMonthsIterator = dataPointsMaxXValue + 1; predictedMonthsIterator <= dataPointsMaxXValue + PREDICTED_MONTHS_COUNT; ++predictedMonthsIterator)
        dataLabels.push(`${MONTHS_ARRAY[(predictedMonthsIterator - 1) % 12]} ${Math.floor((predictedMonthsIterator - 1) / 12)}`);

    predictionCoefficients = dataset.Coefficients;
    predictionSubtrahend = dataset.DataSubtrahend;

    renderChart(currentChartType, regressionType);
}

function renderChart(chartType, regressionType) {
    const canvasContext = document.getElementById('chart').getContext('2d');

    const [chartSegmentsBackgroundColors, chartSegmentsBorderColors] = (['line', 'radar'].includes(chartType) ? ['rgba(0, 0, 255, 0.6)', 'rgba(0, 255, 0, 1.0)'] : getChartSegmentsColors(chartType));

    let predictedDataPoints = (new Array(dataPoints.length)).fill(NaN).concat(getPredictedDataPoints(regressionType));

    const chartOptions = {
        type: chartType,
        data: {
            labels: dataLabels,
            datasets: [
                {
                    label: 'Unemployee Count',
                    data: dataPoints,
                    backgroundColor: chartSegmentsBackgroundColors,
                    borderColor: chartSegmentsBorderColors,
                    pointRadius: 10,
                    pointHoverRadius: 20,
                    borderWidth: 2
                },
                {
                    label: 'Unemployee Count(Prediction)',
                    data: predictedDataPoints,
                    backgroundColor: 'rgba(0, 255, 0, 0.15)',
                    borderColor: 'rgba(50, 50, 50, 1)',
                    pointRadius: 10,
                    pointHoverRadius: 20,
                    borderWidth: 2
                }
            ]
        },
        options: {
            spanGaps: true,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    min: Math.min.apply(null, dataPoints.concat(predictedDataPoints.slice(dataPoints.length)))
                }]
            }
        }
    };

    if (chartObject !== undefined)
        chartObject.destroy();

    chartObject = new Chart(canvasContext, chartOptions);

    canvasContext.canvas.style.width = '90vw';
    canvasContext.canvas.style.height = '66.5vh';
    canvasContext.canvas.style.margin = 'auto';

    currentChartType = chartType;
}

function getPredictedDataPoints(regressionType) {
    let predictedDataPoints = [];

    let predictedValue;
    for (let predictedMonthsIterator = dataPointsMaxXValue + 1; predictedMonthsIterator <= dataPointsMaxXValue + PREDICTED_MONTHS_COUNT; ++predictedMonthsIterator) {
        predictedValue = predictionCoefficients.b + predictionSubtrahend.Y;

        switch (regressionType) {
            case 'Linear': {
                predictedValue += predictionCoefficients.w * (predictedMonthsIterator - predictionSubtrahend.X);
                break;
            }
            case 'Polynomial': {
                for (let weightIterator = 0; weightIterator < predictionCoefficients.w.length; ++weightIterator)
                    predictedValue += predictionCoefficients.w[weightIterator] * Math.pow(predictedMonthsIterator - predictionSubtrahend.X, weightIterator + 1);
                break;
            }
            case 'Logistic Polynomial': {
                predictedValue += predictionCoefficients.w * Math.pow(predictedMonthsIterator - predictionSubtrahend.X, predictionCoefficients.p);
                break;
            }
        }

        predictedDataPoints.push(Math.max(0, Math.round(predictedValue)));
    }

    return predictedDataPoints;
}

function getChartSegmentsColors(chartType) {
    const maxDataPointValue = Math.max.apply(null, dataPoints);
    const minDataPointValue = Math.min.apply(null, dataPoints.filter((dataPoint) => dataPoint !== NaN));

    const dataPointsRange = maxDataPointValue - minDataPointValue;

    let chartSegmentsBackgroundColors = [];
    let chartSegmentsBorderColors = [];

    dataPoints.forEach((dataPoint) => {
        chartSegmentsBackgroundColors.push(`rgba(${255 * ((dataPoint - minDataPointValue) / dataPointsRange)}, 0, ${255 * ((maxDataPointValue - dataPoint) / dataPointsRange)}, ${chartType === 'polarArea' ? 0.4 : 0.75}`);
        chartSegmentsBorderColors.push(`rgba(${255 * ((dataPoint - minDataPointValue) / dataPointsRange)}, 0, ${255 * ((maxDataPointValue - dataPoint) / dataPointsRange)}, 1`);
    });

    return [chartSegmentsBackgroundColors, chartSegmentsBorderColors];
}