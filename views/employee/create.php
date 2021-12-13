<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployeeInfo */

$this->title = 'Create Employee';
//$this->params['breadcrumbs'][] = ['label' => 'Employee Info', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="employee-info-create content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen padd">   

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'usermodel' => $usermodel,
        'employeesalaryselection' => $employeesalaryselection,
        'employeesalarydeductiondetail' => $employeesalarydeductiondetail,
        'employeePayroll' => $employeePayroll,
    ]) ?>
	</div>
</div>
