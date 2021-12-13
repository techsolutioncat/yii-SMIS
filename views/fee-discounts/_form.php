<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\FeeDiscounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-discounts-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_discounts_type_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchDiscountType(),
                'options' => ['placeholder' => 'Select Discount Type ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_particular_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchFeeParticulars(),
                'options' => ['placeholder' => 'Select Fee Particular ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"> <?= $form->field($model, 'is_active')->dropDownList([ 'yes' => 'Yes', 'no' => 'No'], ['prompt' => 'Select Status']) ?></div>


        <div class="col-md-6">

        </div>
    </div>











  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
