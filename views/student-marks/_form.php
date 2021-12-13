<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentMarks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-marks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'marks_obtained')->textInput() ?>

    <?= $form->field($model, 'fk_exam_id')->textInput() ?>

    <?= $form->field($model, 'fk_student_id')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
