<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\FeeTransactionDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-transaction-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'challan_no') ?>

    <?= $form->field($model, 'stud_id') ?>

    <?= $form->field($model, 'fk_fee_collection_particular') ?>

    <?= $form->field($model, 'transaction_date') ?>

    <?php // echo $form->field($model, 'opening_balance') ?>

    <?php // echo $form->field($model, 'transaction_amount') ?>

    <?php // echo $form->field($model, 'fk_branch_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
