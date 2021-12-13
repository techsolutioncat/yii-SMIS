 

 // ----- student calendar script -----




$(document).on('click','.studentAttendance', function(){
		//alert('here');
        var al=$('#leaveid').val('');
         $('#remarks').val('');
         $('#getValues').empty();
         $('.displayvalidationRemarks').empty();
        //alert(al);
		var urls = $(this).data('urls');
		var emp_is=$(this).data('empid');
		var uniqueId=$(this).attr('id');
		$('#unique_id').val(uniqueId);
        //$('#unique_id').empty();
		$('#input_stu_id').val(emp_is);
		var dataString = '$id='+ emp_is;
		var d=$(this).data('date');
		$('#input_stu_date').val(d);
        var getName=$(this).data('stu_name');
        $('#input_nameStu').val(getName);
		$.ajax({
				type:'POST',
				dataType: "json",
				data:{  emp_is:emp_is,
					    d:d,
					},
				url: urls,
                
				success:function(msg){
					if(msg){
						//alert('ok');
						//console.log(msg);
						//alert(msg.type);
						// $('#leaveid').val(msg.type);
						// $('#remarks').text(msg.remarks);
						//$('#getValues').html(msg.newprovide);
						$('#leaveid').val(msg.type);
						$('#remarks').val(msg.remarks);
						$('#getValues').html(msg.newprovide);
						//console.log(getValues);
					}else{
						//alert('flase');
					}
					//$(".leaveSelect").html(html);
				}
			});
		
		
	    });
    
    $(document).on('click','.student_pop', function(e){
             e.preventDefault();
    		var url = $(this).data('url'); 
    		var get_uniqueid=$('#unique_id').val();
    		var select=$('.leaveSelect').val(); 
    		var remark=$('.remarks').val(); 
    		var student= $('.getId').val(); 
    		var getDate= $('.getdate').val(); 
    		var date=$(this).attr('dates');
            var nameStu=$('#input_nameStu').val();
    		 if(select == ""){
                   //alert('please fill Leave Type..');
    
                }else if(remark == ""){
                		//alert('please fill remarks..');
                        $('.displayvalidationRemarks').text("Remarks Field Cannot Be Blank");
                		//return false;
                        //$('#myModal').modal('show');
                }else{
    		$.ajax({
    				type:'POST',
    				data:{  select:select,
    					    remark:remark,
    						student:student,
    						date:date,
    						getDate:getDate,
                            nameStu:nameStu
    					},
    				url:'save-leave/',
                    timeout: 2000,
                    cache: false,
    				success:function(result){
    					//console.log(result);     
                       //$('#'+get_uniqueid).append(JSON.stringify(result));
                      // $('.policies'+get_uniqueid).hide();
                         //$('.leaveid').val(result).hide();
    					 $('#'+get_uniqueid).html(result);
                        // window.setTimeout(0);
    					 $('#myModal').modal('hide');//
    					//alert('ok');
    					//$("#div1").html(result);
    			       //setTimeout(function(){// wait for 5 secs(2)
                        // location.reload(); // then reload the page.(3)
                        //  }, 0);
         //window.setTimeout(function (){ long_running('#status_ok') }, 0);
    				}
    			});
    
    	}
    	    });
    
    $(document).on('click','.closemodel', function(){
        //$('.studentAttendance').empty();
    	// setTimeout(function(){// wait for 5 secs(2)
     //                     location.reload(); // then reload the page.(3)
     //                      }, 0);
    });
    
    $(document).on('click','.emps_', function(){
    	alert('adsf');
    });