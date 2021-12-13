<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentParentsInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-parents-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'stu_parent_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'cnic') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'profession') ?>

    <?php // echo $form->field($model, 'contact_no2') ?>

    <?php // echo $form->field($model, 'stu_id') ?>

    <?php // echo $form->field($model, 'gender_type') ?>

    <?php // echo $form->field($model, 'guardian_name') ?>

    <?php // echo $form->field($model, 'relation') ?>

    <?php // echo $form->field($model, 'guardian_cnic') ?>

    <?php // echo $form->field($model, 'guardian_contact_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
