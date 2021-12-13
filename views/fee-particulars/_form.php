<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\FeeParticulars */
/* @var $form yii\widgets\ActiveForm */

//getBranchFeeHead
?>

<div class="fee-particulars-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fk_stu_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchStudents(),
                'options' => ['placeholder' => 'Select Student ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_plan_type')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchFeePlan(),
                'options' => ['placeholder' => 'Select Fee Plan ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_head_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchFeeHead(),
                'options' => ['placeholder' => 'Select Fee Head ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'is_paid')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => 'Select Status...']) ?>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
