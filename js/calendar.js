/*function getCalendar(target_div,year,month){
			$.ajax({
				type:'POST',
				url: '<?php echo Yii::$app->request->baseUrl. '/Employee/functions' ?>',
				data:'func=getCalender&year='+year+'&month='+month,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}*/

// pop up
    //----------------------------------employee script ----------------------------------

 // $('[id^=emp]').click(function() {
 //              alert("1111");
 //           });



//$(document).on('click','[id^=emp]', function(){
	$(document).on('click','.popups', function(){
		//alert('here');
		var al=$('#leaveid').val('');
         $('#remarks').val('');
         $('#getValues').empty();
         $('.displayvalidationRemarks').empty();

		var urls = $(this).data('urls');
		//alert(urls);
		var uniqueId=$(this).attr('id');
		//alert(uniqueId);
		$('#unique_id').val(uniqueId);
		//alert(uniqueId);
		var emp_is=$(this).data('empid');
		//alert(emp_is);
		var dataString = '$id='+ emp_is;
        //alert(dataString);
		$('#input_id').val(emp_is);
		//$('div#div_id').text(dataString);
		 
		var d=$(this).data('date');
		$('#input_date').val(d);
		//alert(d);
		//$('div#div_date').text(d);

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
						$('#leaveid').val(msg.type);
						$('#remarks').text(msg.remarks);
						$('#getValues').html(msg.newprovide);
					}else{
						//alert('flase');
					}
					//$(".leaveSelect").html(html);
				}
			});
		
	    });

$(document).on('click','.pop', function(e){
        e.preventDefault();
        var url = $(this).data('url');
		var get_uniqueid=$('#unique_id').val();
		var select=$('.leaveSelect').val();
		var remark=$('.remarks').val();

		var employee= $('.getId').val();
		var getDate= $('.getdate').val();
		var date=$(this).attr('dates');

		 if(select == ""){
              //alert('please fill remarks..');
            }else if(remark == ""){
            $('.displayvalidationRemarks').text("Remarks Field Cannot Be Blank");

            }else{



		$.ajax({
				type:'POST',
				data:{  select:select,
					    remark:remark,
						employee:employee,
						date:date,
						getDate:getDate
					},
				url:'save-leave/',
				success:function(result){
				    console.log(result);
					 $('#'+get_uniqueid).html(result);
					 $('#myModal').modal('hide');


					 // setTimeout(function(){// wait for 5 secs(2)
      //                location.reload(); // then reload the page.(3)
      //                  }, 0);

						//$("#display").after(html);

					//$('a#'+get_uniqueid).closest('span#emp_'+get_uniqueid).text(html);

					
					//$('s#emp_id').closest();
					//var res = get_uniqueid.concat(str2);

					   
				}
			});

	}
	    });


/*$(document).on('click','.closemodel', function(){
	setTimeout(function(){// wait for 5 secs(2)
                     location.reload(); // then reload the page.(3)
                      }, 0);
});*/





/////////// delete employee attendance

$(document).on('click','#deleteEmployee', function(){
		//alert('here');
		var url = $(this).data('urli');
		//alert(url);
		//return flase;
		var uniqueId=$(this).attr('id');
		var emp_is=$(this).data('empid');
		var d=$(this).data('date');

		var ulri=$('a#'+get_uniqueid);
		//alert(d);
		//$('div#div_date').text(d);

		$.ajax({
				type:'POST',
				dataType: "json",
				data:{  emp_is:emp_is,
					    d:d,
					},
				url: url,
				success:function(msg){
					
				}
			});
		
	    });