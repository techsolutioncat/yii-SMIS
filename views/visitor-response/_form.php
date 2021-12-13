<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\VisitorResponseInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitor-response-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_admission_vistor_id')->hiddenInput(['value'=>$_GET['id']])->label(false); ?>

    <?php 
    if($model->isNewRecord!='1'){
                  echo $form->field($model, 'first_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                     ]
                 ]);

                 }else{
                   echo $form->field($model, 'first_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+7 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }
     ?>

    
     <?php 
    if($model->isNewRecord!='1'){
                  echo $form->field($model, 'second_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                         //'endDate' => '+7d',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }else{
                   echo $form->field($model, 'second_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+14 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }
     ?>

    <?php

    if($model->isNewRecord!='1'){
                  echo $form->field($model, 'third_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }else{
                   echo $form->field($model, 'third_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+21 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }
     ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
