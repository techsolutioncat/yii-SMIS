/*
 * highcharts-std-profile
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 2/2/2017.
 */



/*student attendance total bar graph*/
$(function () {
    if(Object.keys(attendance_details).length > 0){
        var attendanceOptions = {
            chart: {
                type: 'bar',
                height:150,
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                categories: attendance_details.leave_type,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total (Days)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Day(s)'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: false,
            credits: {
                enabled: false
            },
            series: [{
                name: currentDate,
                data: attendance_details.total
            }]
        };
        var chart = new  Highcharts.chart('container_attendance', attendanceOptions);
    }

    var FeeArray = new Array();
    // var totalAmount = 0.00;
    $('#table-new-std-challan table tbody tr.tr-fee-plan').each(function() {
        var tmp = new Array();
        var heads = $(this).find('td:nth-child(2)').text();
        var amount = $(this).find('td:nth-child(3) span.fee-amount').text();
        tmp = {'name' : heads, 'data':  parseFloat(amount)};
        // totalAmount += parseFloat(amount);
        FeeArray.push(tmp);
    });

    // var d = FeePiData;
    var d = FeeArray;
    var name = Array();
    var data = Array();
    var dataArrayFinal = Array();
    for(i=0;i<d.length;i++) {
        name[i] = d[i].name;
        data[i] = d[i].data;
    }

    for(j=0;j<name.length;j++) {
        var temp = new Array(name[j],data[j]);
        dataArrayFinal[j] = temp;
    }

    Highcharts.chart('container_fee_chart', {
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',
        '#FF9655', '#FFF263', '#6AF9C4'],
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            height:150,
        },
        title: {
            text: null
        },
        tooltip: {
            pointFormat: '{series.name}: <b>Rs.{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: Rs.{point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: ['Fee Summary'],
            data: dataArrayFinal
        }]

    });

    var chart = {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        height:120,
        width:120,
    };
    var title =false;
    var tooltip = {
        pointFormat: '{series.name}: <b>{point.y:.1f}</b>'
    };
    var plotOptions = {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    };
    var series= [{
        type: 'pie',
        name: 'Exam Marks',
        data: [
            ['Firefox',   45.0],
            ['IE',       26.8],
            {
                name: 'Chrome',
                y: 12.8,
                sliced: true,
                selected: true
            },
            ['Safari',    8.5],
            ['Opera',     6.2],
            ['Others',   0.7]
        ]
    }];

    var json = {};
    json.chart = chart;
    json.title = title;
    json.tooltip = tooltip;
    json.series = series;
    json.plotOptions = plotOptions;
    $('#exam-result-container').highcharts(json);

});

// $(document).on('click','#get-timeline',function () {
//     var startDate    = $(this).data('sdate');
//     var endDate      = $(this).data('edate');
//     var stdId        = $(this).data('std');
//     var classId      = $(this).data('class_id');
//     var groupId      = $(this).data('group_id');
//     var sectionId    = $(this).data('section_id');
//     var url          = $(this).data('url');

//     $('a#get-timeline').removeClass('active');
//     $(this).addClass('active');
//     //console.log(startDate+"  "+endDate+"  "+stdId+"  "+classId+"  "+groupId+"  "+sectionId+"  "+url);
//     $.ajax
//     ({
//         type: "POST",
//         dataType :"JSON",
//         data:{start_date:endDate,end_date:startDate,student_id:stdId,class_id:classId,group_id:groupId,section_id:sectionId},
//         url: url,
//         cache: false,
//         success: function(html)
//         {
//             //  alert('success');
//             if(Object.keys(html.attenance_data).length > 0 ){
//                 var chart = $('#container_attendance').highcharts();

//                 var data =[];

//                 $.each(html.attenance_data.total,
//                     function(key,value) {
//                        data.push(parseInt(value));
//                     });
//                 chart.series[0].setData(data);
//             }
//             else{

//                 var chart = $('#container_attendance').highcharts();
//                 if(chart != undefined){
//                     chart.series[0].setData([' ',0]);
//                 }

//             }

//             $(".floorAjax").html(html);
//         }
//     });
// });