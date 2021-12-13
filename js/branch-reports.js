 /**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 20/2/2017.
 * branch-reports.js
 * for branch-reports related js.
 */


$(document).ready(function() {
  $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
    e.preventDefault();
    $(this).siblings('a.active').removeClass("active");
    $(this).addClass("active");
    var index = $(this).index();
    var url  =  $(this).attr('href');
    var branchid=$(this).data('branchid');
    //alert(branchid);
    //alert(index);
    /*ajax call*/
    //if(index != 0){
      $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
       // data: $('#exam-form').serialize(),
       data: {branchid:branchid},
        success: function(data)
        {
          //$(".viewBranches").html(data.viewBranches);

          // $("#getTransport").html(data.viewtransport);
          $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).html(data.viewBranches);
          $("#getWidthdrawl").html(data.withdrawlStu);
        }
      });
   // }


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
  var sectn=$('#sections-id').val();


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
  $(".xone").empty();
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


$(document).on('click','#BranchesAjaxd',function(){
  var url=$(this).data('url');
  var branchid=$(this).data('branchid');
 // alert(branchid);
   $.ajax
      ({
        type: "POST",
        dataType:"JSON",
        url: url,
        data: {branchid:branchid},
        success: function(data)
        {
          //console.log(data);
         
          $(".viewBranches").html(data.viewBranches);
          
        }
      });
 
});

// end of finance