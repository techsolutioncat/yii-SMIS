<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeInfo */

$this->title = 'Update Employee: ' . $model->user->first_name.' '.$model->user->last_name;
//$this->params['breadcrumbs'][] = ['label' => 'Employee Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->emp_id, 'url' => ['view', 'id' => $model->emp_id]];
//$this->params['breadcrumbs'][] = 'Update';
?> 
<div class="employee-info-update content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen padd">  

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'usermodel' => $usermodel,
        'employeesalaryselection'=>$employeesalaryselection,
        'employeesalarydeductiondetail'=>$employeesalarydeductiondetail,
        'employeePayroll' => $employeePayroll,

    ]) ?>

</div>
</div>