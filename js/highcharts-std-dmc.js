/*
 * highcharts-std-profile
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 2/2/2017.
 */


$(function () {
/* std dmc*/
var dmcgraphOptions = {
    chart: {
        type: 'column',
    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },
    xAxis: {
        categories: [],
        title: {
            text: null
        }
    },
    yAxis: {
        title: {
            text: 'Percentage(%)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' %'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    credits: {
        enabled: false
    },
    series: []
};
var chart = new  Highcharts.chart('dmc-graph-container', dmcgraphOptions);
});
/*
$('#small').click(function () {
    chart.setSize(400, 150);
});

$('#large').click(function () {
    chart.setSize(600, 150);
});
 */
