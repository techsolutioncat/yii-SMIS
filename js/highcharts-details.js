/**
 * highcharts-details
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 12/9/2016.
 */

$(document).ready(function () {
    Highcharts.chart('container', {
        title : {
            text : ''
        },
        xAxis: {
           // categories: ['Academics','Manners','Confidence'],
            title:{
                text: null
            },
            labels: {
                rotation: -0,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        },
        yAxis: {
            title:{
                text: 'Marks %'
            },

        },
        legend: {
            enabled: false
        },
 
        series: [{
            name: '',
            showInLegend: false,
            data: [{y: acadamicTotal, color: '#CFE360'},{y: manners, color: '#1661AB'},{y:confidence, color: '#D94F1D'}],
            type: 'column',
        }]

    });


/* Dynamic charts for subjects.*/
    for(i=0; i<=totalCharts; i++){

        if(data.series[i] !=undefined){
            var series= data.series[i];

            Highcharts.chart('container-'+i, {
                chart: {
                    height: 100,
                    type: 'bar'
                },
                title: {
                    text: null
                },
                subtitle: {
                    text: null /*'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'*/
                },
                xAxis: {
                   // categories: series.subjectShort,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    //min: 0,
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    title: {
                        text: null/*'Population (millions)'*/,
                        align: 'high'
                    },
                    labels: {
                        enabled: false
                    }
                },
                /*tooltip: {
                 valueSuffix: ' millions'
                 },*/
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: false
                        }
                    },

                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                   /* x: -40,
                    y: 80,*/
                    floating: true,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: false
                },
                credits: {
                    enabled: false
                },
                height: 10,
                width:100,
                series: [{
                    showInLegend: false,
                    name:series.subjectShort,
                    data:series.marks,
                }
                ]
            });
        }else{
            //alert(i);
        }

    }
});


