/**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 02/24/2016.
 * exam.js
 * for exam related js.
 */


$(document).on('click','a[data-toggle="tab"]', function (e) {
    var target = $(e.target).attr("href") // activated tab
    var targetText = $(e.target).text() // activated tab
    var details = $('#modal-type');
    details.find('.modal-header h4').text(targetText);
    if(target =='#Single-Examination'){
        $('#single-dropdown').show();
        $('#multiple-dropdown').hide();
    }
    else if(target =='#Multiple-Examination'){
        $('#multiple-dropdown').show();
        $('#single-dropdown').hide();
    }else if(target =='#Class-Wise-Examination'){
        $('#single-dropdown').show();
        $('#multiple-dropdown').hide();
    }else{
        $('#single-dropdown').hide();
        $('#multiple-dropdown').hide();
    }
    $('#tab_type').val(target);
    /*if(target != '#Class-Wise-Examination'){
        $('#modal-type').modal('show');
    }*/
    $('#modal-type').modal('show');
    return false;
});
/*search dmc std list.*/
$(document).on('click','#search-exam-dmc',function () {
   var url  =$(this).data('url');
    var formHtml = $(this).closest('.modal-content').find('.modal-body form');
    var formData = formHtml.serialize();
    var singleDropdown      = $('select#exam-fk_exam_type-1');
    var multipleDropdown    = $('#multiple-dropdown select');
    var tabId               = $('#tab_type').val();
    var classId     = $('#class-id').val();
    var groupId     = $('#group-id').val();
    var sectionId   = $('#section-id').val();
    var position = '';
    var error = 0;
    if(tabId == '#Single-Examination'){
        if(singleDropdown.val()==''){
            singleDropdown.closest('.form-group').addClass('has-error');
            singleDropdown.closest('.form-group').removeClass('has-success');
            singleDropdown.closest('.form-group').find('.help-block').html('Exam is Required');
            error++;
        }else{
            singleDropdown.closest('.form-group').addClass('has-success');
            singleDropdown.closest('.form-group').removeClass('has-error');
            singleDropdown.closest('.form-group').find('.help-block').html('');
        }
    }else if (tabId == '#Multiple-Examination'){
        if(multipleDropdown.val() == '' || multipleDropdown.val() == null){
            multipleDropdown.closest('.form-group').addClass('has-error');
            multipleDropdown.closest('.form-group').removeClass('has-success');
            multipleDropdown.closest('.form-group').find('.help-block').html('Exam is Required');
            error++;
        }else{
            multipleDropdown.closest('.form-group').addClass('has-success');
            multipleDropdown.closest('.form-group').removeClass('has-error');
            multipleDropdown.closest('.form-group').find('.help-block').html('');
        }
    }else{

    }
    if(error == 0){
        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: {data:formData},
            url: url,
            success: function(result)
            {
                if(result.status ==1){
                    var examType = singleDropdown.val();
                    var position = Array();
                    if(result.tabId =='Single-Examination'){
                        $("#"+result.tabId).html(result.html);
                        var exportUrl = $('.exportdmcs').data('url');

                        $('#mCSB_1_container ul.std-exam-list li').each(function() {
                            var id = ($(this).find('a').data('position') != "")? $(this).find('a').data('position'): 0;
                            position.push(id);
                        });
                        var str_position = JSON.stringify(position);

                        var dataUrl = exportUrl+"?class_id="+classId+"&group_id="+groupId+"&section_id="+sectionId+"&exam_id="+examType+'&position=' + str_position;
                        $('.exportdmcs').html('<a class="btn green-btn" href="'+dataUrl +'">Export & Print All DMC\'S</a>');
                        $('.exportdmcs').show();
                        $('.export-classwise-resultsheet').hide();
                        $('ul.std-exam-list li a').first()[0].click();
                    }
                    if(result.tabId =='Class-Wise-Examination'){
                        var arrayParam = {"param1":1,"param2":2};
                        $("#"+result.tabId).empty().html(result.html);
                        var exportUrl = $('.export-classwise-resultsheet').data('url');
                        $('#mCSB_1_container ul.std-exam-list li').each(function() {
                            var id = ($(this).find('a').data('position') != "")? $(this).find('a').data('position'): 0;
                            position.push(id);
                        });
                        var str_position = JSON.stringify(position);
                        var dataUrl = exportUrl+"?fk_class_id="+classId+"&fk_group_id="+groupId+"&fk_section_id="+sectionId+"&fk_exam_type="+examType +'&position=' +  str_position;
                        $('.export-classwise-resultsheet').html('<a href="'+dataUrl+'"><img src="/mis/img/print.png" alt="print report"></a>');
                        $(".export-classwise-resultsheet a").attr( "params",arrayParam );

                        $('.exportdmcs').hide();
                    }

                    $('#modal-type').modal('hide');
                }else{
                    $("#"+result.tabId).html(result.html);
                    $('#modal-type').modal('hide');
                }
            }
        });
    }
    //console.log(formHtml.serialize());

});

$(document).on('click','#modal-type .close',function () {
   //alert('here');
});

/*on change of exam type get exam relted details.*/
$(document).on('change','#exam-type-id',function(){
   
    var examId      = $(this).val();
    var classId     = $('#class-id').val();
    var groupId     = $('#group-id').val();
    var sectionId   = $('#exam-section-id').val();
    //console.log(classId+' '+groupId+' '+sectionId);
    var url=$(this).closest('.exam-dropdown-list').find('#exam-url').val();
    $("#exams-inner").empty().append("<div id='loading-loader'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    $.ajax
    ({
        type: "POST",
        dataType:'JSON',
        data: {class_id:classId,group_id:groupId,section_id:sectionId,exam_id:examId},
        url: url,
        success: function(result)
        {
            $("#exams-inner").html(result.views);
        }
    });

});

/*get dmc of select student*/
$(document).on('click','#exam_std_list',function () {
   var url              = $(this).data('url');
   var stdid            = $(this).data('stdid');
   var classId          = $(this).data('class');
   var groupId          = $(this).data('group');
   var stdPosition      = $(this).data('position');
   var sectionId        = $(this).data('section');
   var exam_id           = $(this).data('examid');
    $('.fs_sidebar li').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.performance-graphs').hide();
    $(".ajax-content").empty().append("<div id='loading-loader'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    $.ajax
    ({
        type: "POST",
        dataType:'JSON',
        data: {stu_id:stdid,class_id:classId,group_id:groupId,section_id:sectionId,exam_id:exam_id,'stdPosition':stdPosition},
        url: url,
        success: function(result)
        {
            $(".ajax-content").empty().html(result.html);
            var chart = $('#dmc-graph-container').highcharts();
            if(Object.keys(chart.series).length > 0) {
                var seriesLength = chart.series.length;
                for (var i = seriesLength - 1; i > -1; i--) {
                    chart.series[i].remove();
                }
            }
           /* console.log(result.total_subjects);*/
            chart.xAxis[0].setCategories(result.total_subjects);
            for(i=0;i<=result.total_count;i++) {
                chart.addSeries({
                    name: result.total_subjects[i],
                    data: result.total_marks_subjects[i]
                });
                chart.redraw();
                // URL to Highcharts export server

            }
           /* var obj = {},
                // URL to Highcharts export server
            exportUrl = 'http://export.highcharts.com/';
            obj.options = JSON.stringify(chart.options);
            obj.type = 'image/png';
            obj.async = true;

            $.ajax({
                type: 'post',
                url: exportUrl,
                data: obj,
                success: function (data) {
                    console.log( exportUrl + data);
                }
            });*/
            $('.performance-graphs').show();

            /*$.each(html.attenance_data.total,
                function(key,value) {
                    data.push(parseInt(value));
                });*/
        }
    });

});