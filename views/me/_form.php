<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'users-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'tooltipStyleFeedback' => true,
                'fieldConfig' => ['options' => ['class' => 'form-group mb-0 myForm']],
                'formConfig' => ['showErrors' => true],
                'options' => ['style' => 'align-items: flex-start', 'enctype' => 'multipart/form-data']
    ]);

    $form->errorSummary($model);
    ?>


    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_in_urdu')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
 

    
    <?php
//    echo $form->field($model, 'gender')->widget(Select2::classname(), [
//        'data' => HelperGeneral::getGender(),
//        'options' => ['placeholder' => 'Please select '],
//        'pluginOptions' => [ 'allowClear' => true],
//    ]);
    ?>

    
   
    <?php  echo $form->field($model, 'Image')->fileInput() ?>

    <hr class="    mb-3 g-brd-gray-light-v4 g-mx-minus-20 ">
    <div class="form-group text-center mb-0 ">
        <?= Html::submitButton(Yii::t('app', 'Save Profile'), ['class' => 'btn btn-success btn-lgd ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
