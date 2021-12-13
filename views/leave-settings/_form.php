<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeaveSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'allowed_leaves')->textInput(['maxlength' => true]) ?>

    <?php echo '<h3 style="color:blue;font-weight:bold">'.$this->title = 'Policy'.'</h3>'; ?>

    <?= $form->field($model, 'shortleave_policy')->textInput(['maxlength' => true,'placeholder'=>'Note:If Your input is 2 it means 2 short leave = 1 leave']) ?>

    <?= $form->field($model, 'latecommer_policy')->textInput(['maxlength' => true,'placeholder'=>'Note:If Your input is 6 it means 6 late comming = 1 leave']) ?>

   <?= $form->field($model, 'branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false) ?>

    <?php
    if($model->isNewRecord == 1){
     echo $form->field($model, 'status')->hiddenInput(['value'=>1])->label(false);

    }else{

     echo Html::label('Status');
     $a= ['1' => 'Active','2' => 'Inactive'];
    echo Html::activeDropDownList($model, 'status',$a,['class'=>'form-control']);

    }
   

    ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


