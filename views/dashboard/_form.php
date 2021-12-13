<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Dashboard */
/* @var $form yii\widgets\ActiveForm */
$model->status= 1;
?>

<div class="dashboard-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo  $form->field($model, 'fk_branch_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'details')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full'
    ]) ?>  
    <?= $form->field($model, 'type')->dropDownList([ 'graph' => 'Graph', 'links' => 'Links', ], ['prompt' => 'Select box type']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 1 => 'Active', 0 => 'Inactive', ], ['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
