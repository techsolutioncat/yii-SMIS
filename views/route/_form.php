<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Zone;

/* @var $this yii\web\View */
/* @var $model app\models\Route */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="route-form">

    <?php $form = ActiveForm::begin();

     $zone=Zone::find()->select('title')->where(['id'=>$_GET['id']])->one();?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fk_zone_id')->hiddenInput(['value'=>$_GET['id']])->label(false); ?>
    <?= $form->field($model, 'zone')->textInput(['value'=>$zone->title,'readonly'=>'readonly']) ?>
    
   <!--  <?/*=   $form->field($model, 'fk_zone_id')->widget(Select2::classname(), [
        'data' => $zone,
        'options' => ['placeholder' => 'Select Zone ...'],
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
