<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?//= $form->field($model,'globalSearch')?> <!-- for global searach -->

    <?= $form->field($model, 'emp_id') ?>
    <?= $form->field($model, 'user_id') ?> 

    <?= $form->field($model, 'fk_branch_id') ?>

    


    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'emergency_contact_no') ?>

    <?php // echo $form->field($model, 'gender_type') ?>

    <?php // echo $form->field($model, 'guardian_type_id') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'province_id') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'hire_date') ?>

    <?php // echo $form->field($model, 'designation_id') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'department_type_id') ?>

    <?php // echo $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'religion_type_id') ?>

    <?php // echo $form->field($model, 'location1') ?>

    <?php // echo $form->field($model, 'Nationality') ?>

    <?php // echo $form->field($model, 'location2') ?>

    <?php // echo $form->field($model, 'cnic') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
