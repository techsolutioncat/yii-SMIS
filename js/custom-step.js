/**
 * Student JS
 * Developed by Suleman Khan <> on 6/1/2016.
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
                /*scroll to position.*/
                return true;
            }
            if(currentIndex === 0 && newIndex ===1){
                var stepOneError = 0;
                var stepDetail = $('#wizard-p-'+currentIndex);
                var classId     = stepDetail.find('select#class-id').val();
                var sectionId   = stepDetail.find('select#section-id').val();
                var fatherCnic  = stepDetail.find('input[name="StudentParentsInfo[cnic]"]').val();

                if(classId ==''){
                    stepDetail.find('.field-class-id').addClass('has-error');
                    stepDetail.find('.field-class-id').removeClass('has-success');
                    stepDetail.find('.field-class-id .help-block').html('Class cannot be blank.');
                    stepOneError++;
                }else{
                    stepDetail.find('.field-class-id').addClass('has-success');
                    stepDetail.find('.field-class-id').removeClass('has-error');
                    stepDetail.find('.field-class-id .help-block').html('');
                }
                if(sectionId ==''){
                    stepDetail.find('.field-section-id').addClass('has-error');
                    stepDetail.find('.field-section-id').removeClass('has-success');
                    stepDetail.find('.field-section-id .help-block').html('Section cannot be blank.');
                    stepOneError++;
                }else{
                    stepDetail.find('.field-section-id').addClass('has-success');
                    stepDetail.find('.field-section-id').removeClass('has-error');
                    stepDetail.find('.field-section-id .help-block').html('');
                }
                /*if(fatherCnic ==''){
                    stepDetail.find('.field-input1').addClass('has-error');
                    stepDetail.find('.field-input1').removeClass('has-success');
                    stepDetail.find('.field-input1 .help-block').html('Father CNIC is required.');
                    stepOneError++;
                }
                else{
                    stepDetail.find('.field-input1').addClass('has-success');
                    stepDetail.find('.field-input1').removeClass('has-error');
                    stepDetail.find('.field-input1 .help-block').html('');
                }*/
                if(stepOneError === 0){
                    return true;
                }else{
                    return false;
                }
            }
            if(currentIndex === 1 && newIndex ===2){
                var transportError =0;
                var hostelError =0;
                var error =0;
                var tarnsportCheck = $('input[name="StudentInfo[is_transport_avail]"]:checked').val();
                var hostelCheck    = $('input[name="StudentInfo[is_hostel_avail]"]:checked').val();

                if(tarnsportCheck == 1  || hostelCheck == 1){
                    var zone = $('#studentinfo-zone');
                    var route = $('#studentinfo-route');
                    var stop = $('#studentinfo-fk_stop_id');

                    var hostel = $('#hosteldetail-fk_hostel_id');
                    var floor  = $('#hosteldetail-fk_floor_id');
                    var room   = $('#hosteldetail-fk_room_id');
                    var bed    = $('#hosteldetail-fk_bed_id');


                    if(tarnsportCheck == 1){
                        /*zone validation*/
                        if(zone.val() == ''){
                            zone.closest('.form-group').addClass('has-error');
                            zone.closest('.form-group').removeClass('has-success');
                            zone.closest('.form-group').find('.help-block').html('Zone is required.');
                            transportError++;
                        }
                        else{
                            zone.closest('.form-group').addClass('has-success');
                            zone.closest('.form-group').removeClass('has-error');
                            zone.closest('.form-group').find('.help-block').html('');
                        }

                        /*route validation*/
                        if(route.val() == '' || route.val() == 'Select Route'){
                            route.closest('.form-group').addClass('has-error');
                            route.closest('.form-group').removeClass('has-success');
                            route.closest('.form-group').find('.help-block').html('Route is required.');
                            transportError++;
                        }
                        else{
                            route.closest('.form-group').addClass('has-success');
                            route.closest('.form-group').removeClass('has-error');
                            route.closest('.form-group').find('.help-block').html('');
                        }

                        /*stop validation.*/

                        if(stop.val() == '' || stop.val() == 'Select Stop'){
                            stop.closest('.form-group').addClass('has-error');
                            stop.closest('.form-group').removeClass('has-success');
                            stop.closest('.form-group').find('.help-block').html('Stop is required.');
                            transportError++;
                        }
                        else{
                            stop.closest('.form-group').addClass('has-success');
                            stop.closest('.form-group').removeClass('has-error');
                            stop.closest('.form-group').find('.help-block').html('');
                        }

                        /*if there's any error in any transport field incermente in master error */
                        if(transportError > 0){
                            error++;
                        }
                    }
                    else{
                        zone.closest('.form-group').addClass('has-success');
                        zone.closest('.form-group').removeClass('has-error');
                        zone.closest('.form-group').find('.help-block').html('');

                        route.closest('.form-group').addClass('has-success');
                        route.closest('.form-group').removeClass('has-error');
                        route.closest('.form-group').find('.help-block').html('');

                        stop.closest('.form-group').addClass('has-success');
                        stop.closest('.form-group').removeClass('has-error');
                        stop.closest('.form-group').find('.help-block').html('');

                    }
                    if(hostelCheck == 1){

                        var overallError  = bed.closest('section').find('#overall-error').val()

                        /*hostel validation*/
                        if(hostel.val() == ''){
                            hostel.closest('.form-group').addClass('has-error');
                            hostel.closest('.form-group').removeClass('has-success');
                            hostel.closest('.form-group').find('.help-block').html('Hostel is required.');
                            hostelError++;
                        }
                        else{
                            hostel.closest('.form-group').addClass('has-success');
                            hostel.closest('.form-group').removeClass('has-error');
                            hostel.closest('.form-group').find('.help-block').html('');
                        }

                        /*floor validation*/
                        if(floor.val() == '' || floor.val() == 'Select Floor'){
                            floor.closest('.form-group').addClass('has-error');
                            floor.closest('.form-group').removeClass('has-success');
                            floor.closest('.form-group').find('.help-block').html('Floor is required.');
                            hostelError++;
                        }
                        else{
                            floor.closest('.form-group').addClass('has-success');
                            floor.closest('.form-group').removeClass('has-error');
                            floor.closest('.form-group').find('.help-block').html('');
                        }

                        /*Room validation*/
                        if(room.val() == '' || room.val() == 'Select Room'){
                            room.closest('.form-group').addClass('has-error');
                            room.closest('.form-group').removeClass('has-success');
                            room.closest('.form-group').find('.help-block').html('Room is required.');
                            hostelError++;
                        }
                        else{
                            room.closest('.form-group').addClass('has-success');
                            room.closest('.form-group').removeClass('has-error');
                            room.closest('.form-group').find('.help-block').html('');
                        }

                        /*Bed validation*/
                        if(bed.val() == ''  || bed.val() == 'Select Bed'){
                            bed.closest('.form-group').addClass('has-error');
                            bed.closest('.form-group').removeClass('has-success');
                            bed.closest('.form-group').find('.help-block').html('Bed is required.');
                            hostelError++;
                        }
                        else{
                            if(overallError == 1){
                                bed.closest('.form-group').find('.help-block').html('This Bed has already taken');
                                hostelError++
                            }else{
                                bed.closest('.form-group').addClass('has-success');
                                bed.closest('.form-group').removeClass('has-error');
                                bed.closest('.form-group').find('.help-block').html('');
                            }

                        }

                        /*if there's any error in any transport field incermente in master error */
                        if(hostelError > 0){
                            error++;
                        }
                    }
                    else {
                        hostel.closest('.form-group').addClass('has-success');
                        hostel.closest('.form-group').removeClass('has-error');
                        hostel.closest('.form-group').find('.help-block').html('');

                        floor.closest('.form-group').addClass('has-success');
                        floor.closest('.form-group').removeClass('has-error');
                        floor.closest('.form-group').find('.help-block').html('');

                        room.closest('.form-group').addClass('has-success');
                        room.closest('.form-group').removeClass('has-error');
                        room.closest('.form-group').find('.help-block').html('');

                        bed.closest('.form-group').addClass('has-success');
                        bed.closest('.form-group').removeClass('has-error');
                        bed.closest('.form-group').find('.help-block').html('');
                    }
                }

                /*if there's error in step taransport and boarding.*/
                if(error > 0){
                    return false;
                }else{
                    return true
                }

                //alert('step 2');
            }
            if(currentIndex === 2 && newIndex === 3){
                var  stepPersonelInfoError  = 0;
                var  dob                    = $('#dobdate');
                var  registration           = $('#registeration');
                var  fname                  = $('#firstnamePersonnel');
                //var  lname                  = $('#lastnamepersonel');

                /*dob validation*/
                if(dob.val() == ''){
                    dob.closest('.form-group').addClass('has-error');
                    dob.closest('.form-group').removeClass('has-success');
                    dob.closest('.form-group').find('.help-block').html('DOB is required');
                    stepPersonelInfoError++;
                }else{
                    dob.closest('.form-group').addClass('has-success');
                    dob.closest('.form-group').removeClass('has-error');
                    dob.closest('.form-group').find('.help-block').html('');
                }

                /*registration validation*/
                if(registration.val() == ''){
                    registration.closest('.form-group').addClass('has-error');
                    registration.closest('.form-group').removeClass('has-success');
                    registration.closest('.form-group').find('.help-block').html('Registration is required');
                    stepPersonelInfoError++;
                }else{
                    $.ajax
                    ({
                        type: "POST",
                        dataType:"JSON",
                        data: {username:registration.val()},
                        url: registration.data('url'),
                        cache: false,
                        success: function(data)
                        {
                            if(data.status == 1){
                                if(data.detail == 1 || data.detail >1){
                                    registration.closest('.form-group').addClass('has-error');
                                    registration.closest('.form-group').removeClass('has-success');
                                    registration.closest('.form-group').find('.help-block').html('Student with this registration Already Exists.');
                                    stepPersonelInfoError++;
                                }else{
                                    registration.closest('.form-group').addClass('has-success');
                                    registration.closest('.form-group').removeClass('has-error');
                                    registration.closest('.form-group').find('.help-block').html('');
                                }
                            }
                        }
                    });
                }

                /*fname validation*/
                if(fname.val() == ''){
                    fname.closest('.form-group').addClass('has-error');
                    fname.closest('.form-group').removeClass('has-success');
                    fname.closest('.form-group').find('.help-block').html('First Name is required');
                    stepPersonelInfoError++;
                }else{
                    fname.closest('.form-group').addClass('has-success');
                    fname.closest('.form-group').removeClass('has-error');
                    fname.closest('.form-group').find('.help-block').html('');
                }

                /*lname validation*/
               /* if(lname.val() == ''){
                    lname.closest('.form-group').addClass('has-error');
                    lname.closest('.form-group').removeClass('has-success');
                    lname.closest('.form-group').find('.help-block').html('Last Name is required');
                    stepPersonelInfoError++;
                }else{
                    lname.closest('.form-group').addClass('has-success');
                    lname.closest('.form-group').removeClass('has-error');
                    lname.closest('.form-group').find('.help-block').html('');
                }*/

                if(stepPersonelInfoError>0){
                    return false;
                }else{
                    return true;
                }
            }
            if(currentIndex === 3 && newIndex === 4){
                var stepParentInfoError = 0;
                var fatherName = $('#fatherName');
                //var motherName = $('#motherName');
                var fatherProfession = $('#fatherProfession');
                //var motherProfession = $('#motherProfession');

                /*fatherName validation*/
                if(fatherName.val() == ''){
                    fatherName.closest('.form-group').addClass('has-error');
                    fatherName.closest('.form-group').removeClass('has-success');
                    fatherName.closest('.form-group').find('.help-block').html('Father Name is required');
                    stepParentInfoError++;
                }else{
                    fatherName.closest('.form-group').addClass('has-success');
                    fatherName.closest('.form-group').removeClass('has-error');
                    fatherName.closest('.form-group').find('.help-block').html('');
                }


                /*motherName validation*/
                /*if(motherName.val() == ''){
                    motherName.closest('.form-group').addClass('has-error');
                    motherName.closest('.form-group').removeClass('has-success');
                    motherName.closest('.form-group').find('.help-block').html('Mother Name is required');
                    stepParentInfoError++;
                }else{
                    motherName.closest('.form-group').addClass('has-success');
                    motherName.closest('.form-group').removeClass('has-error');
                    motherName.closest('.form-group').find('.help-block').html('');
                }*/

                /*fatherProfession validation*/
                if(fatherProfession.val() == ''){
                    fatherProfession.closest('.form-group').addClass('has-error');
                    fatherProfession.closest('.form-group').removeClass('has-success');
                    fatherProfession.closest('.form-group').find('.help-block').html('Father Profession is required');
                    stepParentInfoError++;
                }else{
                    fatherProfession.closest('.form-group').addClass('has-success');
                    fatherProfession.closest('.form-group').removeClass('has-error');
                    fatherProfession.closest('.form-group').find('.help-block').html('');
                }

                /*motherProfession validation*/
                /*if(motherProfession.val() == ''){
                    motherProfession.closest('.form-group').addClass('has-error');
                    motherProfession.closest('.form-group').removeClass('has-success');
                    motherProfession.closest('.form-group').find('.help-block').html('Mother Profession is required');
                    stepParentInfoError++;
                }else{
                    motherProfession.closest('.form-group').addClass('has-success');
                    motherProfession.closest('.form-group').removeClass('has-error');
                    motherProfession.closest('.form-group').find('.help-block').html('');
                }
                */
                if(stepParentInfoError>0){
                    return false;
                }else{
                    return true;
                }

            }
            if(currentIndex === 4 && newIndex === 5){
                var stepTelephonicError = 0;
                var fatherContact = $('#fatherContact');
                //var motherContact = $('#motherContact');


                /*fatherContact validation*/
                if(fatherContact.val() == ''){
                    fatherContact.closest('.form-group').addClass('has-error');
                    fatherContact.closest('.form-group').removeClass('has-success');
                    fatherContact.closest('.form-group').find('.help-block').html('Father Contact is required');
                    stepTelephonicError++;
                }else{
                    fatherContact.closest('.form-group').addClass('has-success');
                    fatherContact.closest('.form-group').removeClass('has-error');
                    fatherContact.closest('.form-group').find('.help-block').html('');
                }

                /*motherContact validation*/
                /*if(motherContact.val() == ''){
                    motherContact.closest('.form-group').addClass('has-error');
                    motherContact.closest('.form-group').removeClass('has-success');
                    motherContact.closest('.form-group').find('.help-block').html('Mother Contact is required');
                    stepTelephonicError++;
                }else{
                    motherContact.closest('.form-group').addClass('has-success');
                    motherContact.closest('.form-group').removeClass('has-error');
                    motherContact.closest('.form-group').find('.help-block').html('');
                }*/

                if(stepTelephonicError>0){
                    return false;
                }else{
                    return true;
                }


            }
            if(currentIndex === 5 && newIndex === 6){
                var feeplanError = 0;
                var feePlanId    = $('#fee-plan-id');
                var $tdClone = $('#table-new-std-challan').clone();
                var discountAmount =  $tdClone.find('#input_total_discount').val();

                /*feePlanId validation*/
                if(feePlanId.val() == ''){
                    feePlanId.closest('.form-group').addClass('has-error');
                    feePlanId.closest('.form-group').removeClass('has-success');
                    feePlanId.closest('.form-group').find('.help-block').html('Fee Plan is required');
                    feeplanError++;
                }else{
                    feePlanId.closest('.form-group').addClass('has-success');
                    feePlanId.closest('.form-group').removeClass('has-error');
                    feePlanId.closest('.form-group').find('.help-block').html('');
                }

                $tdClone.find('#discount_td').html(discountAmount);
                var transporFare = $tdClone.find('#input_total_transport_fare').val();
                if(transporFare >0){
                   $tdClone.find('input#input_total_transport_fare').replaceWith($("<span />").text(transporFare));
                }
                $tdClone.find('#discount-modal').remove();
                //$tdClone.find('#head_hidden_discount_amount').attr('name','');
                $('div#preview-fee').html($tdClone);


                if(feeplanError>0){
                    return false;
                }else{
                    return true;
                }
            }
            if(currentIndex === 6 && newIndex === 7){
                return true;
            }

            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                formWizard.find(".body:eq(" + newIndex + ") label.error").remove();
                formWizard.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            var transportFare  = $('input[name="StudentInfo[is_transport_avail]"]:checked').val();
            var hostelfacility = $('input[name="StudentInfo[is_hostel_avail]"]:checked').val();
            /*scroll to top */
            $('#wizard .content').animate({scrollTop: 0 }, 500);

            if(currentIndex ===1 && priorIndex === 0){
                if(transportFare == 0 && hostelfacility == 0){
                    formWizard.steps("next");
                }
            }
            if(currentIndex ===1 && priorIndex ===2){
                if(transportFare == 0 && hostelfacility == 0){
                    formWizard.steps("previous");
                }
            }
        },
        onFinishing: function (event, currentIndex)
        {
            if(currentIndex === 6){
                $('#admission-form').submit();
                return true;
            }

        },


    });

/*======= end of wizard=============*/

/*on blur form wizerd student registration field*/

$(document).on('focusout','#registeration',function () {
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
                        inputDetail.closest('.form-group').find('.help-block').html('Student with this registration Already Exists.');
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


/* on selection of fee plan type*/
$(document).on('change','#fee-plan-id',function () {
    var planId      = $(this).val();
    var stopId      = $('#studentinfo-fk_stop_id').val()
    var hostelId    = $('#hosteldetail-fk_hostel_id').val()
    var classId     = $('#class-id').val();
    var groupId     = $('#group-id').val();
    var cnic        = $('input[name="StudentParentsInfo[cnic]"]').val();
    var transportCheck = $('#transportYes:checked').val();
    var hostelCheck    = $('#hostelInitial:checked').val();
    var transportStop = '';
    var hostelAvail = '';
    if(transportCheck == 1){
        transportStop  = stopId;
    }else{
        $('#studentinfo-fk_stop_id').select2().val("");
    }

    if(hostelCheck == 1){
        hostelAvail  = hostelId;
    }else{
        $('#hosteldetail-fk_bed_id').select2().val("");
    }
    var errors = 0;
    var url         = $(this).data('url');

    if(classId == ''){
        alert('Class is required');
        errors++;
    }
    if(planId==''){
        errors++;
    }
    if(errors  == 0){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            data: {plan_id:planId,class_id:classId,group_id:groupId,stop_id:transportStop,hostel_id:hostelAvail,parent_cnic:cnic},
            url: url,
            cache: false,
            success: function(data)
            {
                if(data.status == 1){
                    $("#fee-plan-details").empty();
                    $("#fee-plan-details").html(data.html);
                }
            }
        });
    }else{
        return false;
    }
});

/* discount selection*/
$(document).on('click','input[name="StudentDisount[discount_amount]"]',function(){
    if(($(this).is(':checked'))){
        var radioValue      = $(this).val();
        var totalAmount     = $('#total-amount').data('total');
        var netAmount       = $('#net-amount').data('net');
        var transportFare   = $('#total-transport-fare').data('totaltrnsprt');

        if($(this).val() == 0){
            $('#discount-input').show();
        }else{
            $('#discount-input').find('input').val('');
            $('#discount-input').hide();
            //alert(totalAmount+' '+radioValue);
            /*get discount amount*/
            /*totalAmount - paidamount*/
            if(transportFare > 0){
                totalAmount =(totalAmount+transportFare);
            }else{
                totalAmount = totalAmount;
            }
            var discountAmount = (totalAmount*radioValue)/100;
            /*diduct discount % amount from total.*/
            var amountWithDisc = (totalAmount - discountAmount);

            $('#net-amount').html('Rs. '+amountWithDisc);
            $('#input_total_amount_payable').attr('value',amountWithDisc);
            $('#input_total_discount').val(discountAmount);
        }
    }
});

/*custom discount*/
$(document).on('blur','#std_custom_discount',function(){
    var customValue     = $(this).val();
    var totalAmount     = $('#total-amount').data('total');
    var paidAmount      = $('#amount-paid').data('amtpaid');
    var transportFare   = $('#total-transport-fare').data('totaltrnsprt');
    /*get discount amount*/
    if(customValue <=100){
        /*totalAmount - paidamount*/
        if(transportFare > 0){
            totalAmount =(totalAmount+transportFare);
        }else{
            totalAmount = totalAmount;
        }
        var discountAmount = (totalAmount*customValue)/100;
        /*diduct discount % amount from total.*/
        var amountWithDisc = (totalAmount - discountAmount);

        $('#net-amount').html('Rs. '+amountWithDisc);
        $('#input_total_amount_payable').attr('value',amountWithDisc);
        $('#input_total_discount').val(discountAmount);
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


/*show hide tablis transport and boarding.*/
$(document).on('click','input[name="StudentInfo[is_transport_avail]"]:checked',function () {
    var hostel = $('input[name="StudentInfo[is_hostel_avail]"]:checked').val();
   if($(this).val() == 1 || hostel ==1){
       $('ul[role="tablist"] a#wizard-t-1').show();
   }else{
       $('ul[role="tablist"] a#wizard-t-1').hide();
   }
});

/*show hide tablis hostel and boarding.*/
$(document).on('click','input[name="StudentInfo[is_hostel_avail]"]:checked',function () {
    bustop = $('input[name="StudentInfo[is_transport_avail]"]:checked').val();
    if($(this).val() == 1 || bustop == 1 ){
        $('ul[role="tablist"] a#wizard-t-1').show();
    }else{
        $('ul[role="tablist"] a#wizard-t-1').hide();
    }
});

/*hide step by default.*/
$(document).ready(function () {
    $('ul[role="tablist"] a#wizard-t-1').hide();
});


/*on click of add discount head modal*/
$(document).on('click','#add-discount-head',function (e) {

    var head_amount     = $('#head-amount').val();
    var totalAmount     = $('#total-amount').data('total');
    var hiddenHeadAmt   = $('#hidden-head-amount').val();
    var netAmount       = $('#net-amount').data('net');
    var discountType    = $('#discount-type').val();
    // var transportFare   = $('#total-transport-fare').data('totaltrnsprt');
    var transportFare   = $('#input_total_transport_fare').val();
    //alert(transportFare);
    var hostelFare   = $('#total-hostel-fare').data('totalhostel');
    var radioAmtType    = $('input[name="amount_type"]:checked').val();

    var headId = $('#hidden-head-id').val();
    var headAmt = $('#hidden-head-amount').val();
    var error = 0;
    var total = 0;
    if(head_amount == ''){
        $('#head-amount').closest('.form-group').addClass('has-error');
        $('#head-amount').closest('.form-group').removeClass('has-success');
        $('#head-amount').closest('.form-group').find('.help-block').html('Discount Amount is required.');
        error++;
    }else if(head_amount < 0){
        $('#head-amount').closest('.form-group').addClass('has-error');
        $('#head-amount').closest('.form-group').removeClass('has-success');
        $('#head-amount').closest('.form-group').find('.help-block').html('Discount Amount/percentage must be greater than 0.');
        error++;
    }
    else{
        /*if amount is in percentage or not.*/
        if(radioAmtType == "percent"){
            if(head_amount > 100){
                $('#head-amount').closest('.form-group').addClass('has-error');
                $('#head-amount').closest('.form-group').removeClass('has-success');
                $('#head-amount').closest('.form-group').find('.help-block').html('Percent must be less than 100');
                error++;
            }else{
                $('#head-amount').closest('.form-group').addClass('has-success');
                $('#head-amount').closest('.form-group').removeClass('has-error');
                $('#head-amount').closest('.form-group').find('.help-block').html('');
            }
        }
        else{
            var totalHeadAmount = head_amount;
            if(parseInt(head_amount) > parseInt(hiddenHeadAmt)){
                $('#head-amount').closest('.form-group').addClass('has-error');
                $('#head-amount').closest('.form-group').removeClass('has-success');
                $('#head-amount').closest('.form-group').find('.help-block').html('Amount must be less than total amount.');
                error++;
            }else{
                $('#head-amount').closest('.form-group').addClass('has-success');
                $('#head-amount').closest('.form-group').removeClass('has-error');
                $('#head-amount').closest('.form-group').find('.help-block').html('');
            }
        }

    }
    if(discountType == ''){
        $('#discount-type').closest('.form-group').addClass('has-error');
        $('#discount-type').closest('.form-group').removeClass('has-success');
        $('#discount-type').closest('.form-group').find('.help-block').html('Discount Type is required.');
        error++;
    }else {
        $('#discount-type').closest('.form-group').addClass('has-success');
        $('#discount-type').closest('.form-group').removeClass('has-error');
        $('#discount-type').closest('.form-group').find('.help-block').html('');
    }
    if(error == 0){

        /*sum of prevoius added heads amount.*/
        $('div[id^="show_head_"]').each(function (i,val) {
            var divId = $(this).closest('div').attr('id');
            if(divId != 'show_head_'+headId){
                total +=  parseInt($(this).find('input#head_hidden_discount_amount').val());
            }

        });

        /*if amount is in percentage or not.*/
        if(radioAmtType == "percent"){
            var totalHeadAmount = (headAmt*head_amount/100);
        }else{
            var totalHeadAmount = head_amount;
        }

        /*if head amount is matched*/
        $('div#show_head_'+headId+' #head_hidden_discount_amount').val(Math.round(totalHeadAmount));
        $('div#show_head_'+headId+' span').html('Rs. '+Math.round(totalHeadAmount));
        $('div#show_head_'+headId+' #head_hidden_discount_type').val(discountType);
        /*calculating sum of  current head amount*/
        var mastetTotal =(total += parseInt(Math.round(totalHeadAmount)));
        //console.log(mastetTotal);
        if(transportFare > 0){
            totalAmount =(totalAmount+parseInt(transportFare));
        }
        //console.log(totalAmount);
        //console.log('master total'+mastetTotal);

        if(hostelFare > 0){
            totalAmount =(totalAmount+hostelFare);
        }
        //console.log(totalAmount);
        /*diduct discount % amount from total.*/
        var amountWithDisc = (totalAmount - mastetTotal);
        console.log(totalAmount);
        console.log(mastetTotal);
        console.log(amountWithDisc);

        $('#net-amount').html('Rs. '+Math.round(amountWithDisc));
        $('span.total-discount').html('Rs. '+ Math.round(mastetTotal));
        /*hidden value for form submission.*/
        $('#input_total_amount_payable').attr('value',Math.round(amountWithDisc));
        $('#input_total_discount').val(Math.round(mastetTotal));

        $('#discount-details').modal('hide');
        return false;
    }else{
        return false;
    }
    e.preventDefault();
});
    function transportAdjust(event){
        if(event.keyCode != 8){
            var head_amount     = $('#head-amount').val();
            var totalAmount     = $('#total-amount').data('total');
            var hiddenHeadAmt   = $('#hidden-head-amount').val();
            var netAmount       = $('#net-amount').data('net');
            var discountType    = $('#discount-type').val();
            // var transportFare   = $('#total-transport-fare').data('totaltrnsprt');
            var transportFare   = $('#input_total_transport_fare').val();
            var transportFareLimit   = $('#input_total_transport_fare').data('totaltrnsprt');
            var hostelFare   = $('#total-hostel-fare').data('totalhostel');
            var radioAmtType    = $('input[name="amount_type"]:checked').val();

            var headId = $('#hidden-head-id').val();
            var headAmt = $('#hidden-head-amount').val();
            var error = 0;
            var total = 0;
            var transportnew = 0;
            if(transportFare > transportFareLimit) {
                transportnew = $('#input_total_transport_fare').val(transportFareLimit);
                /*sum of prevoius added heads amount.*/
                $('div[id^="show_head_"]').each(function (i, val) {
                    var divId = $(this).closest('div').attr('id');
                    total += parseInt($(this).find('input#head_hidden_discount_amount').val());

                });


                //console.log(mastetTotal);
                if (transportFareLimit > 0) {
                    totalAmount = (totalAmount + parseInt(transportFareLimit));
                }
                //console.log(totalAmount);
                //console.log('master total'+mastetTotal);

                if (hostelFare > 0) {
                    totalAmount = (totalAmount + hostelFare);
                }
                //console.log(totalAmount);
                /*diduct discount % amount from total.*/
                var amountWithDisc = (totalAmount);
                /* console.log(totalAmount);
                 console.log(amountWithDisc);*/
                //console.log(totalAmount);
                //console.log(amountWithDisc);

                $('#net-amount').html('Rs. ' + Math.round(amountWithDisc));
                /*hidden value for form submission.*/
                $('#input_total_amount_payable').attr('value', Math.round(amountWithDisc));

                return false;
            }else{

                /*sum of prevoius added heads amount.*/
                $('div[id^="show_head_"]').each(function (i,val) {
                    var divId = $(this).closest('div').attr('id');
                    total +=  parseInt($(this).find('input#head_hidden_discount_amount').val());

                });


                //console.log(mastetTotal);
                if(transportFare > 0){
                    totalAmount =(totalAmount+parseInt(transportFare));
                }
                //console.log(totalAmount);
                //console.log('master total'+mastetTotal);

                if(hostelFare > 0){
                    totalAmount =(totalAmount+hostelFare);
                }
                //console.log(totalAmount);
                /*diduct discount % amount from total.*/
                var amountWithDisc = (totalAmount);
               /* console.log(totalAmount);
                console.log(amountWithDisc);*/

                $('#net-amount').html('Rs. '+Math.round(amountWithDisc));
                /*hidden value for form submission.*/
                $('#input_total_amount_payable').attr('value',Math.round(amountWithDisc));
                return false;
            }
            event.preventDefault();
        }
    }

$(document).on('click','input[name="amount_type"]:checked',function(){
    var head_amount   = $('#head-amount');
    if($(this).val() == "percent"){
        head_amount.attr('placeholder','Enter Amount in percentage');
    }else{
        head_amount.attr('placeholder','Enter Currency Amount');
    }
});

$(document).on('change','#hosteldetail-fk_bed_id',function(){
    var bedId       = $(this).val();
    var url         = $(this).data('url');
    var thisData    = $(this);
    var stepGenError = $(this).closest('section').find('#overall-error');
    if(bedId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            data: {bed_id:bedId},
            url: url,
            cache: false,
            success: function(data)
            {
                if(data.status == 1){
                    stepGenError.val(1);
                    thisData.closest('.form-group').addClass('has-error');
                    thisData.closest('.form-group').removeClass('has-success');
                    thisData.closest('.form-group').find('.help-block').html('This Bed has already taken');
                }else{
                    stepGenError.val(0);
                    thisData.closest('.form-group').addClass('has-success');
                    thisData.closest('.form-group').removeClass('has-error');
                    thisData.closest('.form-group').find('.help-block').html('');
                }
            }
        });
    }
});


$(document).ready(function () {
    $('form#admission-form').find(".actions a[href$='#finish']").click(function() {
        alert('sdffd');
        var element = document.getElementById('wizard-p-6');
        html2pdf(element, {
            margin:1,
            padding:0,
            filename: 'myfile.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 2,  logging: true },
            jsPDF: { unit: 'in', format: 'A2', orientation: 'P' },
            class: createPDF
        });
    });
});



