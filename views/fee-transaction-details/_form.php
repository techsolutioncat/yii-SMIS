<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\FeeTransactionDetails */
/* @var $form yii\widgets\ActiveForm */
$feeCollectionArray = ArrayHelper::map(\app\models\FeeCollectionParticular::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'id','id');
?>

<div class="fee-transaction-details-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'stud_id')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchStudents(),
                'options' => ['placeholder' => 'Select Student'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?></div>
        <div class="col-md-6">
            <?= $form->field($model, 'fk_fee_collection_particular')->widget(Select2::classname(), [
                'data' => Yii::$app->common->getBranchFeeDiscounts(),
                'options' => ['placeholder' => 'Select collection Particular ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?></div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'transaction_date')->widget(DatePicker::classname(), [
                'options' => ['value' => date('Y-m-d')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]); ?> 
        </div>
        <div class="col-md-6"><?= $form->field($model, 'transaction_amount')->textInput() ?> </div>
    </div>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'opening_balance')->textInput() ?></div></div>
        <div class="col-md-6"></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
