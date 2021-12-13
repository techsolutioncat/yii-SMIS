<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-info-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'no_of_seats')->textInput() ?>
    <?= $form->field($model, 'vehicle_make')->textInput(['maxlength' => true]) ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>
