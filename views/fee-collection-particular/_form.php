<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\FeeCollectionParticular */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-collection-particular-form">

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
            <?= $form->field($model, 'total_fee_amount')->textInput();?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fine_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchStdFineDetail(),
                'options' => ['placeholder' => 'Select Fine...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_discount_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchFeeDiscounts(),
                'options' => ['placeholder' => 'Select Discount Type ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'transport_fare')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fee_payable')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"> <?= $form->field($model, 'is_active')->dropDownList([ 'yes' => 'Yes', 'no' => 'No'], ['prompt' => 'Select Status']) ?></div>
        <div class="col-md-6">
            <?= $form->field($model, 'due_date')->widget(DatePicker::classname(), [
                'options' => ['value' => date('Y-m-d')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]); ?>
        </div>
    </div>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
