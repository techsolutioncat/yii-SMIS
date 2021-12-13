<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use app\models\SalaryPayGroups;
use app\models\SalaryPayStages;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryAllownces */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-allownces-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'title')->textInput() ?>
    
    <?php $groups = ArrayHelper::map(\app\models\SalaryPayGroups::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($model, 'fk_pay_group')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['placeholder' => 'Select Group ...','data-url'=>Url::to(['salary-allownces/get-stages']),'class'=>'groups'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Group');
     
      ?>
      
      
       <?php 
       if($model->isNewRecord == 1){

        $model->fk_stages_id='';
        $stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($model, 'fk_stages_id')->widget(Select2::classname(), [
                        //'data' => $groups,
                        'options' => ['placeholder' => 'Select stages ...','class'=>'getstage'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }else{

        $stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->all(), 'id', 'title');
                    echo $form->field($model, 'fk_stages_id')->widget(Select2::classname(), [
                        'data' => $stage,
                        'options' => ['placeholder' => 'Select stages ...','class'=>'getstage'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }
     
      ?>
      
      
   

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
