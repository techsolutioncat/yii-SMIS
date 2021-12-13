<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\MainSalarySectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-salary-section-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mss_id') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'emp_id') ?>

    <?= $form->field($model, 'ss_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
