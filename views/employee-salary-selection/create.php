<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployeeSalarySelection */

$this->title = 'Create Employee Salary Selection';
$this->params['breadcrumbs'][] = ['label' => 'Employee Salary Selections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-salary-selection-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
