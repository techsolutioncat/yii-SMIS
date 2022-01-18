$(document).ready(function() {
    var eTable = $('#expense_table').DataTable();
    let $hFom = $('#head_modal_form'); 
    let $successMsg = $(".alert");

    //When click add expense head add button, show reset modal.
    $('#add_expense_head').on('click', function() {
        $('#data_id').val('0');
        $('#expense_head_modal').modal();
    });

    $('#save_head').on('click', function() {
        let head = $('#head');

        if(!head.val().trim())
        {
            head.parent().addClass('has-error');
            return false;
        }

        let head_val = head.val();
        let url = $('#head_modal_form #url').val();
        let id = $('#data_id').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {head: head_val, id: id},
            success: function(success)
            {
                if(success) {
                    $('#head').val('');
                    $('#head').focus();
                    var x = document.getElementById("toast")
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
                }
            }
        });
    });

    $('#head').keyup(function() {
        let val = $(this).val();
        if(val.trim())
            $(this).parent().removeClass('has-error');
        else
            $(this).parent().addClass('has-error');
    });

    //When click add expense add button, show reset modal.
    $('#add_expense').on('click', function() {
        $('#expense_id').val('0');
        $('#expense_amount').val('');
        $('#expense_type').val('personal expenses');
        $('#expense_description').val('');
        let url = $('#get_head_url').val();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(resp)
            {
                let headHTML = '';
                if(resp.length > 0) {
                    $.each(resp, function(key, row) {
                        headHTML += '<option value="'+row.id+'">'+row.head+'</option>';
                    });
                    $('#expense_head').html(headHTML);
                    $('#expense_modal').modal();
                }
            }
        });
    });

    $('#save_expense').on('click', function() {
        let head = $('#expense_head');
        let type = $('#expense_type');
        let amount = $('#expense_amount');
        let description = $('#expense_description');

        if(!amount.val().trim())
        {
            amount.parent().addClass('has-error');
            return false;
        }

        let head_val = head.val();
        let type_val = type.val();
        let amount_val = amount.val();
        let description_val = description.val();
        let url = $('#expense_modal_form #url').val();
        let id = $('#expense_id').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {expense_head_id: head_val, type: type_val, amount: amount_val, description: description_val, id: id},
            success: function(rsp)
            {
                if(rsp) {
                    $('#expense_amount').val('').focus();
                    $('#expense_description').val('').focus();
                    // console.log(rsp['head'], rsp['type'], rsp['amount'], rsp['description'] );
                    // eTable.fnAddData([ '', '', '', '' ]);
                    var x = document.getElementById("toast")
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
                }
            }
        });
    });

    $('#expense_amount').keyup(function() {
        let val = $(this).val();
        if(val.trim())
            $(this).parent().removeClass('has-error');
        else
            $(this).parent().addClass('has-error');
    });
});