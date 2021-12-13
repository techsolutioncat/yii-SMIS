/**
 * highcharts-details
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 12/9/2016.
 */


$(function () {
    var series = details;
    /*series: [
     {
     type: 'column',
     name: 'Jane',
     data: [3, 2, 1, 3, 4]
     },
     {
     type: 'column',
     name: 'John',
     data: [2, 3, 5, 7, 6]
     },
     {
     type: 'column',
     name: 'Joe',
     data: [4, 3, 3, 9, 0]
     },
     {
     type: 'pie',
     name: 'Total consumption',
     data: [{
     name: 'Jane',
     y: 13,
     color: Highcharts.getOptions().colors[0] // Jane's color
     }, {
     name: 'John',
     y: 23,
     color: Highcharts.getOptions().colors[1] // John's color
     }, {
     name: 'Joe',
     y: 19,
     color: Highcharts.getOptions().colors[2] // Joe's color
     }],
     center: [100, 80],
     size: 100,
     showInLegend: false,
     dataLabels: {
     enabled: false
     }
     }]*/
    console.log(pi);
    /*generate bar chart.*/
    //console.log(series);
    Highcharts.chart('container', {
        title: {
            text: 'Exam Analysis'
        },
        xAxis: {
            categories: ['subjects']
        },
        labels: {
            items: [{
                //html: 'Exam Analysis',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: details

    });
    // Create the chart
    Highcharts.chart('container-pie', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Students Grade'
        },
        subtitle: {
            text: 'Analysis'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f} Student(s)'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Student(s)<br/>'
        },
        series: [{
            name: 'Grade',
            colorByPoint: true,
            data: pi
        }],

    });
});



/**/