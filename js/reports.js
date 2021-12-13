/**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 20/2/2017.
 * reports.js
 * for reports related js.
 */


$(document).ready(function() {
  $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
    e.preventDefault();
    $(this).siblings('a.active').removeClass("active");
    $(this).addClass("active");
    var index = $(this).index();
    var url  =  $(this).attr('href');
    //alert(url);
    /*ajax call*/
    if(index != 0){
      $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: $('#exam-form').serialize(),
        success: function(data)
        {
         // $("#getTransport").html(data.viewtransport);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
    }


    $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
    $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
  });
});

/*show overall student attendance*/
$(document).on('click','#overallAtt',function(){

 $('#displayclasses').hide();
 $('.submitcls').hide();
 $('.submitAttendance').show();
 $('#displayGrps').hide();
 $('#overallsGrps').empty();
 $('.submitgrps').hide();

 $('#clasdisplay').hide();
 $('#grpdisplay').hide();
 $('#sectnx').hide();

 $('#overallsCls').empty();

 $('.fee-gen').hide();


 });

$(document).on('click','#other',function(){
 $('#clasdisplay').show();
 $('#grpdisplay').show();
 $('.submitcls').show();
 $('.submitAttendance').hide();
 $('#displayGrps').hide();
 $('#overallsGrps').empty();
 $('.submitgrps').hide();
 $('#overallsCls').empty();
 $('#sectnx').show();

 $('#overalls').empty();

 $('.fee-gen').show();

 });


$(document).on('change','#class-id',function(){

       // alert('sadf');
        var id=$(this).val();
        var group_id=$('#group-id').val();
        //alert(id);
        var url=$(this).data('url');
        //alert(url);
        //var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",

            data: {id:id,group_id:group_id} ,
            url: url,
            cache: false,
            success: function(html)
            {
             // console.log(html);
                $("#group-id").html(html);
            } 
        });
        
    });

$(document).on('change','#group-id',function(){

       // alert('sadf');
        var id=$(this).val();
        //alert(id);
        var url=$(this).data('url');
        //alert(url);
        var dataString = 'id='+ id;
        //alert(dataString);
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $("#sections-id").html(html);
            } 
        });
        
    });



$(document).on('click','.submitAttendance',function(){
  var url=$(this).data('url');
  var start=$('#startDate').val();
  var end=$('#endDate').val();

  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {start:start,end:end},
        success: function(data)
        {
          //console.log(data);

          $("#overalls").html(data.overallview);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});


$(document).on('click','.submitcls',function(){
  var url=$(this).data('url');
  var start=$('#startDate').val();
  var end=$('#endDate').val();
  var cls=$('#class-id').val();
  var grp=$('#group-id').val();
  var sectn=$('#section-ids').val();
  //alert(url);


  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {start:start,end:end,cls:cls,grp:grp,sectn:sectn},
        success: function(data)
        {
          //console.log(data);

          $("#overallsCls").html(data.overallclass);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});

$(document).on('click','#submitgrps',function(){
  var url=$(this).data('url');
  var start=$('#startDate').val();
  var end=$('#endDate').val();
  var grp=$('#pasGrp').val();

  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {start:start,end:end,grp:grp},
        success: function(data)
        {
          //console.log(data);

          $("#overallsGrps").html(data.overallgrps);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});


/*  trnasport */

$(document).on('click','#paszonetoroute',function(){
  var url=$(this).data('url');
  var zoneid=$(this).data('zoneid');
  //alert(zoneid);

  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {zoneid:zoneid},
        success: function(data)
        {
        //  console.log(data);

          $(".showalltransport").html(data.zoneRoutes);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});

$(document).on('click','#pasroutetostop',function(){
  var url=$(this).data('url');
  var routeid=$(this).data('routeid');
  var zoneid=$(this).data('zoneid');
  //alert(zoneid);

  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {routeid:routeid,zoneid:zoneid},
        success: function(data)
        {
          //console.log(data);

          $(".showalltransport").html(data.stopRoutes);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});

$(document).on('click','#passtoptostudent',function(){
  var url=$(this).data('url');
  var stopid=$(this).data('stopid');

  //alert(zoneid);
  //$('#popup1').show();
  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {stopid:stopid},
        success: function(data)
        {
          //console.log(data);

          $("#modalContent").html(data.stuView);

          $('#modal').modal('show');


          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });

  

});


$(document).on('click','#zonebacktrack',function(){

var url=$('#zone').data('url');
//alert(url);
$.ajax
        ({
            type: "POST",
            dataType:"JSON",
            //data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
              //console.log(html.zonegenric);
                $(".showalltransport").html(html.zonegenric);
            } 
        });
});


$(document).on('click','#routebacktrack',function(){
  var url=$(this).data('url');
  var zoneid=$('#zoneId').val();
  //alert(zoneid);

  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {zoneid:zoneid},
        success: function(data)
        {
          //console.log(data);

          $(".showalltransport").html(data.zoneRoutes);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 

});




// start of finance
$(document).on('click','.cashflow',function(){
  var url=$(this).data('url');
  var start=$('#startDate').val();
  var end=$('#endDate').val();
  var attrname = $(this).attr('name'); 
  $("#cashflowCalendar").show();
  //alert(url);

  if(attrname =='Generate Report'){
      window.location.replace(url+"?start="+start+"&end="+end);
  }
  else{
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {start:start,end:end},
        success: function(data)
        {
          //console.log(data);

          $("#cashflowhere").html(data.cashflowhere);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
 
  }

});



$(document).on('change','#getStuClassWise',function(){
  var url=$(this).data('url');
  var id=$(this).val();
  $('.showStu').show();
  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {id:id},
        success: function(data)
        {
            $('#generate-std-ledger-pdf').hide();
            //console.log(data);
            $(".stu").html(data.studata);
        }
      });
 

});

/*another repoort at the end*/
$(document).on('change','#getAnotherStuClassWise',function(){
    var url=$(this).data('url');
    var id=$(this).val();
    $('.showStuAnother').show();
    $.ajax
    ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {id:id},
        success: function(data)
        {
            //console.log(data);
            $(".anotherstudentdata").html(data.studata);
        }
    });
});

$(document).on('change','.stu',function(){
  var url=$(this).data('url');
    var classId = $('#getStuClassWise').val();
  var stu_id=$(this).val();
    var reportUrl = $('#generate-std-ledger-pdf').data('url');
    $('#generate-std-ledger-pdf').hide();
  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {stu_id:stu_id},
        success: function(data)
        {
          //console.log(data);

         $(".studentdata").html(data.studatas);
            $('#generate-std-ledger-pdf').attr('href',reportUrl+'?class_id='+classId+'&stu_id='+stu_id);
            if(data.countChallan) {
                //$('#generate-std-ledger-pdf').attr('data-stu',stu_id);
                $('#generate-std-ledger-pdf').show();
            }
        }
      });
 

});


$(document).on('click','.headWise',function(){

  var url=$(this).data('url');
  var start=$('#startDates').val();
  var end=$('#endDates').val();
  var attrname = $(this).attr('name'); 
  //alert(attrname);

  if(attrname =='Generate Report'){
      window.location.replace(url+"?start="+start+"&end="+end);
  }else{


 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {start:start,end:end},
        success: function(data)
        {
          //console.log(data);

          $(".headwise-pay").html(data.cashflowhere);
          //$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html("hi there");
          //$("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
    }
 

});



$(document).on('click','#cashInflowclasswise',function(){
  var url=$(this).data('url');
  var date=$(this).data('date');
  $("#cashflowCalendar").hide();
  //alert(date);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {date:date},
        success: function(data)
        {
          //console.log(data);
         // $('#modal').modal('show');

          //$("#modalContents").html(data.cashflowclass);
          $("#cashflowhere").html(data.cashflowclass);
          
        }
      });
 

});

$(document).on('click','#classwiseDetail',function(){
  var url=$(this).data('url');
  var classid=$(this).data('classid');
  var dates=$(this).data('dates');
  //alert(dates);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {classid:classid,dates:dates},
        success: function(data)
        {
          //console.log(data);
         // $('#modal').modal('show');

          //$("#modalContents").html(data.cashflowclass);
          $("#cashflowhere").html(data.cashflowclasswise);
          
        }
      });
 

});

// end of finance



// yearly admission report


$(document).on('change','.YearCal',function(){
  //alert('adfadf');
  var url=$(this).data('url');
  var year=$(this).val();
  $('.yearCalendar').show();

  //alert(dates);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {year:year},
        success: function(data)
        {
          //console.log(data);
         
          $(".getYearadmission").html(data.getYearadmission);
          
        }
      });
 

});


$(document).on('click','.YearCals',function(){
  //alert('adfadf');
  var url=$(this).data('url');
  var year=$(this).data('year');
  $('.yearCalendar').show();

  //alert(dates);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {year:year},
        success: function(data)
        {
          //console.log(data);
         
          $(".getYearadmission").html(data.getYearadmission);
          
        }
      });
 

});


$(document).on('click','.classwiseYearAdmisn',function(){
  var url=$(this).data('url');
  var years=$(this).data('year');
  //alert(years);
  $('.yearCalendar').hide();
  var attrname = $(this).attr('name'); 
  //alert(years);
 // alert(attrname);
  if(attrname =='Generate Report'){
      window.location.replace(url+"?years="+years+"&attrname="+attrname);
  }else{
  //alert(url);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {years:years},
        success: function(data)
        {
          //console.log(data.getYearadmissionClasswise);
         
          $(".getYearadmission").html(data.getYearadmissionClasswise);
          
        }
      });
    }
   });


$(document).on('click','.classwiseYearAdmisnStudents',function(){
  var url=$(this).data('url');
  var classid=$(this).data('classid');
  var years=$(this).data('year');

  //alert(years);


  $('.yearCalendar').hide();
  var attrname = $(this).attr('name'); 
  //alert(attrname);



  if(attrname =='Generate Report'){
      window.location.replace(url+"?years="+years+"&classid="+classid);
  }else{
  //alert(url);
 
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {classid:classid,years:years},
        success: function(data)
        {
          //console.log(data.getYearadmissionClasswise);
         
          $(".getYearadmission").html(data.getYearadmissionClasswiseStudents);
          
        }
      });
    }
   });



// end of yealy admissin report

/*class wise result sheet */
$(document).on('click', '#class-wise-result-sheet-btn', function (e) {
    var classId = $('#class-id').val();
    var groupId = $('#group-id').val();
    var examType = $('#exam-type-id').val();
    var examSection = $('#exam-section-id').val();
    var url = $(this).data('url');
    getClassWiseResultSheet(classId,examType,examSection,groupId,url);
});

function getClassWiseResultSheet(classId,examType,examSection,groupId,url){
    var errors=0;
    $("#generate-report-sheet-btn").hide();
    if(classId ==''){
        var title = $('#class-id').closest('.form-group').find('.control-label').text();

        $('#class-id').closest('.form-group').addClass('has-error');
        $('#class-id').closest('.form-group').removeClass('has-success');
        $('#class-id').closest('.form-group').find('.help-block').html(title+' cannot be blank');
        errors++;
    }
    else{
        $('#class-id').closest('.form-group').addClass('has-success');
        $('#class-id').closest('.form-group').removeClass('has-error');
        $('#class-id').closest('.form-group').find('.help-block').html('');
    }

    if(examType ==''){
        title = $('#exam-type-id').closest('.form-group').find('.control-label').text();
        $('#exam-type-id').closest('.form-group').addClass('has-error');
        $('#exam-type-id').closest('.form-group').removeClass('has-success');
        $('#exam-type-id').closest('.form-group').find('.help-block').html(title+' cannot be blank');
        errors++;
    }else{
        $('#exam-type-id').closest('.form-group').addClass('has-success');
        $('#exam-type-id').closest('.form-group').removeClass('has-error');
        $('#exam-type-id').closest('.form-group').find('.help-block').html('');
    }
    if(examSection ==''){
        title = $('#exam-section-id').closest('.form-group').find('.control-label').text();
        $('#exam-section-id').closest('.form-group').addClass('has-error');
        $('#exam-section-id').closest('.form-group').removeClass('has-success');
        $('#exam-section-id').closest('.form-group').find('.help-block').html(title+' cannot be blank');
        errors++;
    }else{
        $('#exam-section-id').closest('.form-group').addClass('has-success');
        $('#exam-section-id').closest('.form-group').removeClass('has-error');
        $('#exam-section-id').closest('.form-group').find('.help-block').html('');
    }

    if(errors ==0){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {class_id:classId,group_id:groupId,exam_type:examType,section:examSection},
            success: function(data)
            {
                if(data.status==1){
                    $("#displaysearch").html(data.details);
                    $("#generate-report-sheet-btn").show();
                }


            }
        });
    }
}
/*$('body').bind('keypress',function (event){
 if (event.keyCode === 13){
 alert('ere');
 }
 });*/


 /* new admission class wise pdf */
 $(document).on('click','#newAdmissionClassWise',function(){
//alert('asdfasdf');
  var url=$(this).data('url');

  var name= $(this).attr('name');
  
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name); 
  }
 });

  $(document).on('click','#promotedClassWise',function(){
//alert('asdfasdf');
  var url=$(this).data('url');

  var name= $(this).attr('name');
  
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name); 
  }
 });


  $(document).on('click','#overallTransport',function(){
//alert('asdfasdf');
  var url=$(this).data('url');

  var name= $(this).attr('name');
  
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name); 
  }
 });

   $(document).on('click','#overalltransportzone',function(){
  var url=$(this).data('url');
  var name= $(this).attr('name');
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name); 
  }
 });

  $(document).on('click','#overalltransportroute',function(){
  var url=$(this).data('url');
  var name= $(this).attr('name');
  var zoneid=$(this).data('zoneid');
  
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name+"&zoneid="+zoneid); 
  }
 });


  $(document).on('click','#stopwise',function(){
  var url=$(this).data('url');
  var name= $(this).attr('name');
  var zoneid=$(this).data('zoneid');
  var routeid=$(this).data('route');
  
  if(name == 'Generate Report'){
    window.location.replace(url+"?name="+name+"&zoneid="+zoneid+"&routeid="+routeid); 
  }
 });
 /* end of new admission class wise pdf */


$(document).on('click','.studentOverlReport',function(){
  
  var url=$(this).data('url');
  var startdate=$("#startDatess").val();
  var enddate=$("#endDatess").val();

  var attrname=$(this).attr('name');
  if(attrname =='Generate Report'){
      window.location.replace(url+"?startdate="+startdate+"&enddate="+enddate);
  }
  else{
 
  $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {startdate:startdate,enddate:enddate},
        success: function(data)
        {
            console.log(data);
            $(".showOverallStudent").html(data.overallstudents);
        }
      });
    }
});


$(document).on('change','#yearLeave',function(){
  var url=$(this).data('url');
  var years=$(this).val();
  $('#showPdfLeave').show();
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {years:years},
        success: function(data)
        {
          $("#showleavestu").html(data.showleavestu);
        }
      });
    
   });

 $(document).on('click','#yearlevpdf',function(){
  var url=$(this).data('url');
  var years=$("#yearLeave").val();
  var attrname = $(this).attr('name'); 
  if(attrname =='Generate Report'){
    window.location.replace(url+"?years="+years);
  }
   });

  $(document).on('click','.leaveYear',function(){
  var url=$(this).data('url');
  var years=$(this).data('year');
   $('#showPdfLeave').hide();
   $('#leaveYearpdf').show();
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {years:years},
        success: function(data)
        {
          $("#showleavestu").html(data.showleavestu); 
        }
      });
   });


  $(document).on('click','#levyearpdf',function(){
  var url=$(this).data('url');
  var years=$("#yearLeave").val();
  var attrname = $(this).attr('name'); 
  if(attrname =='Generate Report'){
    window.location.replace(url+"?years="+years);
  }
   });


$(document).on('click','.leaveYearstud',function(){
  var url=$(this).data('url');
  var years=$(this).data('year');
  var clas=$(this).data('clas');
  $('#clsxId').val(clas);
  $('#leaveYearpdf').hide();
  $('#leaveYearstudpdf').show();
    $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {years:years,clas:clas},
        success: function(data)
        {
          $("#showleavestu").html(data.showleavestu);  
        }
      });
   });


 $(document).on('click','#leaveYearstudntpdf',function(){
  var url=$(this).data('url');
  var years=$("#yearLeave").val();
  var clas=$('#clsxId').val();
  var attrname = $(this).attr('name'); 
  if(attrname =='Generate Report'){
    window.location.replace(url+"?years="+years+"&clas="+clas);
  }
   });
