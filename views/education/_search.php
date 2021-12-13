<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\EmplEducationalHistoryInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-educational-history-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'edu_history_id') ?>

    <?= $form->field($model, 'fk_branch_id') ?>

    <?= $form->field($model, 'degree_name') ?>

    <?= $form->field($model, 'degree_type_id') ?>

    <?= $form->field($model, 'Institute_name') ?>

    <?php // echo $form->field($model, 'institute_type_id') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'total_marks') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'emp_id') ?>

    <?php // echo $form->field($model, 'marks_obtained') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
