<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use app\components\HelperGeneral;
use app\components\UIKit;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['view']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Change Password');
?>

<div class="row">
    <div class="col-md-9">
        <h4 class="mt-0 mb-0 "><b><i class="fa fa-asterisk"></i>  Change Password</b> <small>credentials </small></h4>
    </div>

</div>
<hr class="  mt-4 mb-4 g-brd-gray-light-v4 g-mx-minus-20">

<?php
$form = ActiveForm::begin([
            'id' => 'users-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'tooltipStyleFeedback' => true,
            'fieldConfig' => ['options' => ['class' => 'form-group mb-0 myForm']],
            'formConfig' => ['showErrors' => true],
            'options' => ['style' => 'align-items: flex-start', 'enctype' => 'multipart/form-data']
        ]);
?>
<?= $form->field($model, 'password', ['labelSpan' => 4])->passwordInput(['maxlength' => true, 'value' => 'a']); ?>
<?= $form->field($model, 'verifypassword', ['labelSpan' => 4])->passwordInput(['maxlength' => true]) ?>
<hr class="    mb-3 g-brd-gray-light-v4 g-mx-minus-20">
<div class="form-group text-center">
    <?= Html::submitButton(Yii::t('app', 'Change password'), ['class' => 'btn btn-success btn-lgd pull-rightd mr-3 ']) ?>
</div>

<?php ActiveForm::end(); ?>
  


