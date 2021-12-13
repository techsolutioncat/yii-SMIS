/**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 2/21/2016.
 * dashboard.js
 * for Dashboard related js.
 */


/*student attendance total bar graph*/
$(function () {
    if(typeof attendance_details !=='undefined'){
        if (Object.keys(attendance_details).length > 0) {
            var attendanceOptions = {
                chart: {
                    type: 'column',
                    height: 200,
                    width: 200,
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
                        text: 'Total (Students)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }

                },
                tooltip: {
                    valueSuffix: ' Students'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: true,
                credits: {
                    enabled: false
                },
                series: [{
                    name: currentDate,
                    data: attendance_details.total
                }]
            };
            var chart = new Highcharts.chart('container_attendance', attendanceOptions);
        }
    }
    if(typeof attendance_emp_details !=='undefined'){
        if (Object.keys(attendance_emp_details).length > 0) {
            var attendanceOptions = {
                chart: {
                    type: 'column',
                    height: 200,
                    width: 200,
                },
                title: {
                    text: null
                },
                subtitle: {
                    text: null
                },
                xAxis: {
                    categories: attendance_emp_details.leave_type,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total (Employees)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }

                },
                tooltip: {
                    valueSuffix: ' Employees'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: true,
                credits: {
                    enabled: false
                },
                series: [{
                    name: currentDate,
                    data: attendance_emp_details.total
                }]
            };
            var chart = new Highcharts.chart('container_attendance_emp', attendanceOptions);
        }
    }
});
/*deactivate pallet popup*/
$(document).on('click','#close-pallets',function (e) {
    var palletId = $(this).data('id');
    var palletName = $(this).data('name');
    $('#pallet_id').val(palletId);
    $('#modal-pallet-inactive-conf #modalContent').html('Are you sure you want to deactivate "<strong>'+palletName+'</strong>" pallet from your dashboard?');
    $('#modal-pallet-inactive-conf').modal('show');
});
/*add quick links*/
$(document).on('click','#add-quick-links',function () {
    $('#modal-pallet-active-conf').modal('show');
});

/*on the confirmation of user inactive the pallet*/
$(document).on('click','#remove-pallet',function () {
   var url  = $(this).data('url');
    var palletId =  $(this).closest('.modal-content').find('.modal-header #pallet_id').val();
var contentData =$(this).closest('.modal-content');
    if(palletId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                pallet_id:palletId
            },
            beforeSend: function(){
                contentData.append("<div id='overLayDiv'><div style='top: 50%;left: 50%;margin-right: auto;margin-bottom: auto;position: absolute;'><span style='color:#1FA4EA; font-size:20px; font-weight:bold; padding-left:5px;'><i class='fa fa-refresh fa-spin'></i></span></div></div>");
                $("#overLayDiv").css({
                    'height': '94%',
                    'opacity': 0.75,
                    'position': 'absolute',
                    'top': 7, 'left': 7,
                    'background-color': 'black',
                    'width': '97%',
                    'z-index': 999999
                });
                $("#overLayDiv").show();
            },
            success: function(data)
            {
                if(data.status== 1){
                    $('#pallet-no-'+palletId).hide();
                    $('#active-inactive-pallet-'+palletId).removeAttr('checked');
                    $('#overLayDiv').remove();
                    $('#modal-pallet-inactive-conf').modal('hide');
                }


            }
        });
    }
});


/*activate deactivate quick link*/
$(document).on('click','input[id^="active-inactive-pallet-"]',function(){
    var palletId =  $(this).data('id');
    var url =  $(this).data('url');
    var status =0;
    var id =  $(this).attr('id');
    var pageHtml = $(this).closest('#modal-pallet-active-conf').closest('.container-wrap').find('.db-wrapper .main-pallet .db-wrapper-inn');
    var fullId = '#pallet-no-'+palletId;
    if($(this).is(':checked')==true){
        pageHtml.find('#pallet-no-'+palletId).show();
        status = 1;
    }else{
        pageHtml.find('#pallet-no-'+palletId).hide();
        status =0;
    }
    if(palletId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                pallet_id:palletId,
                status:status
            },

            success: function(data)
            {

            }
        });
    }

});

