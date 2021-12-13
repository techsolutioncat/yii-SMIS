/**
 * Student JS
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com> on 12/25/2016.
 */


$(document).on('click','#modal-pdf-detail',function () {
    var studentId = $(this).data('std_id');
    var studentName = $(this).data('std_name');
    var url         =  $(this).data('url');

    if(url){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                student_id:studentId,
            },
            success: function(data)
            {
                if(data.status== 1){
                    $("#exam_type_option").empty().html(data.options);

                    if(data.counter <= 0){
                        $('#print-pdf').addAttr({'disabled':true});
                    }else{
                        $('#print-pdf').addAttr({'disabled':false});
                    }
                }


            }
        });
    }
    $('#std_id').val(studentId);
    $('span#student-name').html(studentName);
});


$(document).on('click','button#print-pdf',function () {
    var html   = $(this).closest('.modal-content');
    var impToRead       = html.find('#imp-to-read').val();
    var exam            = html.find('#exam_type_option').val();
    var cmtCrd          = html.find('#comment-cordinator').val();
    var classTearcher   = html.find('#class_teacher').val();
    var areafocus1  = html.find('#area-to-focus-1').val();
    var areafocus2  = html.find('#area-to-focus-2').val();
    var areafocus3  = html.find('#area-to-focus-3').val();
    var url         = $(this).data('url');
    var studentId   = html.find('#std_id').val();
    var manners     = $('#manners').val();
    var confidence  = $('#confidence').val();
    var errors = 0;




    /*validate important to read*/
    if(exam ==''){
        html.find('#exam_type_option').css({'border-color':'red'});
        errors++;
    }else{
        html.find('#exam_type_option').removeAttr('style');
    }
    if(impToRead == ''){
        html.find('#imp-to-read').closest('div.field-imp-to-read').addClass('has-error');
        html.find('#imp-to-read').closest('.div.field-imp-to-read').removeClass('has-success');
        html.find('#imp-to-read').closest('div.field-imp-to-read').find('.help-block').html('Important to read can not be blank.');
        errors++;
    }
    else{
        html.find('#imp-to-read').closest('.field-imp-to-read').addClass('has-success');
        html.find('#imp-to-read').closest('.field-imp-to-read').removeClass('has-error');
        html.find('#imp-to-read').closest('.field-imp-to-read').find('.help-block').html('');
    }

    /*validate comment cordinator*/
    if(cmtCrd == ''){
        html.find('#comment-cordinator').closest('div.field-cmt-crdntr').addClass('has-error');
        html.find('#comment-cordinator').closest('.div.field-cmt-crdntr').removeClass('has-success');
        html.find('#comment-cordinator').closest('div.field-cmt-crdntr').find('.help-block').html('Comments of Coordinator can not be blank.');
        errors++;
    }
    else{
        html.find('#comment-cordinator').closest('.field-cmt-crdntr').addClass('has-success');
        html.find('#comment-cordinator').closest('.field-cmt-crdntr').removeClass('has-error');
        html.find('#comment-cordinator').closest('.field-cmt-crdntr').find('.help-block').html('');
    }

    /*validate manners*/
    if(manners == ''){
        html.find('#manners').closest('div.field-manners').addClass('has-error');
        html.find('#manners').closest('.div.field-manners').removeClass('has-success');
        html.find('#manners').closest('div.field-manners').find('.help-block').html('Manners rating is required.');
        errors++;
    }
    else{
        html.find('#manners').closest('.field-manners').addClass('has-success');
        html.find('#manners').closest('.field-manners').removeClass('has-error');
        html.find('#manners').closest('.field-manners').find('.help-block').html('');
    }

    /*validate confidence*/

    if(confidence == ''){
        html.find('#confidence').closest('div.field-confidence').addClass('has-error');
        html.find('#confidence').closest('.div.field-confidence').removeClass('has-success');
        html.find('#confidence').closest('div.field-confidence').find('.help-block').html('Confidence rating is required.');
        errors++;
    }
    else{
        html.find('#confidence').closest('.field-confidence').addClass('has-success');
        html.find('#confidence').closest('.field-confidence').removeClass('has-error');
        html.find('#confidence').closest('.field-confidence').find('.help-block').html('');
    }

    /*validate class teacher*/

    if(classTearcher == ''){
        html.find('#class_teacher').closest('div.field-class-teacher').addClass('has-error');
        html.find('#class_teacher').closest('.div.field-class-teacher').removeClass('has-success');
        html.find('#class_teacher').closest('div.field-class-teacher').find('.help-block').html('Class teacher is required.');
        errors++;
    }
    else{
        html.find('#class_teacher').closest('.field-class-teacher').addClass('has-success');
        html.find('#class_teacher').closest('.field-class-teacher').removeClass('has-error');
        html.find('#class_teacher').closest('.field-class-teacher').find('.help-block').html('');
    }

    if(errors > 0){
        return false;
    }
    else{
        $('#generate-dmc-form').submit();

    }
});

/*close pdf-details on close x btn and close-generate-pdf id button starts here*/
$(document).on('click','#pdf-details .close',function () {
    $(this).closest('.modal-content').find('input').val('');
    $('#manners').rating('clear');
    $('#confidence').rating('clear');
    $(this).closest('.modal-content').find('textarea#comment-cordinator').val('');
});

$(document).on('click','#close-generate-pdf',function () {
    $(this).closest('.modal-content').find('input').val('');
    $('#manners').rating('clear');
    $('#confidence').rating('clear');
    $(this).closest('.modal-content').find('textarea#comment-cordinator').val('');
});

/*close pdf-details on close x btn and close-generate-pdf id button ends here*/


