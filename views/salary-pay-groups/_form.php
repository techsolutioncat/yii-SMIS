<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryPayGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-pay-groups-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    if($model->isNewRecord == 1){
     echo $form->field($model, 'created_date')->textInput(['value'=>date("Y-m-d H:i:s"),'readonly'=>'readonly']);
     }else{
        
     }

         ?>
     
        
    <?php 
    if($model->isNewRecord == 1){
        $form->field($model, 'updated_date')->hiddenInput()->label(false);
    }else{
       echo  $form->field($model, 'updated_date')->textInput(['value'=>date("Y-m-d H:i:s"),'readonly'=>'readonly']);
     $status= ['1' => 'Active','0' => 'Inactive'];
     echo Html::label('Status');
     echo Html::activeDropDownList($model, 'status',$status,['class'=>'form-control']);
    }
    ?>

  <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false) ?>
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
