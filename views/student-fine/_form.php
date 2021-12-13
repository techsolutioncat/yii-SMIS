<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\StudentFineDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-fine-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_fine_typ_id')->widget(Select2::classname(), [
        'data' => Yii::$app->common->getBranchFineType(),
        'options' => ['placeholder' => 'Select Fine Type ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'is_active')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => 'Select Status']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
