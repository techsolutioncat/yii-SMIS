<?php //echo '<pre>';print_r($checkinOutTable); 

/*foreach ($checkinOutTable as $biomatric) {
	echo $biomatric->USERID;
	echo $biomatric->CHECKTIME;

}*/


?>

<?php 
    $form = ActiveForm::begin();
	foreach ($checkinOutTable as $biomatric) {
		 echo $biomatric->USERID;
		 echo  $form->field($model, 'fk_empl_id')->textInput(['value'=>$biomatric->USERID;])->label(false);

		 echo $biomatric->CHECKTIME;

	}
     ActiveForm::end(); 

     ?>