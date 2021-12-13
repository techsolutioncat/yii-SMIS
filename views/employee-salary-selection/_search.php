<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\EmployeeSalarySelectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-salary-selection-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_emp_id') ?>

    <?= $form->field($model, 'fk_group_id') ?>

    <?= $form->field($model, 'fk_pay_stages') ?>

    <?= $form->field($model, 'fk_allownces_id') ?>

    <?php // echo $form->field($model, 'basic_salary') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
