

var charts = document.getElementsByClassName("charts");
testChart();
testChart2();
charts[1].style.display = "none";
function graphChanged(n){

    console.log(n);
    for(i = 0; i < charts.length; i++){
        charts[i].style.display = "none";
    }
    charts[n].style.display = "block";
}

function changeGraph(){
    var selected = document.getElementById("graphSelectObj");
    graphChanged(selected.options[selected.selectedIndex].value);
}

function testChart2(){
    var canvasTexture = document.getElementById("chart1").getContext('2d');
    var chart = new Chart(
        canvasTexture, {
            type: 'pie',
            data: {
                labels : [
                    'Red',
                    'Blue',
                    'Yellow',
                    'Green',
                    'Purple',
                    'Orange'
                ],
                datasets : [ {
                        label: '# of Votes',
                        data: [
                            12,
                            19,
                            3,
                            5,
                            2,
                            3
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rbga(255, 159, 64, 0.2)'
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
                scales: {
                    yAxes: [{
                        ticks:{
                            beginAtZero: true
                        }
                    }]
                },
                maintainAspectRatio : false
            }
        }
    );

    var container = document.getElementsByClassName("graph");

    chart.canvas.parentNode.style.height = '500px';
    chart.canvas.parentNode.style.width = container.width;
}

function testChart(){
    var canvasTexture = document.getElementById("chart0").getContext('2d');
    var chart = new Chart(
        canvasTexture, {
            type: 'bar',
            data: {
                labels : [
                    'Red',
                    'Blue',
                    'Yellow',
                    'Green',
                    'Purple',
                    'Orange'
                ],
                datasets : [ {
                        label: '# of Votes',
                        data: [
                            12,
                            19,
                            3,
                            5,
                            2,
                            3
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rbga(255, 159, 64, 0.2)'
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
                scales: {
                    yAxes: [{
                        ticks:{
                            beginAtZero: true
                        }
                    }]
                },
                maintainAspectRatio : false
            }
        }
    );

    var container = document.getElementsByClassName("graph");

    chart.canvas.parentNode.style.height = '500px';
    chart.canvas.parentNode.style.width = container.width;
}

testChart();