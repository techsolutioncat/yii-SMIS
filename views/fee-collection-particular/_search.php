<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\FeeCollectionParticular */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-collection-particular-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_branch_id') ?>

    <?= $form->field($model, 'fk_stu_id') ?>

    <?= $form->field($model, 'total_fee_amount') ?>

    <?= $form->field($model, 'fk_fine_id') ?>

    <?php // echo $form->field($model, 'transport_fare') ?>

    <?php // echo $form->field($model, 'fk_fee_discount_id') ?>

    <?php // echo $form->field($model, 'fee_payable') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
