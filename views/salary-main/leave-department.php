<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\RefDepartment;
use app\models\User;
use yii\helpers\ArrayHelper;
?>
<title>Employee Salary Slip</title>
<div class="hostel-form">
<div class="exam-form free-generator content_col grey-form">
	<h1 class="p_title">Pay Slip Generator</h1>
    <?php $form = ActiveForm::begin(); ?>
    <!-- <div style="height: 30px"></div> -->
    <div class="form-center shade fee-gen"> 
    <div class="row">
            <div class="col-sm-5 col-md-6 col-lg-5 rg_item col-sm-offset-2">


	<?php

	$department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');

	        echo $form->field($model, 'department')->widget(Select2::classname(), [
	            'data' => $department_array,
	            'options' => ['placeholder' => 'Select Department ...','id'=>'departmentSalary','data-url'=>\yii\helpers\Url::to(['salary-main/get-employee'])],
	            'pluginOptions' => [
	                'allowClear' => true
	            ],
	        ]);

	 ?>
	
 	  </div>
 	  </div>
 	  </div>
    <div class="row getEmployees"></div>
    

<?php ActiveForm::end(); ?>

    </div>
 </div>