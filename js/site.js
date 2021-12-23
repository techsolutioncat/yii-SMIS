/**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 12/9/2016.
 */


/* employe  martial status single/married/divorced*/

$(document).on('click','.maritial_status',function(){
    var statusValue= $('input[name="EmployeeInfo[marital_status]"]:checked').val();
   // alert(statusValue);
    if(statusValue== '2' || statusValue== '3'){ 
        $('.spouse').slideDown('slow');
    }else{
        $('.spouse').slideUp('slow');
    } 
});



/*yii2 gridview check all check box*/
$(document).on('click', '[name="selection_all"]', function() {
    $("[name='selection[]']").prop('checked', $(this).prop('checked')).trigger('change');
});

/*student information show hide dead or alive*/

$(document).on('click','.stops',function(){
    //alert('adfasf');

    var statusValue= $('input[name="StudentInfo[is_transport_avail]"]:checked').val();
   // alert(statusValue);
    if(statusValue == '1'){
        $('.displayRoute').slideDown('slow');

    }else{
        $('.zonechange').val('');
        $('.route').val('');
        $('.stop').val('');
        $('.displayRoute').slideUp('slow');
    }
});

/*================start of student sms ====== */

$(document).on('click','#stu',function(){
    $('#stu_id').val($(this).data('stu_id'));
});

$(document).on('click','#sendSms',function(){
    var studentId=$('#stu_id').val();
    var textarea=$('#textareasms').val();
    var getUrl=$(this).data('url');
   // alert(getUrl);
    $.ajax({
            type: "POST",
            data: {studentId:studentId,textarea:textarea},
            url: getUrl,
            cache: false,
            success: function(result){
                console.log(result);
                //$('#sucmsg').text(result);
                $('#myModal').modal('hide');
                //$(".floorAjax").html(result);
            }
    });
});

/*================end of student sms ====== */

/* visitor log scripts */
$(document).on('change','.categoryVisits ',function(){
    var getvalue=$(this).val();
    //alert(getvalue);
    // var statusValue= $('input[name="StudentInfo[stop]"]:checked').val();
    if(getvalue == '3'){ //admission
        $('.admission').slideDown('slow');
        $('.jobs').hide();
        $('.advertisement').hide();
        $('.admisn').show();
    }
    // else{
    //     $('.admission').slideUp('slow');
    // }
   else if(getvalue == '1'){ //jobs
        $('.admission').slideDown('slow');
        $('.advertisement').show();
        $('.jobs').show();
        $('.admisn').hide();
        $('.advertisement').hide();
    }else if(getvalue == '2'){ //advertisement
        $('.admission').slideDown('slow');
        $('.advertisement').show();
        $('.admisn').hide();
        $('.jobs').hide();
    }


    else{
        $('.admission').slideUp('slow');
    }
});
/*end of visitor log scripts*/

/*student information show hide stop or non stop*/

$(document).on('click','.parent_status',function(){
    var statusValue= $('input[name="StudentInfo[parent_status]"]:checked').val();
    if(statusValue == '0'){
        $('.deads').slideDown('slow');
    }else{
        $('.deads').slideUp('slow');
    }
});

$(document).on('click','.hosteldetail',function(){
    var statusValue= $('input[name="StudentInfo[is_hostel_avail]"]:checked').val();
    $('.active').val(statusValue);
    if(statusValue == '1'){
        $('.hostel').slideDown('slow');
    }else{
        $('.hostel').slideUp('slow');
    }
});

/* ====================  dependent room bed ====*/

$(document).on('change','.hostelAll',function(){
        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".floorAjax").html(html);
            } 
        });
        
    });


$(document).on('change','.floorAjax',function(){

        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".roomBed").html(html);
            } 
        });
        
    });


$(document).on('change','.roomBed',function(){

        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".beds").html(html);
            } 
        });
        
    });

/*===================== end of dependent room bed ======*/


// student dependant country
$(document).on('click','.search',function(){
    var url=$(this).data('url');
    var getVal       = $('.passVal').val();
    var classval     = $('.classval').val();
    var searchVal    = $('.searchBy').val();
    var getinput     = $('.hiddenPassvalue').val();
    var getStatus    = $('#search-status:checked').val();


   

    var error =0;
    //alert(searchVal);
    
    if(searchVal ==''){
        $('.searchBy').css({"border": '1px solid #ffb3b3'});
        error++;
    }else if(searchVal == 'overall'){
        $('.passVal').hide();
    }else{
        $('.searchBy').removeAttr('style');
    }

    if(searchVal== 'class'){
        if(classval ==''){
            $('.classval').css({"border": '1px solid #ffb3b3'});
            error++;
        }else{
            $('.classval').removeAttr('style');
        }
    }else{
        if(getVal == ''){
            $('.passVal').css({"border": '1px solid #ffb3b3'});
            error++;
        }else{
            $('.passVal').removeAttr('style');
        }
    }


    /*if error exsists*/
    if(error==0){
        $.ajax({
            type: "POST",
            dataType:"JSON",
            url:url,
            data:{
                getVal:getVal,
                getinput:getinput,
                classval:classval,
                status:getStatus,
            },
            success: function(data)
            {
                $('.displaysearch').html(data);
                if(data.status== 1){
                    $("#displaysearch").empty().html(data.details);
                    //$('#subject-details').html();
                    /* start of search alert  */
                    if($('.classfullname').is(":checked")) {
                       // alert('1');
                       $('.thisinputname').val(2);
                        $('.fullnameClass').show();
                        $('.fullnameClassHeader').show(); 
                          
                       }else{
                        $('.thisinputname').val(1);

                         //alert('2'); 
                        $('.fullnameClass').hide();
                          $('.fullnameClassHeader').hide();
                       
                       }

                           if($('.classparentname').is(":checked")) {
                              $('.parntclass').val(2);

                              $('.parntClass').show();
                              $('.parntClassHeader').show();
                           }else{
                            $('.parntclass').val(1);
                            $('.parntClass').hide();
                            $('.parntClassHeader').hide();
                           }

                                if($('.classclass').is(":checked")) {
                                $('.inputclass').val(2);

                                  $('.classClass').show();
                                  $('.classClassHeader').show();
                                 }else{
                                $('.inputclass').val(1);
                                $('.classClass').hide();
                                $('.classClassHeader').hide();
                               }

                               
                               if($('.classgroup').is(":checked")) {
                                $('.grpclass').val(2);

                                  $('.groupClass').show();
                                  $('.groupClassHeader').show();
                               }else{
                                $('.grpclass').val(1);

                                $('.groupClass').hide();
                                $('.groupClassHeader').hide();
                               }

                                   if($('.sectionClass').is(":checked")) {
                                    $('.sectinclass').val(2);

                                      $('.sectionClasses').show();
                                      $('.sectionClassHeader').show();
                                   }else{
                                    $('.sectinclass').val(1);

                                    $('.sectionClasses').hide();
                                    $('.sectionClassHeader').hide();
                                   }
                                  
                              
                               if($('.contactNo').is(":checked")) {
                                $('.classcntct').val(2);

                                  $('.contactClass').show();
                                  $('.contactClassHeader').show();
                               }else{
                                $('.classcntct').val(1);

                                $('.contactClass').hide();
                                $('.contactClassHeader').hide();
                               }

                               if($('.dob').is(":checked")) {
                                $('.dobclass').val(2);

                                  $('.dobClass').show();
                                  $('.dobClassHeader').show();
                               }else{
                                $('.dobclass').val(1);

                                $('.dobClass').hide();
                                $('.dobClassHeader').hide();
                               }

                               if($('.addressclass').is(":checked")) {
                                $('.adrsclass').val(2);

                                  $('.addressClass').show();
                                  $('.addressClassHeader').show();
                               }else{
                                $('.adrsclass').val(1);

                                $('.addressClass').hide();
                                $('.addressClassHeader').hide();
                               }

                                   if($('.regno').is(":checked")) {
                                    $('.regclass').val(2);

                                      $('.regClass').show();
                                      $('.regClassHeader').show();
                                   }else{
                                    $('.regclass').val(1);

                                    $('.regClass').hide();
                                    $('.regClassHeader').hide();
                                   }
                              
                           
                          
                        

                        /* end of start of search alert  */
                }

            }
        });
        

    }
});

$(document).on('change','.searchBy',function(){
   var value=$(this).val();
   //alert(value);
   if(value == 'class'){
    $('.passVal').hide();
    $('.showclass').show();
   }else if(value == 'overall'){
    $('.passVal').val(value);
    $('.passVal').hide();

   }else{
    $('.showclass').hide();
     $('.passVal').show();
   }
   $('.hiddenPassvalue').val(value);
});
    

$(document).on('change','.country',function(){

       // alert('sadf');
        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "country",
            cache: false,
            success: function(html)
            {
                $(".state").html(html);
            } 
        });
        
    });

//get province

$(document).on('change','.state',function(){

        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "province",
            cache: false,
            success: function(html)
            {
                $(".district").html(html);
            } 
        });
        
    });

// get district 

$(document).on('change','.district',function(){

        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "district",
            cache: false,
            success: function(html)
            {
                $(".city").html(html);
            } 
        });
        
    });

$(document).on('click','.permanent_address',function(){
  
        //var adresValue= $('input[name="StudentInfo[permanent_address]"]:checked').val();
        var adresValue= $(this).val();

        //alert(adresValue);
        if(adresValue == '1'){
        $('.address2Show').hide();
       //$('.address2Show').slideDown('slow');
        $('.address2').hide();
        var postal=$('#studentinfo-location1').val();
        $('.permanent').val(postal);

       var country= $('.country :selected').val();
        $('.country2').val(country);

        var provincesss=$('.state').val();
        $('#thisprovince').val(provincesss);

        var district=$('.district option:selected').val();
        $('.district2').val(district);

        var city=$('.city option:selected').val();
        $('.city2').val(city);


        ////get text of adreeses
        var country1= $('.country :selected').html();
        $('.country21').val(country1);

        var province1=$('.state option:selected').html();
        $('.provinces21').val(province1);

        var district1=$('.district option:selected').html();
        $('.district21').val(district1);

        var city1=$('.city option:selected').html();
        $('.city21').val(city1);
    }else{
        $('.address2').show();
    }
    });




////////////////addresss other



$(document).on('click','.permanent_addressoother',function(){
  //alert('adsfasdf');

        //var adresValue= $('input[name="StudentInfo[permanent_address]"]:checked').val();
        var adresValueother= $(this).val();
       // alert(adresValueother);

        if(adresValueother == '1'){
        $('.address2Show').hide();
        $('.addressother').hide();
        var postal=$('#employeeinfo-location2').val();
        //alert(postal);
        $('#employeeinfo-location1').val(postal);

       var country= $('.country :selected').val();
      // alert(country);
        $(".country2").val(country);

        var provincesss=$('.state').val();
        $('#thisprovince').val(provincesss);

        var district=$('.district option:selected').val();
        $('.district2').val(district);

        var city=$('.city option:selected').val();
        $('.city2').val(city);


        ////get text of adreeses
        var country1= $('.country :selected').html();
        $('.country21').val(country1);

        var province1=$('.state option:selected').html();
        $('.provinces21').val(province1);

        var district1=$('.district option:selected').html();
        $('.district21').val(district1);

        var city1=$('.city option:selected').html();
        $('.city21').val(city1);
    }else{
       // alert(adresValueother);
        $('.addressother').show();
        /*$(document).on('change','#employeeinfo-fk_ref_country_id2',function(){
          
            var country= $('#employeeinfo-fk_ref_country_id2 :selected').val();
            
            $(".country2").val(country);
            });

        $(document).on('change','#employeeinfo-fk_ref_province_id2',function(){
          
            var prov= $('#employeeinfo-fk_ref_province_id2 :selected').val();
             
            
            $("#thisprovince").val(prov);
            //$(".state2").val(prov);
            });

        $(document).on('change','#employeeinfo-fk_ref_district_id2',function(){
          
            var districtx= $('#employeeinfo-fk_ref_district_id2 :selected').val();
            
            $(".district2").val(districtx);
            });

        $(document).on('change','#employeeinfo-fk_ref_city_id2',function(){
          
            var cityx= $('#employeeinfo-fk_ref_city_id2 :selected').val();
            
            $(".city2").val(cityx);
            });*/
        

    }
    });

//////////get group from class 

$("#studentinfo-class_id").change(function() {
        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "group",
            cache: false,
            success: function(html)
            {
                $(".group").html(html);
            } 
        });
        
    });

$("#studentinfo-group_id").change(function(){
       // alert('adf');
        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "section",
            cache: false,
            success: function(html)
            {
                $(".section").html(html);
            } 
        });
        
    });
////// coutry for employee


/* on selecting class from section group will be displayed*/
$(document).on('change','#refsection-class_id', function(){
    //alert('adf');
    var id=$(this).val();
    var url = $(this).data('url');
    var dataString = 'id='+ id;

    $.ajax
    ({
        type: "POST",
        data: dataString,
        url: url,
        cache: false,
        success: function(data)
        {
            $("#refsection-fk_group_id").html(data)

        }
    });

});

/*  get class on base of session  */
$(document).on('change','#studentinfo-session_id',function(){
    //alert('asdf');
    var id=$(this).val();
    var url=$(this).data('url');
     var dataString = 'id='+ id;
    $.ajax({
        type:"POST",
        data: dataString,
        url:url,
        cache:false,
        success:function(data){
            $('#class-id').html(data);
        }
    });
});

/* on selecting class from section group will be displayed*/
$(document).on('change','#subjects-fk_class_id', function(){
    var id=$(this).val();
    var url = $(this).data('url');
    var dataString = 'id='+ id;

    $.ajax
    ({
        type: "POST",
        data: dataString,
        url: url,
        cache: false,
        success: function(data)
        {
            $("#subjects-fk_group_id").html(data)

        }
    });

});

/*on change of exam subjects.*/
$(document).on('change','#class-id',function () {
   var sectionId = $('#section-id').val();
   var classId = $(this).val();
   var groupId = $('#group-id').val();
   var url = $('#passClassUrl').data('url');
   //alert(url);
   //return false;

    $("#subject-inner").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    if(groupId ==''){ 
        groupId=null;
    }
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {class_id:classId,group_id:groupId,section_id:sectionId},
        success: function(data)
        {
            if(data.status== 1){
                $("#subject-inner").empty().html(data.details);
                //$('#subject-details').html();
            }


        }
    });

});



$(document).on('change','#section-id',function () {
    //alert('adf');
   var sectionId = $(this).val();
   var classId = $('#class-id').val();
   var groupId = $('#group-id').val();
   var url = $(this).closest('.col-sm-4').find('#subject-url').val();

    $("#subject-inner").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    if(groupId ==''){ 
        groupId=null;
    }
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {class_id:classId,group_id:groupId,section_id:sectionId},
        success: function(data)
        {
            if(data.status== 1){
                $("#subject-inner").empty().html(data.details);
                //$('#subject-details').html();
            }


        }
    });

});

/*============ depend on zone route and stop */
 $(document).on('change','.zonechange',function () {
        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".route").html(html);
            } 
        });
        
    });

$(document).on('change','#studentinfo-route',function () {
        //alert('sadf');
        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".stop").html(html);
            } 
        });
        
    });

 /*================ end of zone*/

/*save exam*/
$(document).on('click','#save-form',function (e) {
    e.preventDefault();
    $(this).attr("disabled", true);
    var examId =  $('#exam-fk_exam_type');
    var url =  $('#exam-form').attr('action');
    var error = 0;

    if(examId.val() == ''){
        $('div.field-exam-fk_exam_type').addClass('has-error');
        $('div.field-exam-fk_exam_type').removeClass('has-success');
        $('div.field-exam-fk_exam_type').find('div.help-block').html('Exam Name is required');
        $(this).attr("disabled", false);
        error++;
    }else{
        $('div.field-exam-fk_exam_type').addClass('has-success');
        $('div.field-exam-fk_exam_type').removeClass('has-error');
        $('div.field-exam-fk_exam_type').find('div.help-block').html('');
    }

    /*each function*/
    $('input[id^="exam-do_not_create-"]').each(function(){
        var id= $(this).attr('id');
        var splitValue = id.split("-");

        /*if row is unchecked get values*/
        if($(this).is(':checked') == false){
            var totalMarks      = $('#exam-total_marks-'+splitValue[2]).val();
            var passingMarks    = $('#exam-passing_marks-'+splitValue[2]).val();
            var startDate       = $('#exam-start_date-'+splitValue[2]).val();
            var endDate         = $('#exam-end_date-'+splitValue[2]).val();
            var result          = false;

            /*if total marks is empty.*/
            if(totalMarks == ''){
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').addClass('has-error');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('Total marks is required.');
                error++;
            }
            else if(totalMarks <= 0){
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').addClass('has-error');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('Total marks must be greater than 0.');
                error++;
            }
            else{
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').removeClass('has-error');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').addClass('has-success');
                $('#exam-total_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('');
            }
            /*if passing marks is empty.*/
            if(passingMarks == ''){
                $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').addClass('has-error');
                $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('Passing marks is required.');
                error++;
            }
            else{
                result = (parseFloat(passingMarks) > parseFloat(totalMarks));
               /*alert(result);
                alert(parseInt(passingMarks)+parseInt(totalMarks))*/
                if(result == true){
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').addClass('has-error');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('Passing Marks must be less than total marks.');
                    error++;

                }
                else if(passingMarks <= 0){
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').addClass('has-error');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('Passing Marks must be greater than 0');
                    error++;
                }
                else{
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').removeClass('has-error');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').addClass('has-success');
                    $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('');
                }

            }

            /*date comparison if not empty*/
            if(startDate == ''){
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').addClass('has-error');
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('Start Date is required.');
                error++;
            }
            else{
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').removeClass('has-error');
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').addClass('has-success');
                $('#exam-start_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('');
            }
            if(endDate == ''){
                $('#exam-end_date-'+splitValue[2]).closest('.form-group').removeClass('has-error');
                $('#exam-end_date-'+splitValue[2]).closest('.form-group').removeClassaddClass('has-success');
                $('#exam-end_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('End Date is required.');
                error++;
            }
            else{
                //alert(Date.parse(startDate) +"   "+Date.parse(endDate));
                if (Date.parse(startDate) > Date.parse(endDate)) {
                    //alert('end date is greater');
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').addClass('has-error');
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').removeClass('has-success');
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('End Date must be greater than started date');
                    error++;
                }else{
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').removeClass('has-error');
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').addClass('has-success');
                    $('#exam-end_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('');
                }

            }

        }
        /*if row is checked skip the row data and remove validation*/
        else{
            /*remove error on total marks*/
            $('#exam-total_marks-'+splitValue[2]).closest('.form-group').removeClass('has-error');
            $('#exam-total_marks-'+splitValue[2]).closest('.form-group').addClass('has-success');
            $('#exam-total_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('');

            /*remove error on passing marks*/
            $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').removeClass('has-error');
            $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').addClass('has-success');
            $('#exam-passing_marks-'+splitValue[2]).closest('.form-group').find('.help-block').html('');

            /*remove error on start date*/
            $('#exam-start_date-'+splitValue[2]).closest('.form-group').removeClass('has-error');
            $('#exam-start_date-'+splitValue[2]).closest('.form-group').addClass('has-success');
            $('#exam-start_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('');

            /*remove error on end date*/
            $('#exam-end_date-'+splitValue[2]).closest('.form-group').removeClass('has-error');
            $('#exam-end_date-'+splitValue[2]).closest('.form-group').addClass('has-success');
            $('#exam-end_date-'+splitValue[2]).closest('.form-group').find('.help-block').html('');


        }

    });

    /*if there's no error than proceed with the following*/
    if(error == 0){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: $('#exam-form').serialize(),
            success: function(data)
            {
                if(data.status== 1){
                    $('#subject-details').html('<div class="alert alert-success"><strong>Success!</strong> Exam has been Created Successfully..</div>');
                    var delay = 2000; //Your delay in milliseconds
                    setTimeout(function(){ window.location = data.redirect_url; }, delay);
                }
            }
        });
    }
    else{
        return false;
    }

});

/*on selection of exam type ge all examtype subjects.*/
$(document).on('click','a#get-exam-subjects',function (e) {
    var url= $(this).data('url');
    var classId =$(this).data('class_id');
    var groupId =$(this).data('group_id');
    var sectionId =$(this).data('section_id');
    var examTypeId =$(this).data('exam_type_id');
    /*append loader*/
    $("#exam-inner").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {'class_id':classId,group_id:groupId,section_id:sectionId,exam_type_id:examTypeId},
        success: function(data)
        {
            if(data.status== 1){
                $("#exam-inner").empty().html(data.details);
            }
        }
    });

});


/*on selection of attendance analysis exams will be mentioned.*/
$(document).on('click','a#get-attendance-analysis',function (e) {

    var url= $(this).data('url');
    var classId =$(this).data('class_id');
    var groupId =$(this).data('group_id');
    var sectionId =$(this).data('section_id');
    var examTypeId =$(this).data('exam_type_id');
    /*append loader*/
    $("#attendance-inner").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {'class_id':classId,group_id:groupId,section_id:sectionId,exam_type_id:examTypeId},
        success: function(data)
        {
            if(data.status== 1){
                $("#attendance-inner").empty().html(data.details);
            }
        }
    });

});

/*on selection of exam type ge all examtype subjects.*/
$(document).on('click','a#create-subject-awdlist',function (e) {

    var url= $(this).data('url');
    var examId =$(this).data('exam_id');
    /*append loader*/
    //$("#award-list").closest('.exam-type-index').find('.first').hide('slow');
    /*append loader*/
    //$("#award-list").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    $('#modal-award-list').find('.modal-boday').empty();
    $('#modal-award-list').find('#message').empty();
    $('#modal-award-list').find('#overLayDiv').remove();
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {'exam_id':examId},
        success: function(data)
        {
            if(data.status== 1){
                //$("#award-list").empty().html(data.details);
                $('#modal-award-list').find('.modal-body').html(data.details);
                $('#modal-award-list').modal('show');
            }
        }
    });

});

/*save Award List*/
$(document).on('click','#save-award-list',function (e) {
    e.preventDefault();
    $(this).attr("dsabled", true);
    var url =  $('#award-list-form').attr('action');
    var totalMarks =  $('#total-marks').val();
    var merror=0;
    var error=0;
    var input = $('input[id^="studentmarks-marks_obtained-"]');
    var textarea = $('input[id^="studentmarks-remarks-"]');
    $.each( input, function( key, value ) {
        var singilInput = $('#studentmarks-marks_obtained-'+key);
        var multipleInput = $('#studentmarks-remarks-'+key);
        var marksObt = singilInput.val();
        var serror=0;
        if(singilInput.val() ==''){
           /* singilInput.closest('.form-group').addClass('has-error');
            singilInput.closest('.form-group').removeClass('has-success');
            singilInput.closest('.form-group').find('.help-block').html('Marks Obtained cannot be blank.');
            serror++;*/
            singilInput.val(0);
        }
        else{
            //alert(singilInput.val()+">"+totalMarks);
            if($.isNumeric(singilInput.val())==false){
                singilInput.closest('.form-group').addClass('has-error');
                singilInput.closest('.form-group').removeClass('has-success');
                singilInput.closest('.form-group').find('.help-block').html('Marks Obtained must be an integer.');
                serror++;
            }else if(singilInput.val()< 0){
                singilInput.closest('.form-group').addClass('has-error');
                singilInput.closest('.form-group').removeClass('has-success');
                singilInput.closest('.form-group').find('.help-block').html('Marks Obtained must be greater than 0.');
                serror++;
            }else if(parseFloat(singilInput.val()) > parseFloat(totalMarks)){
                singilInput.closest('.form-group').addClass('has-error');
                singilInput.closest('.form-group').removeClass('has-success');
                singilInput.closest('.form-group').find('.help-block').html('Marks Obtained must less than total marks('+totalMarks+')');
                serror++;
            }
            else{
                singilInput.closest('.form-group').addClass('has-success');
                singilInput.closest('.form-group').removeClass('has-error');
                singilInput.closest('.form-group').find('.help-block').html('');
            }

        }
        if(multipleInput.val().length > 100){
            multipleInput.closest('.form-group').addClass('has-error');
            multipleInput.closest('.form-group').removeClass('has-success');
            multipleInput.closest('.form-group').find('.help-block').html('Remarks should contain at most 100 characters.');
            merror++;
        }else{
            multipleInput.closest('.form-group').addClass('has-success');
            multipleInput.closest('.form-group').removeClass('has-error');
            multipleInput.closest('.form-group').find('.help-block').html('');
        }
        error = error +serror;
    });
    if(merror>0 || error>0){
        return false;
    }else{
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: $('#award-list-form').serialize(),
            beforeSend: function(){
                $("div.modal-content").append("<div id='overLayDiv'><div style='top: 50%;left: 50%;margin-right: auto;margin-bottom: auto;position: absolute;'><span style='color:#1FA4EA; font-size:20px; font-weight:bold; padding-left:5px;'><i class='fa fa-refresh fa-spin'></i></span></div></div>");
                $("#overLayDiv").css({
                    'height': '94%',
                    'opacity': 0.75,
                    'position': 'absolute',
                    'top': 39, 'left': 13,
                    'background-color': 'black',
                    'width': '97%',
                    'z-index': 999999
                });
                $("#overLayDiv").show();
            },
            success: function(data)
            {
                if(data.status== 1){
                    $('#message').html('<div class="alert alert-success"><strong>Success!</strong> Award list has been Created Successfully..</div>');
                    $("#overLayDiv").remove();
                    $('#modal-award-list').modal('hide');
                }
            }
        });
    }
});

/* on change of selection month in attendacne tabe in student ananlysis*/
$(document).on('change','#attendance-data-picker',function (e) {
    var url             =  $(this).data('url');
    var classId         = $(this).data('class-id');
    var groupId         = $(this).data('group-id');
    var sectionId       = $(this).data('section-id');
    var yearMonth       = $(this).val();
    var attendanceType  = $(this).data('type');

    /*empty previous record*/
    $('#attendance-inner').empty();
    if(yearMonth){
        getAttendanceTypewise(url,classId,groupId,sectionId,attendanceType,yearMonth);
    }
});

/*attendance type selection*/

$(document).on('click','.attendanceOverall',function(){
        var url=$(this).data('url');
        var name=$(this).attr('name');
        var classId         = $('#attendance_type').data('class-id');

        var groupId         = $('#attendance_type').data('group-id');
        var sectionId       = $('#attendance_type').data('section-id');
        var attendanceType  = $('#attendance_type').data('type');

    if(name == 'Generate Report'){
        window.location.replace(url+"?classId="+classId+"&groupId="+groupId+"&sectionId="+sectionId+"&attendanceType="+attendanceType);
    }
});


$(document).on('click','.attendanceMonthly',function(){
        var url=$(this).data('url');
        var name=$(this).attr('name');
        var classId         = $('#attendance_type').data('class-id');

        var groupId         = $('#attendance_type').data('group-id');
        var sectionId       = $('#attendance_type').data('section-id');
        var attendanceType  = $('#monthly').val();
        
        var month=$("#attendance-data-picker").val();

    if(name == 'Generate Report'){
        window.location.replace(url+"?classId="+classId+"&groupId="+groupId+"&sectionId="+sectionId+"&attendanceType="+attendanceType+"&month="+month);
    }
});

$(document).on('change','#attendance_type',function (e) {
   var url = $(this).data(url);
    var type= $(this).val();
    if(type=='overall'){
        var url             = $(this).data('url');
        var classId         = $(this).data('class-id');
        var groupId         = $(this).data('group-id');
        var sectionId       = $(this).data('section-id');
        var attendanceType  = $(this).data('type');
        $('.year-month').hide('slow');
        $('.attendanceOverall').show('slow');
        $('.attendanceMonthly').hide();


        getAttendanceTypewise(url,classId,groupId,sectionId,attendanceType,'')
    }else{
        $('.year-month').show('slow');
        $('.attendanceOverall').hide();
        $('.attendanceMonthly').show('slow');

    }
});

/*general functionto get deails of attenance type*/
function getAttendanceTypewise(url,classId,groupId,sectionId,attendanceType,yearMonth){
    //console.log(url+' '+classId+' '+groupId+' '+sectionId+' '+attendanceType+' '+yearmonth);
    //return false;
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {attendance_type:attendanceType,year_month:yearMonth,class_id:classId,group_id:groupId,section_id:sectionId},
        success: function(data)
        {
            if(data.status== 1){
                $('#attendance-inner').html(data.details);
            }
        }
    });
}


$(document).on('change','.country2',function(){

       // alert('sadf');
        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "country2",
            cache: false,
            success: function(html)
            {
                $(".state2").html(html);
            } 
        });
        
    });
$(document).on('change','.state2',function(){

        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "province2",
            cache: false,
            success: function(html)
            {
                $(".district2").html(html);
            } 
        });
        
    });

// get district 

$(document).on('change','.district2',function(){

        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
       // alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: "district2",
            cache: false,
            success: function(html)
            {
                $(".city2").html(html);
            } 
        });
        
    });


/*on change of due date in general settings*/

$(document).on('change','#settings-fee_due_date',function(e){
    var date = new Date();
    var day = $(this).val();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    $('span#due_date').html('Due Date : '+  day+'-'+month+'-'+year);
});

/* this function apply velidation on donot create checkbox */
$(document).on('click','input[id^="exam-do_not_create-"]',function (e) {
    var id= $(this).attr('id');
    var splitValue = id.split("-");
    if($(this).is(':checked')){
        $('#exam-total_marks-'+splitValue[2]).attr('disabled',true);
        $('#exam-passing_marks-'+splitValue[2]).attr('disabled',true);
        $('#exam-start_date-'+splitValue[2]).attr('disabled',true);
        $('#exam-end_date-'+splitValue[2]).attr('disabled',true);
    }else{
        $('#exam-total_marks-'+splitValue[2]).attr('disabled',false);
        $('#exam-passing_marks-'+splitValue[2]).attr('disabled',false);
        $('#exam-start_date-'+splitValue[2]).attr('disabled',false);
        $('#exam-end_date-'+splitValue[2]).attr('disabled',false);
    }
});
/*
$(document).on('click','#select-all',function(event) {
    if(this.checked) {
        // Iterate each checkbox
        var id= $(this).attr('id');
        var splitValue = id.split("-");
        $('input[id^="exam-do_not_create-"]').each(function() {
            this.checked = true;
        });
    }
});
*/


/*challan search fee/index */
$(document).on('click','#get-challan-details',function () {
   var searchString = $('#search_chalan_stdnme');
   var url = $(this).data('url');
    if(searchString.val()==''){
        $(this).closest('.row').find('.form-group').addClass('has-error');
        $(this).closest('.row').find('.form-group').removeClass('has-success');
        $(this).closest('.row').find('.form-group .help-block').html('Search input is requried');
        return false;
    }else{
        $(this).closest('.row').find('.form-group').removeClass('has-error');
        $(this).closest('.row').find('.form-group').addClass('has-success');
        $(this).closest('.row').find('.form-group .help-block').html('');
        $("#detailed-area").empty();
        $.ajax
        ({
            type: "POST",
            dataType: "JSON",
            data: {search_string:searchString.val()},
            url: url,
            cache: false,
            success: function(html)
            {
                if(html.status==1){

                    $("#detailed-area").html(html.details);
                }else{
                    $("#detailed-area").html(html.error);
                }
            }
        });
    }

});


/*get chalan details and head*/
$(document).on('click','#view-challan-details',function(){
    var url= $(this).data('url');
    var challanId = $(this).data('challanid');
    var stdId = $(this).data('stdid');
 
    $("#fee-head-details").empty();
    if(challanId){
        $.ajax
        ({
            type: "POST",
            dataType: "JSON",
            data: {challan_id:challanId,std_id:stdId},
            url: url,
            cache: false,
            success: function(html)
            {
                if(html.status==1){
                    $("#fee-head-details").html(html.details);
                }else{
                    $("#fee-head-details").html(html.error);
                }
            }
        });
    }

});

/*submit challan form on showin fee result.*/
$(document).on('click','#chalan-form-btn',function( event ) {
    var submitVal = $(this).val();
    var totalAmount = $('tr.payment-tr').find('input#transaction-amount');
    var error=0;
    var netAmount       = $('#net-amount').data('net');
    var transectionAmt  = $('#transaction-amount').val();
    var total =netAmount-transectionAmt;

    $('#chalan-form-btn').append("<input type='hidden' name='submitValue' value='"+submitVal+"' />");
    if(totalAmount.val() == ''){
        totalAmount.closest('.form-group').addClass('has-error');
        totalAmount.closest('.form-group').removeClass('has-success');
        totalAmount.closest('.form-group').find('.help-block').html('Transaction Amount is Required.');
        error++;
    }else if($.isNumeric(totalAmount.val())== false){
        totalAmount.closest('.form-group').addClass('has-error');
        totalAmount.closest('.form-group').removeClass('has-success');
        totalAmount.closest('.form-group').find('.help-block').html('Transaction Amount must be an integer.');
        error++;
    }else if( total< 0 ){
        /*if total is in minus alert wrong transection input*/
        /*totalAmount.closest('.form-group').addClass('has-error');
        totalAmount.closest('.form-group').removeClass('has-success');
        totalAmount.closest('.form-group').find('.help-block').html('Wrong Input');*/
        alert('Wrong Input');
        error++;
    }else{
        totalAmount.closest('.form-group').addClass('has-success');
        totalAmount.closest('.form-group').removeClass('has-error');
        totalAmount.closest('.form-group').find('help-block').html('');
    }


    if(error == 0){
        $('#challan-form').submit();
    }else{
        return false;
    }
    event.preventDefault();
});

/* discount selection*/
$(document).on('click','input[name="FeeTransactionDetails[discount_amount]"]',function(){
    if(($(this).is(':checked'))){
        var radioValue = $(this).val();
        var totalAmount = $('#total-amount').data('total');
        var netAmount = $('#net-amount').data('net');
        var paidAmount = $('#amount-paid').data('amtpaid');
        var transportFare = $('#total-transport-fare').data('totaltrnsprt');


        if($(this).val() == 0){
            $('#discount-input').show();
        }else{
            $('#discount-input').find('input').val('');
            $('#discount-input').hide();
            //alert(totalAmount+' '+radioValue);
            /*get discount amount*/
            /*totalAmount - paidamount*/
            if(transportFare > 0){
                totalAmount =(totalAmount+transportFare)-paidAmount;
            }else{
                totalAmount = totalAmount-paidAmount;
            }
            var discountAmount = (totalAmount*radioValue)/100;
            /*diduct discount % amount from total.*/
            var amountWithDisc = (totalAmount - discountAmount);

            $('#net-amount').html('Rs. '+amountWithDisc);
            $('#net-amount').closest('td').find('input').attr('value',amountWithDisc);
        }
    }
});

/*custom discount*/
$(document).on('blur','#custom_discount',function(){
    var customValue = $(this).val();
    var totalAmount = $('#total-amount').data('total');
    var netAmount = $('#net-amount').data('net');
    var paidAmount = $('#amount-paid').data('amtpaid');
    var transportFare = $('#total-transport-fare').data('totaltrnsprt');
    /*get discount amount*/
    if(customValue <=100){
        /*totalAmount - paidamount*/
        if(transportFare > 0){
            totalAmount =(totalAmount+transportFare)-paidAmount;
        }else{
            totalAmount = totalAmount-paidAmount;
        }
        var discountAmount = (totalAmount*customValue)/100;
        /*diduct discount % amount from total.*/
        var amountWithDisc = (totalAmount - discountAmount);

        $('#net-amount').html('Rs. '+amountWithDisc);
        $('#net-amount').closest('td').find('input').attr('value',amountWithDisc);

        /*remove validateion*/
        $(this).closest('.form-group').addClass('has-success');
        $(this).closest('.form-group').removeClass('has-error');
        $(this).closest('.form-group').find('.help-block').html('');
    }else{
        $(this).closest('.form-group').addClass('has-error');
        $(this).closest('.form-group').removeClass('has-success');
        $(this).closest('.form-group').find('.help-block').html('wrong %age entered');
    }

});

/*transport farre for form fee submission.*/
/*$(document).on('focusout','#transaction-transport_fare',function(){
    var transportFare = $(this).val();
    var discountAmt= $('#total-discount').data('totaldiscount');
    var total=0;
    //console.log(transportFare);


    $('input[id^="transaction-head-amount_"]').each(function(){
        var id= $(this).attr('id');
        var value =  $(this).val();
        total +=  parseInt(value);
    });

    //console.log(discountVal);
    //var splitValue = id.split("-");
    var masterAmount = (total);
    if(transportFare !=''){
        masterAmount = (masterAmount += parseInt(transportFare));
    }
    //masterAmount = (masterAmount -= parseInt(discountAmt));
    $('#transaction-amount').val(Math.round(masterAmount));
});*/


/*==============working days settings========*/

$(document).on('click','#workingdayid',function(){
    
        var id=$(this).data('get');
       // alert(id);
        var url=$(this).data('url');
        //var inputVl=$(this).val();
        //alert(inputVl);
      // alert(url);
        //return false;
       // var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data:{id:id},
            url: url,
            cache: false,
            success: function(html)
            {
              //  alert('success');
            
               // $(".floorAjax").html(html);
            } 
        });
        
    });
    
$(document).on('click','#workingdaystu',function(){
    
        var id=$(this).data('get');
       // alert(id);
        var url=$(this).data('url');
      // alert(url);
        //return false;
       // var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data:{id:id},
            url: url,
            cache: false,
            success: function(html)
            {
              //  alert('success');
            
               // $(".floorAjax").html(html);
            } 
        });
        
    });
    
/*==============end of working days settings========*/

/*================send sms to whole class ====== */

$(document).on('click','#smsStudentClass',function(){
   // alert('adsf');
    var classid=$(this).data('class');
    var group=$(this).data('group');
    var sectionid=$(this).data('section');
    var textarea=$('#smsWhole').val();
    var getUrl=$(this).data('url');
     //alert(getUrl);
    //return false;
   $.ajax({
            type: "POST",
            data: {classid:classid,group:group,sectionid:sectionid,textarea:textarea},
            url: getUrl,
            cache: false,
            success: function(result){
                console.log(result);
                $('#sucmsg').text(result);
                //$(".floorAjax").html(result);
                }
           });
        });

/*================end of send sms to whole class ====== */
     
/*========= get students agianst parent cnic====*/
    $(document).on('keypress','#input1',function(){
        var cnic=$(this).val();
        var branch=$(this).data('branch');
        var url=$(this).data('url');
        //alert(branch);
        //return false;
        $(".cnicDisplay").empty();
        $.ajax({
            type: "POST",
            dataType:"JSON",
            data: {cnic:cnic,branch:branch},
            url: url,
            cache: false,
            success: function(result){
              //console.log(result);
              
              //$('#displaychild').slideDown('slow');
              $('.cnicDisplay').html(result.viewtabl);
                }
           });
        //alert(cnic);
    });
/*========= end of get students */

/* get student challan*/
$(document).on('click','#gen-std-challan',function () {
    /*active class*/
    $('#fee-challan-std-list-gridview table tr').removeClass('active-class');
    $(this).closest('tr').addClass('active-class');
      
   var stuId = $(this).data('stud_id');
   var url = $(this).data('url');
    $('#challan-form-inner').empty();
    if(stuId){
        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: {stu_id:stuId},
            url: url,
            cache: false,
            success: function(data){
                //console.log(data.status);
                if(data.status==1){
                    $('#challan-form-inner').html(data.html);
                }

            }
        });
    }
});

/* promotion dep group on class*/
$(document).on('change','#class-id-promo',function () {

    var classId = $(this).val();
    var url     = $(this).data('url');
    if(classId !=''){
        $.ajax
        ({
            type: "POST",
            dataType: "JSON",
            data: {class_id:classId},
            url: url,
            cache: false,
            success: function(details)
            {
                if(details.type=='group'){
                    $("#group-id-promo").attr('disabled',false);
                    $("#section-id-promo").attr('disabled',true);
                    $("#group-id-promo").html('<option value="" readonly="">Select Section</option>');
                    $("#group-id-promo").html(details.html);
                }else{
                    $("#group-id-promo").html('<option value="" readonly="">Select Group</option>');
                    $("#group-id-promo").attr('disabled',true);
                    $("#section-id-promo").attr('disabled',false);
                    $("#section-id-promo").html(details.html);
                }

            }
        });
    }
});

/* promotion dep group on group*/
$(document).on('change','#group-id-promo',function () {
    var classId = $('#class-id-promo').val();
    var groupId = $(this).val();
    var url     = $(this).data('url');
    if(classId !=''){
        $.ajax
        ({
            type: "POST",
            dataType: "HTML",
            data: {class_id:classId,group_id:groupId},
            url: url,
            cache: false,
            success: function(html)
            {
                $("#section-id-promo").attr('disabled',false);
                $("#section-id-promo").html(html);
            }
        });
    }
});

/*btn promote student */
$(document).on('click','#btn-promote-std',function(e){
    e.preventDefault();
    var newClassId          = $('#class-id-promo');
    var newGroupId          = $('#group-id-promo');
    var newSectionId        = $('#section-id-promo');
    var currentClassForm    = $('#promote-student-list-form');
    var selectedStd         = $("input[name^='selection[']:checked");
    var selectedArr         = [];
    var currentCID          = currentClassForm.find('#class-id').val();
    var currentGID          = currentClassForm.find('#group-id').val();
    var currentSID          = currentClassForm.find('#section-id').val();
    var error = 0;
    var url                 =  $(this).data('url');
    var redUrl              =  $(this).data('redUrl');

    /*class validation*/
    if(newClassId.val() ==''){
        newClassId.closest('.form-group').addClass('has-error');
        newClassId.closest('.form-group').removeClass('has-success');
        newClassId.closest('.form-group').find('.help-block').html('Class is Required');
        error++;
    }else{
        newClassId.closest('.form-group').addClass('has-success');
        newClassId.closest('.form-group').removeClass('has-error');
        newClassId.closest('.form-group').find('.help-block').html('');
    }
    /*section validation*/
    if(newSectionId.val() =='' || newSectionId.val()=='Select Section'){
        newSectionId.closest('.form-group').addClass('has-error');
        newSectionId.closest('.form-group').removeClass('has-success');
        newSectionId.closest('.form-group').find('.help-block').html('Section is Required');
        error++;
    }else{
        newSectionId.closest('.form-group').addClass('has-success');
        newSectionId.closest('.form-group').removeClass('has-error');
        newSectionId.closest('.form-group').find('.help-block').html('');
    }

    /*checkbox*/
    if(selectedStd.length ==0){
        $("#success-alert").fadeTo(2000, 500).slideUp(600, function(){
            $("#success-alert").slideUp(600);
        });
        error++;
    }else{
        selectedStd.each(function(){
            selectedArr.push($(this).val());
        });
    }

    if(error > 0){
        return false;
    }else{
        var data={
            c_cid:currentCID,
            c_gid:currentGID,
            c_sid:currentSID,
            selected_students:selectedArr,
            new_cid:newClassId.val(),
            new_gid:newGroupId.val(),
            new_sid:newSectionId.val()
        }
        $.ajax
        ({
            type: "POST",
            dataType: "JSON",
            data: data,
            url: url,
            success: function(details)
            {
                if(details.status == 1){
                    window.location.href = details.returnUrl;
                }
            }
        });
    }

});


/*==== get stages on base of group salary start ==== */
$(document).on('change','.groups',function(){
        $('#employeeallowances-fk_allownces_id').empty();
        $('#employeedeductions-fk_deduction_id').empty();
         $('.alwnc').empty();
         $('.dedctns').empty();
        var id=$(this).val();
        var url=$(this).data('url');

        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".getstage").html(html);
            } 
        });
        
    });
    
$(document).on('change','#salarymain-fk_pay_stages',function(){
       // alert('adsf');
        var id=$(this).val();
        var url=$(this).data('url');
        var groups=$('.groups').val();
        
        //alert(groups);
       // alert(id);
       // alert(url);
       // return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: {groups:groups,id:id},
            url: url,
            cache: false,
            success: function(result)
            {
                //$(".getammount").html(html);
                $('#salarymain-basic_salary').val(result);                
            } 
        });
        
    });
    
$(document).on('change','.getstageamnt',function(){
       // alert('adsf');
        var id=$('#salarymain-fk_pay_stages').val();
        //alert(id);
        //return false;
        var url=$(this).data('url');
        
        //alert(groups);
       // return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $(".stageamnts").html(html);
            } 
        });
        
    });
    
$(document).on('change','#salarymain-fk_deduction_tpe',function(){
       // alert('adsf');
        
        $('#amountdisplay').show();
        var id=$('#salarymain-fk_pay_stages').val();
        var stage=$('#salarymain-fk_pay_stages').val();
        
        //alert(stage);
        //return false;
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: {stage:stage,id:id},
            url: url,
            cache: false,
            success: function(html)
            {
                console.log(html);
                $("#deductedamnt").val(html);
            } 
        });
        
    });
    
$(document).on('blur','#getdeductamnt',function(){
     // alert('adsfdadsf');
      //return false;
      var hideamnt=$('#deductedamnt').val();
       var url=$(this).data('url');
       //alert(url);
      // return false;
      var getdys=$(this).val();
     //alert(getdys);
      //return false;
        $.ajax
        ({
            type: "POST",
            data: {hideamnt:hideamnt,getdys:getdys},
            url: url,
            cache: false,
            success: function(html)
            {
                console.log(html);
                $(".deductnamnt").val(html);
            } 
        });
    });
    
$(document).on('blur','#salarymain-deduction_amount',function(){
      var deductionval=$(this).val();
      //var basicslry=$('#salarymain-basic_salary :selected').val();
     // var basicslry=$('#salarymain-basic_salary').find('option:selected').text();
      var basicslry=$('#salarymain-basic_salary').val();
      var bonusslry=$('#salarymain-bonus').val();
      var allownceslry=$('.getallownce').val();
      //alert(deductionval);
     // alert(bonusslry);
     // alert(allownceslry);
     if(bonusslry == ''){
        bonusslry=0;
     }
     
     //alert(bonusslry);
     var gross_pay = parseInt(basicslry) + parseInt(bonusslry) + parseInt(allownceslry) - parseInt(deductionval);
     //alert(gross_pay);
     $('#salarymain-gross_salary').val(gross_pay);
     //Math.round(gross_pay);
      
     });
     
$(document).on('change','#salarymain-fk_tax_id',function(){
        //alert('asdf');
      var gros=$('#salarymain-gross_salary').val();
      var tx=$(this).find('option:selected').text();
       
      //var tax=$('#salarymain-fk_tax_id').find('option :selected').text();
      //alert(tx);
     // var ttl_tax_amnt = parseInt(gros) * parseInt(tx) /100;
      var ttl_tax_amnt = parseFloat(gros) * parseFloat(tx) /100;
     // alert(ttl_tax_amnt);
      var rnd=Math.round(ttl_tax_amnt);
      $('#salarymain-tax_amount').val(rnd);


      var txtamnt=$('#salarymain-tax_amount').val();
      var absentdeduction=$(".absntdeduction").val();

      var ttl_tax_amntx = parseInt(gros) - parseInt(txtamnt) - parseInt(absentdeduction);
      $('#salarymain-salary_payable').val(ttl_tax_amntx);
    
     });
     
     // $(document).on('focus','#salarymain-tax_amount',function(){
     //    //alert('asdf');
     //  var gros=$('#salarymain-gross_salary').val();
     //  var txtamnt=$(this).val();
     //  var ttl_tax_amnt = parseInt(gros) - parseInt(txtamnt);
     //  //alert(gros);
     //  $('#salarymain-salary_payable').val(ttl_tax_amnt);
    
     // });

     function myClick() {
  setTimeout(
    function() {
      document.getElementById('div1').style.display='none';
      document.getElementById('div2').style.display='none';
    }, 5000);
}

//$(document).on('focus','#salarymain-salary_payable',function(){
$(document).on('change','#salarymain-fk_emp_id',function(){
    setTimeout(
    function() {

       // alert('asdf');
      var gros=$('#salarymain-gross_salary').val();
      var txtamnt=$('#salarymain-tax_amount').val();
      var absentdeduction=$(".absntdeduction").val();
      
      //alert(gros);
     /*if(txtamnt > 0){
      var ttl_tax_amnt = parseInt(gros) - parseInt(txtamnt) - parseInt(absentdeduction);


      }else{
          var ttl_tax_amnt = parseInt(gros) - parseInt(absentdeduction);
      }*/
          var ttl_tax_amnt = parseInt(gros) - parseInt(absentdeduction);

      //alert(gros);
      $('#salarymain-salary_payable').val(ttl_tax_amnt);
       }, 1000);
    
     });
     
     
$(document).on('click','.getAllownceTxt',function(){
       // alert('adsf');
        var id=$('#salarymain-fk_allownces_id').val();
       // alert(id);
        //return false;
        var url=$(this).data('url');
        
        //alert(url);
       // return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                $(".getallownce").val(result);
            } 
        });
        
 });
 
    
$(document).on('change','.getEmployee',function(){

        var id=$(this).val();
        var url=$(this).data('url');
        //alert(url);
        var dataString = 'id='+ id;
        getSalaryEmployee(url,id);

        
 });


function getSalaryEmployee(url,emp_id){
        //alert('adsfaf');
        var id=emp_id;
        var url=url;
       // alert(url);
        
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            data: dataString,
            url: url, 
            success: function(detail)
            {
                console.log(detail.salaryView);
                //alert('adf');
                //var html=eval(detail.viewsalary);
               // console.log(html.find('#totalAllownce').html());
               //$('#basic').val(detail.basic);
               $("#getBscs").html(detail.salaryView);
               $("#salarymain-gross_salary").val(detail.gros);
               $("#salarymain-fk_pay_stages").val(detail.stageId);
               $("#salarymain-basic_salary").val(detail.basics);
               $('.showExist').html(detail.exist);

                /*$('.showExist').html(detail.exist);
                $('#salarymain-gross_salary').val(detail.viewsalary.gros_salary);
                $('.displayallownces').html(detail.viewsalary);
                $(".getStage").val(detail.stage);
                $(".getGroup").val(detail.group);
                $("#salarymain-basic_salary").val(detail.salary);
                $(".getAllownce").val(detail.allownce);
                $(".getAllownceTxt").val(detail.getAllownceTxt);
                $(".getStageId").val(detail.stageid);
                $(".getGroupid").val(detail.groupid);*/
            } 
        });
    }



    

    
    

$(document).on('change','#employeepayroll-fk_pay_stages',function(){
        $('.calculateNet').show();
        var id=$(this).val();
        $('#getBasicSalary').show();
        //alert(id);
      // return false;
        var url=$(this).data('url');
        
        //alert(url);
        //return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result.amnt);
               // $(".stagadiv").text(result.title);
               // $(".getstageamount").val(result.ammount);

                $("#employeeallowances-fk_allownces_id").html(result.html);
                $("#employeedeductions-fk_deduction_id").html(result.sal);
                $("#getBscSalry").val(result.amnt);
               

                
            } 
        });
        
 });



/* get deduction in empl form */
   

    function getDeduction(url,id,gettotalAlwnc){
        $('.calculateNet').show();
        var id=id;
        var url=url;
        var gettotalAlwnc=gettotalAlwnc;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            //data: dataString,
            data:{id:id,gettotalAlwnc:gettotalAlwnc},
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                $(".dedctns").html(result.viewtables);
            } 
        });
        }


        
        /* end of get deduction in empl form */

$(document).on('change','#employeeallowances-fk_allownces_id',function(){
        // $('.alwnc').empty();
        //$('.alwnc').show();
        //alert('adsfaf');

        //$(".alwnc").empty();
        var deductid=$('.deduct').val();
        var alwncid=$(this).val();
        //  alert(alwncid);
        var stageid= $('#employeepayroll-fk_pay_stages').val();
        var url=$(this).data('url');

       /* if(alwncid == null && deductid == null){
        $(".alwnc").empty();
            
        }else{
              allownce(url,stageid,alwncid,deductid);
        }*/
        //alert(stageid);
       // var dataString = 'id='+ id;
        allownce(url,stageid,alwncid,deductid);
      }); 

$(document).on('change','.deduct',function(){
        // $('.dedctns').empty();
       // $('.calculateNet').show();
        var alwncid=$('#employeeallowances-fk_allownces_id').val();

        var stageid= $('#employeepayroll-fk_pay_stages').val();
        var deductid=$(this).val();
        var url=$(this).data('url');
       // alert(url);
        //var dataString = 'id='+ id;
        allownce(url,stageid,alwncid,deductid);
       });

    

        function allownce(url,stageid,alwncid,deductid){
           // alert('adfadf');
        $('#getBasicSalary').hide();
        //$(".alwnc").empty();
        //s$('.dedctfee-plan-idns').empty();
        var url=url;
        var stageid=stageid;

        var alwncid=alwncid;
        var deductid=deductid;
        //alert(stageid);

        
        //var dataString = 'id='+ id;
       // alert(url);
        
        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: {alwncid:alwncid,deductid:deductid,stageid:stageid},
            url: url,
            cache: false,
            success: function(result)
            {
                //alert('success');
                $(".alwnc").html(result.viewtable);
                $("ul").find("span");
                var getPasNet=$('#netAmntPassTotal').val();
                //alert(getPasNet);

                $('#payrollTotalAmount').val(getPasNet);
                $('#calculateNet').hide();
                var empBassicsal=$('#emplBasicSal').val();
                $('#getBscSalry').val(empBassicsal);

                var countTtlAlwn=$('#totalAlwnxes').val();
                $('#getTotalAlwnx').val(countTtlAlwn);

                var countTtlDed=$('#pasTotlDeductn').val();
                $('#getTotalDedcx').val(countTtlDed);

                //alert(countTtlAlwn);





                //var getPasNetNotDeduct=$('#getalownceamount').val();
               // $('#payrollTotalAmountAllownceNotDeduct').val(getPasNetNotDeduct);


               // alert(getPasNetNotDeduct);
                //console.log(result)
                //$(".stagadiv").text(result.title);
                //$(".alwnc").html(result.viewtable);
            } 
        });
    }

$(document).on('click','.getstageamount',function(){
    $('.tlt').show();
        var stg=$(this).val();
        var alwnc=$('.getalwncamnt').val();
        var ded =$('#employeesalarydeductiondetail-amount').val();
        var sm=parseInt(stg) + parseInt(alwnc) - parseInt(ded);
        $('.ttl').val(sm);

        //alert(sm);
        
 });

$(document).on('click','#getTotalNet',function(){

        var getalwncamnt=$('#getalownceamount').val();
        
        var getdeductnamnt=$('#getdeductionamount').val();
        //alert(getdeductnamnt);
        var net= parseInt(getalwncamnt) - parseInt(getdeductnamnt);
        //alert(net);
        var asign =$('#getnetamount').html(net);
        
        
 });

$(document).on('click','#salarymain-gross_salary',function(){

        var id=$(this).val();
        //alert(id);
        var getStageVal=$('#getStageId').val();
        var getAlwnc=$('#totalAllownce').val();
        var getDeductin=$('#totalDeduction').val();
        $('#salarymain-deduction_amount').val(getDeductin);

        var getBasicSal=$('#getBasicSalary').val();
        $('#salarymain-basic_salary').val(getBasicSal);

        var getgros=$('#grosssalaary').val();
       // var getgrosAddBonus=parseInt(id) + parseInt(getgros);

        $('#salarymain-gross_salary').val(getgros);

        $('#salarymain-fk_pay_stages').val(getStageVal);
        $('#salarymain-allownces_amount').val(getAlwnc);
        return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            //dataType:'JSON',
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                //$(".stagadiv").text(result.title);
                $("#getwarden").html(result);
            } 
        });
        
 });

/*========= end of salary scripts==  */

/*=== transport ==*/

$(document).on('change','.departmentTransport',function(){
        var id=$(this).val();
        //alert(id);
      // return false;
       var url=$(this).data('url');
        
        //alert(url);
        //return false;
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            //dataType:'JSON',
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                //$(".stagadiv").text(result.title);
                $("#getwarden").html(result);
            } 
        });
        
 });

$(document).on('change','.zoneDepend',function(){
        var id=$(this).val();
       
       var url=$(this).data('url');
        
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                //$(".stagadiv").text(result.title);
                $(".getRout").html(result.html);
            } 
        });
        
 });

$(document).on('change','.departmentDesignation',function(){
        var id=$(this).val();
       
       var url=$(this).data('url');
       //alert(url);
        
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            //dataType:'JSON',
            data: dataString,
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result)
                //$(".stagadiv").text(result.title);
                $(".getDesignation").html(result);
            } 
        });
        
 });

$(document).on('click','#classesCreate',function(){
        var rows=$("#pasval").val();
        var url=$("#pasval").data('url');
        var status=$("#statuscreate").val();

        

        /* var countInput=$('#inputClas').map( function(){
                 return $(this).val(); 
                }).get();*/
               //alert(countInput);
               //$("#inputClas > div").length;
                

        var cls=$('.classex').map( function(){
                 return $(this).val(); 
                }).get();
         // alert(status);
        //alert(url);

        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: {rows:rows},
            url: url,
            cache: false,
            success: function(result)
            {   
               // console.log(result.views)
               //$(".shows").append(result.views); 
                if(status == 'create'){
                   $(".shows").html(result.views);
                         }else{
                    $(".shows").append(result.views);
                            
                              }
                //$(".getDesignation").html(result);
            } 
        });
        
 }); 

$(document).on('keypress','.classex',function(){
    //alert('press');
    $("#sameclass").empty();
});

$(document).on('keypress','.mode',function(){
    //alert('press');
    $("#samefeeplan").empty();
});

$(document).on('keypress','.headss',function(){
    //alert('press');
    $("#sameHeads").empty();
});


$(document).on('change','#feegroup-fk_fee_head_id',function(){
    //alert('press');
    $("#feeError").empty();
});



$(document).on('keypress','#feegroup-amount',function(){
    //alert('press');
    $("#amountError").empty();
});



$("#timer").click(function() {
    //var status= ("#status").val();
//$("#duplicater").append("<br />");
$("#duplicater").append('<input type="text" name="RefClass[title][]" class="form-control classex" id="inputClas" /><br />');
//linebreak = document.createElement("br");

});


$("#feePlanCreate").click(function() {
  
$("#feePlanCreateduplicater").append('<input type="text" name="FeePaymentMode[title][]" class="form-control mode">');
$("#feePlanCreateduplicaterMonthly").append('<select id="feepaymentmode-time_span" name="FeePaymentMode[time_span][<?php echo $key;?>]" class="form-control timespan"><option value="">Select No. of month(s)</option><option value="1">1 month</option><option value="2">2 months</option><option value="3">3 months</option><option value="4">4 months</option><option value="5">5 months</option> <option value="6">6 months</option><option value="7">7 months</option><option value="8">8 months</option><option value="9">9 months</option><option value="10">10 months</option> <option value="11">11 months</option>  <option value="12">12 months</option></select>'); 

});

$("#assignfeeplan").click(function() {
  
$("#assignfeeplanTitle").append('<input type="text" name="FeePlanType[title][]" class="form-control typesfee">');
$("#assignfeeplanInstallments").append('<select id="feeplantype-no_of_installments" name="FeePlanType[no_of_installments][<?php echo $key; ?>]" class="form-control instal"><option value="">Select Installments</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>'); 

});



$(document).on('click','#feeHeadsCreatenew',function(){
        var url=$(this).data('url');
         var rows=$("#feeheads").val();
       // alert(url);
        var branch=$('.branch_input').val();
        //var branch=2;
$("#feeHeadsCreateduplicater").append('<input type="text" name="feeheads-title[]" class="form-control headss">');

        //alert(rows);

        $.ajax
        ({
            type: "POST",
           // dataType:'JSON',
            data: {branch:branch,rows:rows},
            url: url,
            cache: false,
            success: function(data)
            {
                console.log(data)
                $("#FeeheadsuplicaterMonthly").append('<select class="form-control fee_modes" name="FeeHeads[fk_fee_method_id]">'+data+'</select>');


                   // var toAppend = '';
                   // $.each(data,function(i,o){
                   // toAppend += '<option>'+o.id+'</option>';
                   // });

                   // $('#FeeheadsuplicaterMonthly').append(toAppend);
                
                //$(".fee_modes").append($("<option></option>").val(3).html("Three"));
            } 
        });
        
 });



/*$(function() {
$("#timer").click(function() {
$("#duplicater").append('<input type="text" name="RefClass[title][]" class="form-control classex" id="inputClas" />');

    function counter()  {  
        var i = 10;
        $("#duplicater").append('<input type="text" name="RefClass[title][]" class="form-control classex" id="inputClas" />')
        function showDIV() {
            
        if (i < 0)
            return 
        setTimeout(showDIV, 1000);
        $("#span").text(i);
        i--;        
        
    }
        
    showDIV();
}
counter(10);
});*/

//});


/*$(document).on('click','#classesCreatex',function(){

var i = 0;
var original=$("#duplicater");
var clone = original.cloneNode(true); // "deep" clone
    clone.id = "duplicater" + ++i; // there can only be one element with an ID
    original.parentNode.appendChild(clone);
 });*/


$(document).on('click','#feemodxx',function(){
        var rows=$("#feemode").val();
        var url=$("#feemode").data('url');
        var status=$("#statuscreatemode").val();
        //alert(rows);

        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: {rows:rows},
            url: url,
            cache: false,
            success: function(result)
            {
                //console.log(result.views)
                //$(".femode").append(result.views);
                //$(".getDesignation").html(result);
                 if(status == 'create'){
                  $(".femode").html(result.views);
                   
                         }else{
                  $(".femode").append(result.views);
                   
                             }
            } 
        });
        
 });

$(document).on('click','#feeheadxx',function(){
        var rows=$("#feeheads").val();
        var url=$("#feeheads").data('url');
        var branch=$('#wizard-p-1 .branch_input').val();
        var status=$("#statuscreateheads").val();
        var feeHdeadNum = $("#feeheads").val();
        var feeHeads = $('#wizard-p-3 .feeHeads');
        var feeModes = $('#wizard-p-3 .fee_modes');

        $.ajax
        ({
            url: url,
            type: "POST",
            dataType:'json',
            data: {rows:rows,branch:branch},
            cache: false,
            async: false,
            success: function(result)
            {       
                feeHdeadNum = parseInt(feeHdeadNum);
                let innerHTML = '';

                if(feeHdeadNum > 0)
                {
                    for(let i = 0; i < feeHdeadNum; i++)
                    {
                        innerHTML += '<div>';
                        innerHTML += '<div class="row">';
                        innerHTML += '<div class="col-md-6">';
                        innerHTML += '<br>';
                        innerHTML += '<input type="text" name="feeheads-title[]" class="form-control headss">';
                        innerHTML += '</div><br>';
                        innerHTML += '<div class="col-md-6">';
                        innerHTML += '<select class="form-control fee_modes" name="FeeHeads[fk_fee_method_id]['+ i +']">';
                        innerHTML += result.branch;
                        innerHTML += '</select>';
                        innerHTML += '</div>';
                        innerHTML += '</div>';
                        innerHTML += '</div>';

                    }
                }
                   
                if(status == 'create')
                    feeHeads.html(innerHTML);
                else
                    feeHeads.append(innerHTML);
                //$(".fee_modes").append($("<option></option>").val(3).html("Three"));
            } 
        });
        
 });

$(document).on('blur','#branch-name',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bname').text("Name cannot be blank");
    }else{
        $('.bname').text("");
       // $("#bnames").removeClass("bname");
    }
});

$(document).on('blur','#branch-description',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bdescription').text("description cannot be blank");
    }else{
        $('.bdescription').text("");
       // $("#bnames").removeClass("bname");
    }
});    

$(document).on('keypress','#branch-zip',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bzip').text("zip cannot be blank");
    }else{
        $('.bzip').text("");
       // $("#bnames").removeClass("bname");
    }
});





$("#branch-fk_country_id").change(function(){
    //alert('adsf');
var countryname = $(this).val();
//alert(countryname);
if(countryname == "")
{
$(".bcountry").text("country cannot be blank");
}else{
$(".bcountry").text("");

}
});

$(document).on('change','#branch-fk_province_id',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bprovince').text("Province cannot be blank");
    }else{
        $('.bprovince').text("");
       // $("#bnames").removeClass("bname");
    }
});

$(document).on('change','#branch-fk_province_id',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bprovince').text("Province cannot be blank");
    }else{
        $('.bprovince').text("");
       // $("#bnames").removeClass("bname");
    }
});

$(document).on('change','#branch-fk_district_id',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bdistrict').text("district cannot be blank");
    }else{
        $('.bdistrict').text("");
       // $("#bnames").removeClass("bname");
    }
});

$(document).on('change','#branch-fk_city_id',function(){
    var name=$(this).val();

    if(name == ''){
        $('.bcity').text("city cannot be blank");
    }else{
        $('.bcity').text("");
       // $("#bnames").removeClass("bname");
    }
});


  

$(document).on('click','#feeplantypx',function(){
        var rows=$("#planType").val();
        var url=$("#planType").data('url');
        var status=$("#statuscreateplanType").val();
       // alert(status);

        $.ajax
        ({
            type: "POST",
            dataType:'JSON',
            data: {rows:rows},
            url: url,
            cache: false,
            success: function(result)
            {
               // console.log(result.views)
               if(status == 'create'){
                $(".showFeeType").html(result.views);

               }else{
                $(".showFeeType").append(result.views);

               }
                //$(".showFeeType").append(result.views);
                //$(".getDesignation").html(result);
            } 
        });
        
 });



// student search show fields

/*$(document).on('click','.contactNo',function(){
 
   $('.contactClass').show();
   $('.contactClassHeader').show();
});*/

$('.contactNo').change(function() {
   if($(this).is(":checked")) {
    $('.classcntct').val(2);

      $('.contactClass').show();
      $('.contactClassHeader').show();
   }else{
    $('.classcntct').val(1);

    $('.contactClass').hide();
    $('.contactClassHeader').hide();
   }
  
});

$('.regno').change(function() {
   if($(this).is(":checked")) {
    $('.regclass').val(2);

      $('.regClass').show();
      $('.regClassHeader').show();
   }else{
    $('.regclass').val(1);

    $('.regClass').hide();
    $('.regClassHeader').hide();
   }
  
});

$('.dob').change(function() {
   if($(this).is(":checked")) {
    $('.dobclass').val(2);

      $('.dobClass').show();
      $('.dobClassHeader').show();
   }else{
    $('.dobclass').val(1);

    $('.dobClass').hide();
    $('.dobClassHeader').hide();
   }
  
});


$('.classgroup').change(function() {
   if($(this).is(":checked")) {
    $('.grpclass').val(2);

      $('.groupClass').show();
      $('.groupClassHeader').show();
   }else{
    $('.grpclass').val(1);

    $('.groupClass').hide();
    $('.groupClassHeader').hide();
   }
  
});
$('.sectionClass').change(function() {
   if($(this).is(":checked")) {
    $('.sectinclass').val(2);

      $('.sectionClasses').show();
      $('.sectionClassHeader').show();
   }else{
    $('.sectinclass').val(1);

    $('.sectionClasses').hide();
    $('.sectionClassHeader').hide();
   }
  
});

$('.classclass').change(function() {
   if($(this).is(":checked")) {
    $('.inputclass').val(2);

      $('.classClass').show();
      $('.classClassHeader').show();
   }else{
    $('.inputclass').val(1);
    $('.classClass').hide();
    $('.classClassHeader').hide();
   }
  
});

$('.classparentname').change(function() {
   if($(this).is(":checked")) {
      $('.parntclass').val(2);
      $('.parntClass').show();
      $('.parntClassHeader').show();
       }else{
        $('.parntclass').val(1);
        $('.parntClass').hide();
        $('.parntClassHeader').hide();
       }
  
});


$('.classfullname').change(function() {
   // alert('adsfdf');
   if($(this).is(":checked")) {
    $('.thisinputname').val(2);
      $('.fullnameClass').show();
      $('.fullnameClassHeader').show();
   }else{
    $('.thisinputname').val(1);

    $('.fullnameClass').hide();
    $('.fullnameClassHeader').hide();
   }
  
});

$('.addressclass').change(function() {
   if($(this).is(":checked")) {
    $('.adrsclass').val(2);

      $('.addressClass').show();
      $('.addressClassHeader').show();
   }else{
    $('.adrsclass').val(1);

    $('.addressClass').hide();
    $('.addressClassHeader').hide();
   }
  
});

/*$('.searchShow').click(function() {
   //if($('.contactNo').is(":checked")) {
      //'checked' event code
      $('.contactClass').show();
      $('.contactClassHeader').show();
  // }
   //'unchecked' event code 
});*/

// end of student search show fields




$(document).on('click','.classpdf',function(){
        //var rows=$(this).val();
        var url=$(this).data('url');
        var classval     = $('.classval').val();
        var inputhid= $('.thisinputname').val();
        var parntclass= $('.parntclass').val();
        var inputclass= $('.inputclass').val();
        var grpclass= $('.grpclass').val();
        var sectinclass= $('.sectinclass').val();
        var dobclass= $('.dobclass').val();
        var regclass= $('.regclass').val();
        var adrsclass= $('.adrsclass').val();
        var classcntct= $('.classcntct').val();
        //alert(thisinputname);
        var attrname = $(this).attr('name'); 
        //alert(classval);

       if(attrname =='Generate Report'){
        window.location.replace(url+"?classval="+classval+"&inputhid="+inputhid+"&parntclass="+parntclass+"&inputclass="+inputclass+"&grpclass="+grpclass+"&sectinclass="+sectinclass+"&dobclass="+dobclass+"&regclass="+regclass+"&adrsclass="+adrsclass+"&classcntct="+classcntct);

        }
        
 });

$(document).on('click','.sectionpdf',function(){
        //var rows=$(this).val();
        var url=$(this).data('url');
        var classval     = $('#classval').val();
        var groupval= $('#groupval').val();
        var sectionval= $('#sectionval').val();
        //alert(thisinputname);
        var attrname = $(this).attr('name'); 
        //alert(classval);

       if(attrname =='Generate Report'){
        window.location.replace(url+"?classval="+classval+"&groupval="+groupval+"&sectionval="+sectionval);

        }
        
 });

/*================ section pdf*/
/*================ end of section pdf*/




$(document).on('click','.classNamepdf',function(){
        //var rows=$(this).val();
        var url=$(this).data('url');
        var getinput     = $('.hiddenPassvalue').val();
        var classval     = $('.classval').val();
        var attrname = $(this).attr('name'); 
        var getVal       = $('.passVal').val();

        var inputhid= $('.thisinputname').val();
        var parntclass= $('.parntclass').val();
        var inputclass= $('.inputclass').val();
        var grpclass= $('.grpclass').val();
        var sectinclass= $('.sectinclass').val();
        var dobclass= $('.dobclass').val();
        var regclass= $('.regclass').val();
        var adrsclass= $('.adrsclass').val();
        var classcntct= $('.classcntct').val();
        //alert(classval);

       if(attrname =='Generate Report'){
          window.location.replace(url+"?getVal="+getVal+"&getinput="+getinput+"&inputhid="+inputhid+"&parntclass="+parntclass+"&inputclass="+inputclass+"&grpclass="+grpclass+"&sectinclass="+sectinclass+"&dobclass="+dobclass+"&regclass="+regclass+"&adrsclass="+adrsclass+"&classcntct="+classcntct);
        }
        
 });  






 $(document).on('focusout','#registerationemployee',function () {
    //alert('adf');
   var value =$(this).val();
   var url =$(this).data('url');
    var inputDetail= $(this);
    if(value != ''){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            data: {username:value},
            url: url,
            cache: false,
            success: function(data)
            {

                if(data.status == 1){
                    if(data.detail == 1 || data.detail >1){
                        inputDetail.closest('.form-group').addClass('has-error');
                        inputDetail.closest('.form-group').removeClass('has-success');
                        inputDetail.closest('.form-group').find('.help-block').html('Employee with this registration Already Exists.');
                    }else{
                        inputDetail.closest('.form-group').addClass('has-success');
                        inputDetail.closest('.form-group').removeClass('has-error');
                        inputDetail.closest('.form-group').find('.help-block').html('');
                    }
                }
            }
        });
    }
});  





$(document).on('change','#salarymain-salary_month',function () {
        
     //$('.showExist').remove();
     var date=$(this).val();  
     var empid=$("#fk_emp_id").val();
     var url= $('#slrymonthcalendar').data('url');
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {date:date,empid:empid},
        success: function(data)
        {
                console.log(data.compredate)
                //$(".getEmployees").html(data.department);
                $('.showExist').html(data.compredate);


        }
    });
    //alert(url);

});

 /* get employee for salary deparment */


 $(document).on('change','#departmentSalary',function () {
        
        
        var id=$(this).val();
        //$('#thisss').show();
        var url=$(this).data('url');
        var dataString = 'id='+ id;

   
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: dataString,
        success: function(data)
        {
                //console.log(data.department)
                $(".getEmployees").html(data.department);


        }
    });

});



$(document).on('click','#salaryPayShow',function(){
    
     var url=$(this).data('url');
     var empid=$(this).data('empid');

   
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {empid:empid},
        success: function(data)
        {
               // console.log(data.payrollView)
                $("#showsalarypay").html(data.payrollView);



                 var hiredatesalry=$(".hiredateslry").val();

                 if(hiredatesalry == undefined){
                 var gros=$('#salarymain-gross_salary').val();
                 var txtamnt=$('#salarymain-tax_amount').val();
                 var absentdeduction=$(".absntdeduction").val();
                 var ttl_tax_amnt = parseInt(gros) - parseInt(absentdeduction);

                 $('#salarymain-salary_payable').val(ttl_tax_amnt);

                 }else{
                 $('#salarymain-salary_payable').val(hiredatesalry);
                        

                 }
                


                 
                 $('.showExist').html(data.exist);
                 


        }
    });

 });

function checkEmail(str)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(str))
    //alert("Please enter a valid email address");
    $('.bemail').text('(Please enter a valid email address)');
}


$(document).on('click','#submitpayroll',function () {
        var emp_id=$('#fk_emp_id').val();
        var fk_pay_stages=$('#fk_pay_stages').val();
        var basic_salary=$('#basic_salary').val();
        var gross_salary=$('#gross_salary').val();
        var tax_id=$('#salarymain-fk_tax_id').val();
        var tax_amount=$('#salarymain-tax_amount').val();
        var salary_payble=$('#salarymain-salary_payable').val();
        var salary_month=$('#salarymain-salary_month').val();
        var salary_date=$('#salarymain-payment_date').val();
        var absntdeduction=$('.absntdeduction').val();
        var afterallowed=$('#afterallowed').val();
        var url=$(this).data('url');

        $(this).hide();

         //var urls = $("#anothers").data('urls');
              //  alert(urls);
       // alert(url);
       // return false;

   
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {emp_id:emp_id,fk_pay_stages:fk_pay_stages,basic_salary:basic_salary,gross_salary:gross_salary,tax_id:tax_id,tax_amount:tax_amount,
            salary_payble:salary_payble,salary_month:salary_month,salary_date:salary_date,absntdeduction:absntdeduction,afterallowed:afterallowed},
        success: function(data)
        {
            //console.log(data.errors);
            if($data.erros){
                //$("#sucessubmit").show();
                $("#erros").html(data.errors);
            }else{
                $("#sucessubmit").show();
                $("#sucessubmit").html('Salary Successfully Issued..!');
            }
                
               


        }
    });

});



/*$(document).on('click','.submitpayroll',function(){
        //var rows=$(this).val();
          var url=$(this).data('urls');
          alert(url);
          return false;
          var id=$('#fk_emp_id').val();
         var attrname = $(this).attr('name'); 
        //alert(classval);

       if(attrname =='Generate Report'){
          window.location.replace(url+"?id="+id);
        }
        
 }); */
 
 /* end of get employee for salary deparment */




 /*$(document).on('click','#monthly-challan-generator-salary',function () {
    alert('adsfaf');
    var formGenerator = $('#gen-fee-challan-salary');
    var newForm       = $('#generate-monthly-challan-form-salary');

    newForm.append('<input type="hidden" name="class_id" value="'+formGenerator.find("#dep-id").val()+'"/>');
    
    newForm.submit();
    return false;
});*/

 /*exam in profile  on click*/

$(document).on('click','#std-profile-exam',function(){
   var examId = $(this).data('examid');
   var url = $(this).data('url');
   var stdid = $(this).data('stdid');
   var classid = $(this).data('classid');
   var groupid = $(this).data('groupid');
   var sectionid = $(this).data('sectionid');
   var examdivid = $(this).data('examdivid');
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {examId:examId,classid:classid,groupid:groupid,sectionid:sectionid,stdid:stdid,examdivid:examdivid},
        success: function(data)
        {
            //console.log(data.errors);
            if(data.status == 1){
                $('div#'+examdivid).html(data.details);
                var chart = $('#exam-result-container').highcharts();
                if(Object.keys(chart.series).length > 0) {
                    var seriesLength = chart.series.length;
                    for (var i = seriesLength - 1; i > -1; i--) {
                        chart.series[i].remove();
                    }
                }
                /*console.log(result.total_subjects);*/
                //chart.xAxis[0].setCategories(result.data.piExamArr);

                    chart.addSeries({
                        type: 'pie',
                        name: 'Marks',
                        data: data.piExamArr
                    });
                    chart.redraw();
                $('#pigraph-cointainer').show();
                    // URL to Highcharts export server


            }
        }
    });
});

/*on click of discout modal*/
$(document).on('click','#discount-modal',function () {
    var headId       = $(this).data('head_id');
    var headAmount   = $(this).data('head_amount');
    var headName     = $(this).data('head_name');

    /*remove validation*/
    $('#head-amount').closest('.form-group').addClass('has-success');
    $('#head-amount').closest('.form-group').removeClass('has-error');
    $('#head-amount').closest('.form-group').find('.help-block').html('');
    /*empty amount field*/
    $('#head-amount').val('');
    $('input#hidden-head-id').val(headId);
    $('input#hidden-head-amount').val(headAmount);
    $('#head-name').html(headName);


});

/*================send sms to whole school ====== */
$(document).on('click', '#sms_to_branch', function() {
    var smsModal = $('#sendsmsWhole');
    $('div').removeClass('has-error');
    smsModal.modal();
});

$(".loading").hide();

$(document).on('click','#sendsmsWholeschools',function(){
    var textarea = $('#smsWholeSchool').val();
    var getUrl=$(this).data('url');

    if(textarea == '') {
        $('#smsWholeSchool').parent().addClass('has-error');
        return false;
    }
    $('#sendsmsWhole').hide();
    $(".loading").css('top', '0px').show();
    $.ajax({
        type: "POST",
        data: {textarea:textarea},
        url: getUrl,
        success: function(success){
            if(success){
                $(".loading").hide();
            }
        }
    });
});

$(document).on('click', '#sms_record_link', function() {
    var num = $(this).data('number');
    $('#sendsmsRcordNum').find('.modal-title b').text(num);
    $('#sendsmsRcordNum').modal();
});

/*================end of send sms to whole school ====== */


/*extra fee head is active hide the rest options.*/
$(document).on('click','input[name="FeeHeads[extra_head]"]',function(){
   var value = $('input[name="FeeHeads[extra_head]"]:checked').val();
    if(value == 1){
        $('#extra_head').slideUp();
    }else{
        $('#extra_head').slideDown();
    }
});


/*================Hostel Bed ====== */

$(document).on('change','#hosteldetail-fk_bed_id',function(){
   // alert('adsf');
    var bedid=$(this).val();
    var roomid=$('#hosteldetail-fk_room_id').val();
    var url=$("#bedurl").data('url');
    // alert(bedid);
    // alert(roomid);
    // alert(url);
   // return false;
   $.ajax({
            type: "POST",
            dataType:"JSON",
            data: {bedid:bedid,roomid:roomid},
            url: url,
            cache: false,
            success: function(result){
                console.log(result.assign);
                $('#bedasign').text(result.assign);
                //$(".floorAjax").html(result);
                }
           });
        });

/*================end of Hostel Bed ====== */



/*========== section analysis =========*/

$(document).on('click','.studentdetails',function(){
    $(".sectionpdf").show();
    $(".examdetails").hide();
    $(".subjectsclas").hide();


});

$(document).on('click','.analysis-exams',function(){
    $(".examdetails").show();
    $(".sectionpdf").hide();
    $(".subjectsclas").hide();


});

$(document).on('click','.class-subjects',function(){
    $(".sectionpdf").hide();
    $(".examdetails").hide();
    $(".subjectsclas").show();


});
$(document).on('click','.attendance-detail',function(){

    $(".sectionpdf").hide();
    $(".examdetails").hide();
    $(".subjectsclas").hide();


});





$(document).on('click','.examdetails',function(){
    var name=$(this).attr('name');
    var classval     = $('#classval').val();
    var groupval= $('#groupval').val();
    var sectionval= $('#sectionval').val();
    var url=$(this).data('url');
    if(name == 'Generate Report'){
      window.location.replace(url+"?classval="+classval+"&groupval="+groupval+"&sectionval="+sectionval);  

    }

});


$(document).on('click','.subjectsclas',function(){
    var name=$(this).attr('name');
    var classval     = $('#classval').val();
    var groupval= $('#groupval').val();
    var sectionval= $('#sectionval').val();
    var url=$(this).data('url');
    if(name == 'Generate Report'){
      window.location.replace(url+"?classval="+classval+"&groupval="+groupval+"&sectionval="+sectionval);  

    }

});
/*========== end of section analysis =========*/
$(document).on('change','#section-id-shuffle',function () {
    //alert('adf');
   var sectionId = $(this).val();
   var classId = $('#class-id').val();
   var groupId = $('#group-id').val();
   var url = $(this).closest('.col-sm-4').find('#subject-urls').val();

    $("#subject-inner").empty().append("<div id='loading'><img  class='loading-img-set' src='../img/loading.gif' alt='Loading' /></div>");
    if(groupId ==''){ 
        groupId=null;
    }
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {class_id:classId,group_id:groupId,section_id:sectionId},
        success: function(data)
        {
            if(data.status== 1){
                $("#subject-inner").empty().html(data.details);
                //$('#subject-details').html();
            }


        }
    });

}); 
