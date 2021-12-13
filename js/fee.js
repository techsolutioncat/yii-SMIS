/**
 * Developed by Ali Abdullah <aliabdullah3x@gmail.com>on 12/9/2016.
 * fee.js
 * for fee related js.
 */


$(document).on('click','#monthly-challan-generator',function () {
    var formGenerator = $('#gen-fee-challan');
    var newForm       = $('#generate-monthly-challan-form');
    var url  = $(this).attr('href');
    newForm.attr('action',url);
    newForm.append('<input type="hidden" name="class_id" value="'+formGenerator.find("#class-id").val()+'"/>');
    newForm.append('<input type="hidden" name="group_id" value="'+formGenerator.find("#group-id").val()+'"/>');
    newForm.append('<input type="hidden" name="section_id" value="'+formGenerator.find("#section-id").val()+'"/>');

    newForm.submit();
    return false;
});


/*transaction-head-amount_ on every head.*/
$(document).on('focusout','input[id^="transaction-head-amount_"]',function(){
    var payVal = $(this).val();
    var totalVal = $(this).attr('placeholder');
    var attrID = $(this).attr('id');
    var headId = attrID.split('_');
    var extraHeadAmt = 0;
    var arrearsid = $('#transaction-head-arrears_'+headId[1]);
    var discountAmt= $('#total-discount').data('totaldiscount');
    // var transportFare = $('#transaction-transport_fare').val();
    var transportFare = $('#input_total_transport_fare').val();
    var hostelFare = $('#input_total_hostel_fare').val();
    var total=0;
    var totalArrears=0;

    if(payVal < 0){
        payVal = totalVal;
    }else{
        payVal.replace('-','');
        payVal = Math.round(payVal);
    }

    if(parseInt(payVal) >= parseInt(totalVal)){
        $(this).css('border-color','red');
        $(this).val(totalVal);
        arrearsid.val(0);

        /*total head arrears*/
        $('input[id^="transaction-head-arrears_"]').each(function(){
            var arrearsValue =  $(this).val();
            if($.isNumeric(arrearsValue)){
                totalArrears +=  parseInt(arrearsValue);
            }
        });


        /*total head paid amount*/
        $('input[id^="transaction-head-amount_"]').each(function(){
            var id      = $(this).attr('id');
            var value   =  $(this).val();
            //alert(singleTotalAmt+'  ' +value);
            if(id != attrID){
                total +=  parseInt(value);
            }

        });

        //console.log(discountVal);
        //var splitValue = id.split("-");

        var masterAmount = (total += parseInt(totalVal));
        if(transportFare !=''){
            masterAmount = (masterAmount += parseInt(transportFare));
        }

        if(hostelFare !=''){
            masterAmount = (masterAmount += parseInt(hostelFare));
        }

        $('tr[id^="extera-head-row-"]').each(function() {
            extraHeadAmt = (extraHeadAmt += parseInt($(this).find('span#total-amount').data('total')));
        });

        masterAmount = (masterAmount +=extraHeadAmt );
        //masterAmount = (masterAmount -= parseInt(discountAmt));
        $('#transaction-amount').val(masterAmount);
        $('#net-amount').attr('data-net',masterAmount);
        $('#net-amount').text('Rs.'+masterAmount);
        $('#total-arrears-amount').val(totalArrears);

    }else{
        $(this).removeAttr('style');
        /*show head arrears.*/
        arrearsid.val(parseInt(totalVal)-parseInt(payVal));
        /*total head paid amount*/
        $('input[id^="transaction-head-amount_"]').each(function(){
            var id= $(this).attr('id');
            var value =  $(this).val();
            //alert(singleTotalAmt+'  ' +value);
            if(id != attrID){
                total +=  parseInt(value);
            }

        });

        /*total head arrears*/
        $('input[id^="transaction-head-arrears_"]').each(function(){
            var arrearsValue =  $(this).val();
            if($.isNumeric(arrearsValue)){
                totalArrears +=  parseInt(arrearsValue);
            }
        });

        //console.log(discountVal);
        //var splitValue = id.split("-");

        var masterAmount = (total += parseInt(payVal));
        if(transportFare !=''){
            masterAmount = (masterAmount += parseInt(transportFare));
        }

        if(hostelFare !=''){
            masterAmount = (masterAmount += parseInt(hostelFare));
        }

        $('tr[id^="extera-head-row-"]').each(function() {
            extraHeadAmt = (extraHeadAmt += parseInt($(this).find('span#total-amount').data('total')));
        });

        masterAmount = (masterAmount +=extraHeadAmt );
        //masterAmount = (masterAmount -= parseInt(discountAmt));
        $('#transaction-amount').val(masterAmount);
        $('#net-amount').attr('data-net',masterAmount);
        $('#net-amount').text('Rs.'+masterAmount);
        $('#total-arrears-amount').val(totalArrears);
    }

});
/* class fee group by salman*/
$(document).on('click','.classFeeGroup',function(){
    var classid=$(this).data('id');
    var url=$(this).data('url');
    //alert(url);
    $.ajax({
            type: "POST",
            dataType:"JSON",
            data: {classid:classid},
            url: url,
            cache: false,
            success: function(result){
               // alert('result');
                //console.log(result.id);
                //$('#sucmsg').text(result);
                $('.feeHeadsDetails').html(result.details);
                //$(".floorAjax").html(result);
            }
    });
});

/* adding fee extra head*/
$(document).on('click','#add-extra-fee-head',function () {
    $('#ex_head').val('');
    $('#ex_head_amount').val('');
   $('#modal-extera-head').modal('show');
});

/* save and add to tds fee extra head*/
$(document).on('click','#save-extra-fee-head',function () {
    var head = $('#ex_head');
    var headAmount = $('#ex_head_amount');
    var error = 0;
    var extraHeadAmt = 0;
    var totalHeadAmounts=0;
    var totalArrears= 0;
    var transportFare = $('#input_total_transport_fare').val();
    var hostelFare = $('#input_total_hostel_fare').val();
    var html='';
    if(head.val() == ''){
        $('#ex_head').css({'border-color':'red'});
        error++;
    }else{
        head.removeAttr('style');
    }

    if(headAmount.val()== ''){
        headAmount.css('border-color','red');
        error++;
    }else{
        if(headAmount.val() <= 0){
            headAmount.css('border-color','red');
            error++;
        }else{
            headAmount.removeAttr('style');
        }
    }
    if(error == 0){
        /*total head amount.*/
        $('input[id^="transaction-head-amount_"]').each(function(){
            var id= $(this).attr('id');
            var value =  $(this).val();
            //alert(singleTotalAmt+'  ' +value);
            totalHeadAmounts +=  parseInt(value);
        });

        console.log(totalHeadAmounts);
        /*total head arrears*/
        $('input[id^="transaction-head-arrears_"]').each(function(){
            var arrearsValue =  $(this).val();
            if($.isNumeric(arrearsValue)){
                totalArrears +=  parseInt(arrearsValue);
            }
        });



            html += "<tr id='extera-head-row-"+head.val()+"'>";
            html += "<th colspan='2'></th>";
            html += "<th colspan='1'><span class='res_total'>"+$('#ex_head :selected').text().toUpperCase()+"</span></th>";
            html += "<td colspan='1'><span class='res_total' id='total-amount' data-total="+parseInt(headAmount.val())+">Rs. "+parseInt(headAmount.val())+" </span> <i class='ext-head-remove fa fa-times' aria-hidden='true' id='remove-this-head' data-headid='"+$('#ex_head :selected').val()+"'></i>";
            html += "<input type='hidden' name='transaction_head_amount["+head.val()+"]' value="+parseInt(headAmount.val())+" /> </td>";
            html += "</tr>";
        $('tr#amount-payable').before(html);
        /*disable the selected head*/
        $('#ex_head :selected').attr('disabled',true)
        $('#modal-extera-head').modal('hide');
        $('tr[id^="extera-head-row-"]').each(function() {
            extraHeadAmt = (extraHeadAmt += parseInt($(this).find('span#total-amount').data('total')));
        });
        console.log(extraHeadAmt);
        //console.log(totalHeadAmounts);
        var totalAmtWithExtraHead = parseInt(extraHeadAmt)+parseInt(totalHeadAmounts);
        //console.log(totalAmtWithExtraHead);
        if(transportFare !=''){
            totalAmtWithExtraHead = (totalAmtWithExtraHead += parseInt(transportFare));
        }

        if(hostelFare !=''){
            totalAmtWithExtraHead = (totalAmtWithExtraHead += parseInt(hostelFare));
        }
        $('#transaction-amount').val(totalAmtWithExtraHead);
        $('#net-amount').attr('data-net',totalAmtWithExtraHead);
        $('#net-amount').attr('data-net',totalAmtWithExtraHead);
        /*hidden value for form submission.*/
        $('#input_total_amount_payable').attr('value',Math.round(totalAmtWithExtraHead));
        $('#net-amount').text('Rs.'+totalAmtWithExtraHead);
        }else{
            return false;
        }
});

/*remove added extra head*/
$(document).on('click','#remove-this-head',function () {
    var headId          = $(this).data('headid');
    var transectionAmt  = $('#transaction-amount').val();
    var netAmount = $('#net-amount').data('net');
    var thisHeadAmt     = $(this).closest('tr').find('span#total-amount').data('total');
    var totalAmtWithExtraHead = parseInt(transectionAmt)-parseInt(thisHeadAmt);

    $('#ex_head option[value="'+headId+'"]').removeAttr('disabled');
    $('#transaction-amount').val(totalAmtWithExtraHead);
    $('#net-amount').attr('data-net',totalAmtWithExtraHead);
    $('#net-amount').text('Rs.'+totalAmtWithExtraHead);
    $('#input_total_amount_payable').attr('value',Math.round(totalAmtWithExtraHead));
    $(this).closest('tr').remove();
});

/*do not allow - input on key press*/
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}


/*allow fee discount in fee generator*/
/*on click of add discount head modal*/
$(document).on('click','#add-discount-head',function (e) {
    var head_amount     = $('#head-amount').val();
    var totalAmount     = $('#net-amount').data('net');
    var hiddenHeadAmt   = $('#hidden-head-amount').val();
    var transportFare   = $('#input_total_transport_fare').data('totaltrnsprt');
    var netAmount       = $('#net-amount').data('net');
    var discountType    = $('#discount-type').val();
    var hostelFare      = $('#input_total_hostel_fare').data('totalhostel');
    var radioAmtType    = $('input[name="amount_type"]:checked').val();
    var totalArrears    = 0;
    var headId = $('#hidden-head-id').val();
    var headAmt = $('#hidden-head-amount').val();
    var error = 0;
    var total = 0;
    var totalHeadAmounts= 0;
    var oldArearsVal = $('input[name="transaction_head_arrears_amount['+headId+']"]').val();



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

        //console.log(totalHeadAmounts);

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
        /*applying amount to head with discount*/
        $('input[name="transaction_head_amount['+headId+']"]').val(Math.round(headAmt-totalHeadAmount));
        $('input[name="transaction_head_amount['+headId+']"]').attr('placeholder',(Math.round(headAmt-totalHeadAmount)));


        /*total head amount.*/
        $('input[name^="transaction_head_amount["]').each(function(){
            var id= $(this).attr('id');
            var value =  $(this).val();
            //alert(singleTotalAmt+'  ' +value);
            totalHeadAmounts +=  parseInt(value);
            //console.log(value);

        });
        //console.log(mastetTotal);
        if(transportFare > 0){
            totalHeadAmounts =(totalHeadAmounts+transportFare);
        }
        //console.log(totalAmount);
        //console.log('master total'+mastetTotal);
        //console.log('master total'+netAmount);

        if(hostelFare > 0){
            totalHeadAmounts =(totalHeadAmounts+hostelFare);
        }
        //console.log(totalAmount);
        /*diduct discount % amount from total.*/
        var amountWithDisc = (totalAmount - mastetTotal);
        //console.log(totalAmount);
        //console.log(mastetTotal);
        //console.log(amountWithDisc);


//transaction_head_arrears_amount[6]
        /*if arrears alrady applied make it zero*/
        $('input[name="transaction_head_arrears_amount['+headId+']"]').val(0);
        /*getting rest of arrears and than it will deduct from grantal*/

        $('input[id^="transaction-head-arrears_"]').each(function(){
            var arrearsValue =  $(this).val();
            if($.isNumeric(arrearsValue)){
                totalArrears +=  parseInt(arrearsValue);
            }
        });

        //console.log(totalAmount+'------'+mastetTotal);
        $('#net-amount').html('Rs. '+Math.round(totalHeadAmounts));
        $('#net-amount').attr('data-net',Math.round(totalHeadAmounts));
        $('span.total-discount').html('Rs. '+ Math.round(mastetTotal));
        /*hidden value for form submission.*/
        $('#input_total_amount_payable').attr('value',Math.round(totalHeadAmounts));
        $('#input_total_discount').val(Math.round(mastetTotal));
        $('#discount_row').removeAttr('style');
        $('#total-arrears-amount').val(totalArrears);
        $('#transaction-amount').val(Math.round(totalHeadAmounts));
        $('#discount-details').modal('hide');
        return false;
    }else{
        return false;
    }
    e.preventDefault();
});

$(document).on('click','input[name="amount_type"]:checked',function(){
    var head_amount   = $('#head-amount');
    if($(this).val() == "percent"){
        head_amount.attr('placeholder','Enter Amount in percentage');
    }else{
        head_amount.attr('placeholder','Enter Currency Amount');
    }
});

/*adjust transport*/
function transportAdjust(event){
    if(event.keyCode != 8){
        var totalAmount     = $('#net-amount').data('net');
        var transportFare   = $('#input_total_transport_fare').val();
        var transportFareLimit   = $('#input_total_transport_fare').data('totaltrnsprt');
        var discountType    = $('#discount-type').val();
	var hostelFare      = $('#total-hostel-fare').data('totalhostel');
        var totalArrears    = 0;
        var headId = $('#hidden-head-id').val();
        var error = 0;
        var total = 0;
        var totalHeadAmounts= 0;
        var oldArearsVal = $('input[name="transaction_head_arrears_amount['+headId+']"]').val();

        if(transportFare > transportFareLimit){
            error++;
        }
        if(error == 0){

            //console.log(totalHeadAmounts);

            /*sum of prevoius added heads amount.*/
            $('div[id^="show_head_"]').each(function (i,val) {
                var divId = $(this).closest('div').attr('id');
                total +=  parseInt($(this).find('input#head_hidden_discount_amount').val());

            });


            /*total head amount.*/
            $('input[name^="transaction_head_amount["]').each(function(){
                var id= $(this).attr('id');
                var value =  $(this).val();
                //alert(singleTotalAmt+'  ' +value);
                totalHeadAmounts +=  parseInt(value);
                //console.log(value);

            });
            if(transportFare > 0){
                totalHeadAmounts =(totalHeadAmounts+ parseInt(transportFare));
            }
            //console.log(totalAmount);
            //console.log('master total'+netAmount);

            if(hostelFare > 0){
                totalHeadAmounts =(totalHeadAmounts+parseInt(hostelFare));
            }
            //console.log(totalAmount);
            /*diduct discount % amount from total.*/
            var amountWithDisc = (totalAmount);
            //console.log(totalAmount);
            //console.log(mastetTotal);
            //console.log(amountWithDisc);


            /*if arrears alrady applied make it zero*/
            $('input[name="transaction_head_arrears_amount['+headId+']"]').val(0);
            /*getting rest of arrears and than it will deduct from grantal*/

            $('input[id^="transaction-head-arrears_"]').each(function(){
                var arrearsValue =  $(this).val();
                if($.isNumeric(arrearsValue)){
                    totalArrears +=  parseInt(arrearsValue);
                }
            });

            //console.log(totalAmount+'------'+mastetTotal);
            $('#net-amount').html('Rs. '+Math.round(totalHeadAmounts));
            $('#net-amount').attr('data-net',Math.round(totalHeadAmounts));
            /*hidden value for form submission.*/
            $('#input_total_amount_payable').attr('value',Math.round(totalHeadAmounts));
            $('#total-arrears-amount').val(totalArrears);
            $('#transaction-amount').val(Math.round(totalHeadAmounts));
            $('#discount-details').modal('hide');
            return false;
        }else{
            return false;
        }
        event.preventDefault();
    }
}


/*hostel adjust*/
function hostelAdjust(event){
    if(event.keyCode != 8){
        var totalAmount          = $('#net-amount').data('net');
        var transportFare        = $('#input_total_hostel_fare').val();
        var transportFareLimit   = $('#input_total_hostel_fare').data('totalhostl');
        var discountType    = $('#discount-type').val();
        var hostelFare      = $('#total-hostel-fare').data('totalhostel');
        var totalArrears    = 0;
        var headId = $('#hidden-head-id').val();
        var error = 0;
        var total = 0;
        var totalHeadAmounts= 0;
        var oldArearsVal = $('input[name="transaction_head_arrears_amount['+headId+']"]').val();

        if(transportFare > transportFareLimit){
            error++;
        }
        if(error == 0){

            //console.log(totalHeadAmounts);

            /*sum of prevoius added heads amount.*/
            $('div[id^="show_head_"]').each(function (i,val) {
                var divId = $(this).closest('div').attr('id');
                total +=  parseInt($(this).find('input#head_hidden_discount_amount').val());

            });


            /*total head amount.*/
            $('input[name^="transaction_head_amount["]').each(function(){
                var id= $(this).attr('id');
                var value =  $(this).val();
                //alert(singleTotalAmt+'  ' +value);
                totalHeadAmounts +=  parseInt(value);
                //console.log(value);

            });
            if(transportFare > 0){
                totalHeadAmounts =(totalHeadAmounts+ parseInt(transportFare));
            }
            //console.log(totalAmount);
            //console.log('master total'+netAmount);

            if(hostelFare > 0){
                totalHeadAmounts =(totalHeadAmounts+parseInt(hostelFare));
            }
            //console.log(totalAmount);
            /*diduct discount % amount from total.*/
            var amountWithDisc = (totalAmount);
            //console.log(totalAmount);
            //console.log(mastetTotal);
            //console.log(amountWithDisc);


            /*if arrears alrady applied make it zero*/
            $('input[name="transaction_head_arrears_amount['+headId+']"]').val(0);
            /*getting rest of arrears and than it will deduct from grantal*/

            $('input[id^="transaction-head-arrears_"]').each(function(){
                var arrearsValue =  $(this).val();
                if($.isNumeric(arrearsValue)){
                    totalArrears +=  parseInt(arrearsValue);
                }
            });

            //console.log(totalAmount+'------'+mastetTotal);
            $('#net-amount').html('Rs. '+Math.round(totalHeadAmounts));
            $('#net-amount').attr('data-net',Math.round(totalHeadAmounts));
            /*hidden value for form submission.*/
            $('#input_total_amount_payable').attr('value',Math.round(totalHeadAmounts));
            $('#total-arrears-amount').val(totalArrears);
            $('#transaction-amount').val(Math.round(totalHeadAmounts));
            $('#discount-details').modal('hide');
            return false;
        }else{
            return false;
        }
        event.preventDefault();
    }
}

/*advance payment for fee generator.*/
/*$(document).on('focusout','#input_total_advance_fee',function(){
    alert('wrw');
    var advanceAmount   = $(this).val();
    var remainingAmount = $('#input_total_remaining_fare');
    var netAmount       = $('#net-amount').data('net');
    var transectionAmount  = $('#transaction-amount');
    var totalRemainingAmt = advanceAmount - netAmount;
    if(advanceAmount > netAmount){
        $(this).closest('.form-group').removeClass('has-error');
        $(this).closest('.form-group').addClass('has-success');
        $(this).closest('.form-group').find('.help-block').html('');

        remainingAmount.val(totalRemainingAmt);
        $('#ramaining-advance-fee').show();
        /!*remaining amount.*!/
    }else{
        $(this).closest('.form-group').removeClass('has-success');
        $(this).closest('.form-group').addClass('has-error');
        $(this).closest('.form-group').find('.help-block').html('Advance payment must be greater than Amount Payable.');
        remainingAmount.val(0);
        $('#ramaining-advance-fee').hide();
    }
});*/

/*advance payment for fee generator ends.*/