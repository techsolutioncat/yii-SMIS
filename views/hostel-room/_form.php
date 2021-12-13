<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\HostelFloor;


/* @var $this yii\web\View */
/* @var $model app\models\HostelRoom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hostel-room-form">

    <?php $form = ActiveForm::begin(); ?>

  <?php

     $hostelRoom = HostelFloor::find()->select('title')->where(['id'=>$_GET['id']])->one();
   ?> 

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php if($model->isNewRecord != 1){
        //echo $form->field($model, 'fk_FLOOR_id')->textInput();
        }else{
            echo $form->field($model, 'Hostel_floor')->textInput(['value'=>$hostelRoom->title,'readonly'=>'readonly']);
             echo $form->field($model, 'fk_FLOOR_id')->hiddenInput(['value'=>$_GET['id']])->label(false);
             } ?>
    
   

    <!--  <?/*= $form->field($model, 'fk_FLOOR_id')->widget(Select2::classname(), [
        'data' => $hostelRoom,
        'options' => ['placeholder' => 'Select Hostel Floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);*/?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
