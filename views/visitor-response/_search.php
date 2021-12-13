<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\VisitorResponseInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitor-response-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fk_admission_vistor_id') ?>

    <?= $form->field($model, 'first_attempt_date') ?>

    <?= $form->field($model, 'second_attempt_date') ?>

    <?= $form->field($model, 'third_attempt_date') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
