<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeeDiscountTypes */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if ($model->isNewRecord) {
    $model->is_active = 1;
}
?>
<div class="fee-discount-types-form">

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6"> <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"> <?= $form->field($model, 'is_active')->dropDownList([ 1 => 'Yes', 0 => 'No'], ['prompt' => 'Select Status']) ?></div>

    </div>
    <div class="row">
        <div class="col-md-12"> <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?></div>

    </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
        </div>
    <?php } ?>

<?php ActiveForm::end(); ?>

</div>
