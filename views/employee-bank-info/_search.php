<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\EmployeeBankInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-bank-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_emp_id') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?= $form->field($model, 'branch_name') ?>

    <?= $form->field($model, 'branch_code') ?>

    <?php // echo $form->field($model, 'account_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
