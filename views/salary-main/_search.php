<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\SalaryMainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_pay_stages') ?>

    <?= $form->field($model, 'fk_emp_id') ?>

    <?= $form->field($model, 'basic_salary') ?>

    <?= $form->field($model, 'fk_allownces_id') ?>

    <?php // echo $form->field($model, 'bonus') ?>

    <?php // echo $form->field($model, 'fk_deduction_tpe') ?>

    <?php // echo $form->field($model, 'deduction_amount') ?>

    <?php // echo $form->field($model, 'fk_tax_id') ?>

    <?php // echo $form->field($model, 'gross_salary') ?>

    <?php // echo $form->field($model, 'salary_month') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'tax_amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
