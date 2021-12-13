<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Hostel;


/* @var $this yii\web\View */
/* @var $model app\models\HostelFloor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hostel-floor-form">

    <?php $form = ActiveForm::begin(); ?>
	<?php 
     $hostelFloor=Hostel::find()->select('Name')->where(['id'=>$_GET['id']])->one();
	 
    ?> 
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?php if($model->isNewRecord != 1){
        
    }else{
        echo $form->field($model, 'fk_hostel_info_id')->hiddenInput(['value'=>$_GET['id']])->label(false);
        echo $form->field($model, 'hostel')->textInput(['value'=>$hostelFloor->Name,'readonly'=>'readonly']);
    }
    ?>

     <!-- <?/*=   $form->field($model, 'fk_hostel_info_id')->widget(Select2::classname(), [
        'data' => $hostelFloor,
        'options' => ['placeholder' => 'Select Hostel ...'],
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
