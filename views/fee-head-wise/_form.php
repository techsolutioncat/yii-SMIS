<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeeHeadWise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fee-head-wise-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_branch_id')->textInput() ?>

    <?= $form->field($model, 'fk_stu_id')->textInput() ?>

    <?= $form->field($model, 'fk_fee_particular_id')->textInput() ?>

    <?= $form->field($model, 'payment_received')->textInput() ?>

    <?= $form->field($model, 'is_paid')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'fk_chalan_id')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
