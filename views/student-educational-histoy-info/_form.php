<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentEducationalHistoryInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-educational-history-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'degree_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'degree_type_id')->textInput() ?>

    <?= $form->field($model, 'Institute_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'institute_type_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_marks')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'stu_id')->textInput() ?>

    <?= $form->field($model, 'marks_obtained')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
