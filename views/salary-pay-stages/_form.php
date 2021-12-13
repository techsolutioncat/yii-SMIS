<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\SalaryPayGroups;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryPayStages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-pay-stages-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $groups=SalaryPayGroups::find()->All();?>
    
      <?php $groups = ArrayHelper::map(\app\models\SalaryPayGroups::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($model, 'fk_pay_groups')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['placeholder' => 'Select Group ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Group');
     
      ?>
                
                

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>
    
  <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false) ?>

    <?php 
    if($model->isNewRecord != 1){
      
     $status= ['1' => 'Active','0' => 'Inactive'];
     echo Html::label('Status');
     echo Html::activeDropDownList($model, 'status',$status,['class'=>'form-control']);
    }
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
