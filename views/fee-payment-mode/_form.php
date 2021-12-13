<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeePaymentMode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-payment-mode-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*echo $form->field($model, 'fk_branch_id')->textInput() */?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_span')->dropDownList([ 1 => '1 month', 2 => '2 months', 3 => '3 months', 4 => '4 months', 5 => '5 months', 6 => '6 months', 7 => '7 months', 8 => '8 months', 9 => '9 months', 10 => '10 months', 11 => '11 months', 12 => '12 months', ], ['prompt' => 'Select No. of month(s)']) ?>

    <div class="alert alert-info">
        <strong>Note!</strong> E.g If you select time span 2 from drop down, It means that title will be calcualted twice a year.
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
