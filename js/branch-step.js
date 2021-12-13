/**
 * Student JS
 * Developed by Suliman Khan <> on 6/1/2016.
 */


 /*=======wizard=============*/
    var formWizard = $("#wizard");
        formWizard.steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",

        


        onStepChanging: function (event, currentIndex, newIndex) {

            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
               // scroll to position.

               /*============ 2nd step*/
            var firstCreateInput=$(".classex").val();
           // alert(firstCreateInput);
            if(firstCreateInput == undefined){}else{
            $("#timer").show();
            $("#classLabel").hide(); //div
            $("#pasval").hide();
            $("#classesCreate").hide();
            $("#sesionclass").hide();
            }

            /*============ end of 2nd step ans start of 3rd ==*/
            
            var firstplanInput=$('.mode').val();
            alert(firstplanInput);
            if(firstplanInput == undefined){}else{
            $("#feePlanCreate").show(); 
            $("#feemodeLabel").hide();
            $("#feemode").hide();
            $("#feemodxx").hide();
            }
           // add another button

            /*============ end of 3rd step and start of 4th step===*/
            var firstHeadInput=$('.headss').val();
            //alert(firstHeadInput);
            if(firstHeadInput == undefined){}else{
            $("#feeHeadsCreatenew").show(); // add another button
            $("#feeheads").hide();
            $("#feeheadxx").hide();
            $("#feeheadsLabel").hide();
            
            }

            /*============ end of 4th step ans start of step 6===*/
            var studPlanLabel=$('.typesfee').val();
          //  alert(studPlanLabel);
            if(studPlanLabel == undefined){}else{
            $("#assignfeeplan").show(); // add another button
            $("#planType").hide();
            $("#feeplantypx").hide();
            $("#studentPlanCreate").hide();
           // $(".instal").hide();
        }
            /*============ end of step 6===*/



                return true;

                //$("#existsBranch").empty();
            }
            if(currentIndex === 0 && newIndex ===1){
               //return true;
                $("#existsBranch").empty();
                var stepOneError = 0;
                var stepDetail      = $('#wizard-p-'+currentIndex);
                var name            = $('#branch-name').val();
                var country         = $('#branch-fk_country_id').val();
                var province        = $('#branch-fk_province_id').val();
                var district        = $('#branch-fk_district_id').val();
                var city            = $('#branch-fk_city_id').val();
                var zip             = $('#branch-zip').val();
                var email           = $('#branch-email').val();
                var website         = $('#branch-website').val();
                var phone           = $('#branch-phone').val();
                var address         = $('#branch-address').val();
                var description     = $('#branch-description').val();
                var url=$('#branch-name').data('url');

                //var branchid=$('.branch_input').val();
               // alert(url);
               // return false;

               // $("#timer").hide();


                if(name ==''){
                    $('.bname').text('Branch Name Cannot Be Blank');
                    stepOneError++;
                }else{
                    $('.bname').text('');
                }
                if(description ==''){
                    $('.bdescription').text('description Cannot Be Blank');
                    stepOneError++;
                }else{
                    $('.bdescription').text('');
                }
                if(country ==''){
                    $('.bcountry').text('country Cannot Be Blank');
                    stepOneError++;
                }else{
                    $('.bcountry').text('');
                }
                if(province ==''){
                    $('.bprovince').text('province Cannot Be Blank');
                    //stepOneError++;
                }else{
                    $('.bprovince').text('');
                }
                if(district ==''){
                    $('.bdistrict').text('District Cannot Be Blank');
                    stepOneError++;
                }else{
                    $('.bdistrict').text('');
                }
                 if(city ==''){
                    $('.bcity').text('City Cannot Be Blank');
                   // stepOneError++;
                }else{
                    $('.bcity').text('');
                }
                if(zip ==''){
                    $('.bzip').text('zip Cannot Be Blank');
                    stepOneError++;
                }else{
                    $('.bzip').text('');
                }
                if(email ==''){

                    $('.bemail').text('Email Cannot Be Blank');
                    stepOneError++;
                }


                else{
                    $('.bemail').text('');
                    $('#branch-form').ajaxSubmit({
                        url: url,
                        type: 'post',
                        dataType:"JSON",
                        beforeSend: function(){
                            $("div.modal-content").append("<div id='overLayDiv'><div style='top: 50%;left: 50%;margin-right: auto;margin-bottom: auto;position: absolute;'><span style='color:#1FA4EA; font-size:20px; font-weight:bold; padding-left:5px;'><i class='fa fa-refresh fa-spin'></i></span></div></div>");
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
                        success: function(data) {
                            if(data.status == 1){
                                $('.branch_input').val(data.branch_id);
                                $('#existsBranch').html(data.branch_id);
                            }

                        }
                    });
                }
                
                if(stepOneError === 0){
                    return true;
                }else{
                    return false;
                }
            } // end of first step

            if(currentIndex === 1 && newIndex ===2){
                //return true;
               
                var updateclass="";
                var branchid=$('.branch_input').val();
                var error =0;

                //$("#feePlanCreate").hide();

                var status=$("#statuscreate").val();
                var cls=$('.classex').map( function(){
                 return $(this).val(); 
                }).get();
                var arr = [];
                var c=$(".classex").each(function(){
                    var value = $(this).val();
                    if (arr.indexOf(value) == -1){
                        arr.push(value);
                    }
                    else{
                 $('#sameclass').text("Classes with same name are not accepted");
                 error++;
                        }
           
                });
                var session=$('#refclass-fk_session_id').val();
                    var url = $('#refclass-fk_session_id').data('url');

                if(session ==''){
                    $('#sesnerror').text('session Cannot Be empty');
                    error++;
                    
                }else{
                    $('#sesnerror').text('');

                }

                    if(status == 'create'){
                        
                        updateclass='';
                    }else{
                        
                       updateclass=$('.cls_db_id').map( function(){
                       return $(this).val();
                       }).get();
                    }


                if(error == 0){
                 $.ajax ({
                    type: "POST",
                    dataType:'JSON',
                    data: {session:session,cls:cls,branchid:branchid,status:status,updateclass:updateclass},
                    url: url,
                    cache: false,
                    success: function(result)
                    {
                        $('.handleClasses').html(result.classview);
                        $(".inputcls").html(result.inputclass);
                        $("#statuscreate").val(result.statusUpdate);


                    } 
                });
              
          }
     

              if(error > 0){
                    return false;
                }else{
                    return true
                }

            } // end of step



            if(currentIndex === 2 && newIndex ===3){
                   // return true;
                var updateclass="";
                var branchid=$('.branch_input').val();
                var status=$("#statuscreatemode").val();

               // $("#feeHeadsCreatenew").hide();
                var feemodeerror =0;
                var mod=$('.mode').map( function(){
                 return $(this).val(); 
                }).get();

                var month=$('.timespan').map( function(){
                 return $(this).val(); 
                }).get();

                var arr = [];
                var c=$(".mode").each(function(){
                var value = $(this).val();
                if (arr.indexOf(value) == -1){
                    arr.push(value);
                }
                else{
                    $('#samefeeplan').text("Fee Modes with same name are not accepted");
                     feemodeerror++;
                     }
                 });

                 var url = $('#sendUrl').data('urls');
                   

                if(mod ==''){
                    $('#femonth').text('Fee Month Cannot Be Blank');
                    feemodeerror++;
                }
                else{

                    // $("#feePlanCreate").show();

                    if(status == 'create'){
                        updateclass='';
                    }else{
                     updateclass=$('.paymentmode_db_id').map( function(){
                    return $(this).val();
                   }).get();
                     //console.log(updateclass);
                    }

                    if(feemodeerror == 0){
                    

                  $.ajax ({
            type: "POST",
            dataType:'JSON',
            data: {month:month,mod:mod,branchid:branchid,updateclass:updateclass,status:status},
            url: url,
            cache: false,
            success: function(result)
            {
                //console.log(result.branch);
                $(".lastid").html(result.lastid);
                $("#statuscreatemode").val(result.statusUpdate);
                $("select.fee_modes").html(result.feeHeadOptions);
            } 
        });
              }
          }

              if(feemodeerror > 0){
                    return false;
                }else{
                    return true
                }

            } // end of if


            if(currentIndex === 3 && newIndex ===4){
                //return true;
                var updateclass="";
                var feeheadserror =0;
                var branchid=$('.branch_input').val();

                
               var heads=$('.headss').map( function(){
                 return $(this).val(); 
                }).get();

               var method=$('.fee_modes').map( function(){
                 return $(this).val(); 
                }).get();

                var arr = [];
                var c=$(".headss").each(function(){
                var value = $(this).val();
                if (arr.indexOf(value) == -1){
                    arr.push(value);
                }
                else{
                    $('#sameHeads').text("Fee Heads with same name are not accepted");
                     feeheadserror++;
                     }
                 });

                var url = $('#pamntmod').data('url');
                   

                
                if(method ==''){
                    $('#metd').text('Fee Mode Cannot Be Blank');
                    feeheadserror++;
                }
                else{
                // $("#feeHeadsCreatenew").show();


                    if(status == 'create'){
                        updateclass='';
                    }else{
                     updateclass=$('.head_db_id').map( function(){
                    return $(this).val();
                   }).get();

                     //console.log(updateclass);
                    }


                    if(feeheadserror == 0){
                    

                  $.ajax ({
            type: "POST",
            dataType:'JSON',
            data: {method:method,heads:heads,branchid:branchid,status:status,updateclass:updateclass},
            url: url,
            cache: false,
            success: function(result)
            {
                //console.log(result.views)
                $(".lastidx").html(result.lastId);

                $(".getHed").html(result.headx);

                $("#statuscreateheads").val(result.statusUpdate);
            } 
        });
                        
                }
            }
                if(feeheadserror > 0){
                    return false;
                }else{
                    return true
                }
            //}
           } // end of if








            //alert(newIndex);
            /*if (currentIndex > newIndex) {
                scroll to position.
                return true;
            }*/

            if(currentIndex === 4 && newIndex ===5){
                //return true;
                //alert(currentIndex);
                var errorAssign=0;
               // $("#assignfeeplan").hide();
                var feeHead= $("#feegroup-fk_fee_head_id").val();
                if(feeHead == ''){
                    $('#feeError').text('Fee Heads Cannot Be Blank');
                    errorAssign++;
                }else{
                   $('#feeError').text('');
                }

                var ammount= $("#feegroup-amount").val();
                //alert(ammount);

                if(ammount == ''){
                    var amoutnerror=$('#amountError').text("Amount cannot be blank");
                    errorAssign++;
                  }else{
                    $('#amountError').text("")
                  }


                  if(errorAssign > 0){
                    return false;
                }else{
                    return true
                }
                    

            } //end of assign fee if


            if(currentIndex === 5 && newIndex ===6){
                var feetypeserror =0;
               // $("#assignfeeplan").show();
                var branchid=$('.branch_input').val();
                var updateclass="";
                var status=$("#statuscreateplanType").val();

                
               var typefee=$('.typesfee').map( function(){
                 return $(this).val(); 
                }).get();

               var arr = [];
                var c=$(".typesfee").each(function(){
                var value = $(this).val();
                if (arr.indexOf(value) == -1){
                    arr.push(value);
                }
                else{
                    $('#samePlan').text("Studen plan with same name are not accepted");
                     feetypeserror++;
                     }
                 });


               var instal=$('.instal').map( function(){
                 return $(this).val(); 
                }).get();
                var url = $('#pasfeeurl').data('url');

                if(status == 'create'){
                        updateclass='';
                    }else{
                     updateclass=$('.plantype_db_id').map( function(){
                    return $(this).val();
                   }).get();

                     //console.log(updateclass);
                    }
                   
                 if(feetypeserror == 0){
                  $.ajax ({
            type: "POST",
            dataType:'JSON',
            data: {instal:instal,typefee:typefee,branchid:branchid,updateclass:updateclass,status:status},
            url: url,
            cache: false,
            success: function(result)
            {
                //console.log(result.views)
                $(".getHed").html(result.headx);
                $(".lastidxPlan").html(result.lastIdPlan);
                $('#statuscreateplanType').val(result.statusUpdate);

                //$(".getDesignation").html(result);
            } 
        });
              }
                
                if(feetypeserror > 0){
                    return false;
                }else{
                    return true
                }
                

            } //end of assign fee if

        },    //end of step changing function

        onFinishing: function (event, currentIndex)
        {
                
                    var settingserror =0;
                    var branchid=$('.branch_input').val();
                   // alert(branchid);
                    var fee=$('#settings-fee_due_date').val();
                    var intime=$('#val').val();
                    var outtime=$('#val2').val();
                    var theme = $('#settings-theme_color').val();
                    var bankname = $('#settings-fee_bank_name').val();
                    var bankacount = $('#settings-fee_bank_account').val();
                    var salry = $('#settings-salary_bank_name').val();
                    var salryBnkacnt = $('#settings-salary_bank_account').val();
                    var url=$('#settings-fee_due_date').data('url');

                  // alert(url);
                   // return false;

                /*if(cls ==''){
                    $('.claserror').text('Class Cannot Be empty');
                    stepOneError++;
                }*/
                if(fee ==''){
                    $('#fees').text('Theme Cannot Be Blank');
                    settingserror++;
                }
                if(theme ==''){
                    $('#themeerror').text('Theme Cannot Be Blank');
                    settingserror++;
                }
                else{
                    

                  $.ajax ({
            type: "POST",
            dataType:'JSON',
            data: {fee:fee,intime:intime,outtime:outtime,theme:theme,bankname:bankname,bankacount:bankacount
                ,salry:salry,salryBnkacnt:salryBnkacnt,branchid:branchid},
            url: url,
            cache: false,
            success: function(result)
            {
                console.log(result.views)
                $(".feeHeads").html(result.views);
                $(".getDesignation").html(result);
            } 
        });
                        

              
                $('#branch-form').submit();
                return true;

                }
                if(settingserror > 0){
                    return false;
                }else{
                    return true
                }
            //}
                // $('#branch-form').submit();
                // return true;


        },
       });


/*======= end of wizard=============*/
    $(document).on('click','#assignFees',function(event){
        event.preventDefault();

        var error =0;
        
        $("#exists").empty();
        var branchid=$('.branch_input').val();
        var feeHeads= $("#feegroup-fk_fee_head_id").val();
        var ammount= $("#feegroup-amount").val();

        var getclass=$('.classesVal:checked').map( function(){
              return $(this).val(); 
              }).get();
       var url=$(this).data('url');
       if(feeHeads == ''){
        $('#feeError').text('Fee Heads Cannot Be Blank');
        error++;
       }else{
        $('#feeError').text('');
       }

       if(ammount == ''){
            var amoutnerror=$('#amountError').text("Amount cannot be blank");
            error++;
        }else{

        $.ajax({
            type:"POST",
            //dataType:JSON
            data: {branchid:branchid,feeHeads:feeHeads,ammount:ammount,getclass:getclass},
            url:url,
            cache:false,
            success:function(response){
                //alert('succus');
               // console.log(response);
                $("#exists").html(response);
              //  $("#feegroup-fk_fee_head_id").empty();
                $("#succesAlert").text(response);

            }
        });
    }
    });


    $(document).on('blur','#branch-name',function(event){
        event.preventDefault();
        
        var name  = $('#branch-name').val();
        var url=$('#exisbranch').data('url');
        //alert(url);

        $.ajax({
            type:"POST",
            data: {name:name},
            url:url,
            cache:false,
            success:function(response){
                //alert('succus');
               // console.log(response);
                $("#existsBranch").text(response);
              //  $("#feegroup-fk_fee_head_id").empty();
               // $("#succesAlert").text(response);

            }
        });
    });


    $(document).on('change','#feegroup-fk_fee_head_id',function(){
        //alert('#sdfasdf');
        $("#exists").empty();

        //$("#class-id").val('');
       /* var getclass=$('.:checked').map( function(){
              return $(this).empty(); 
              }).get();*/
        //$('.classesVal:checked').removeAttr('checked');
    });


