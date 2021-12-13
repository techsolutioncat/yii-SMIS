<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeSalarySelection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-salary-selection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_emp_id')->textInput() ?>

    <?= $form->field($model, 'fk_group_id')->textInput() ?>

    <?= $form->field($model, 'fk_pay_stages')->textInput() ?>

    <?= $form->field($model, 'fk_allownces_id')->textInput() ?>

    <?= $form->field($model, 'basic_salary')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
