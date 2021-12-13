<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\RefGroup */
/* @var $form yii\widgets\ActiveForm */


$class = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active','class_id'=>$_GET['id']])->all(), 'class_id', 'title');

?>

<div class="ref-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_class_id')->widget(Select2::classname(), [
        'data' => $class,
        'options' => [],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

   
    <?php
    if($model->isNewRecord == 1){
        echo $form->field($model, 'status')->hiddenInput(['value'=>'Active'])->label(false);
    }else{
       echo  $form->field($model, 'status')->dropDownList(['active'=>'Active','inactive'=>'Inactive'],['prompt'=>'Select Status']);
    }
     

      ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
