<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\RefSection */
/* @var $form yii\widgets\ActiveForm */
$class = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');

if(yii::$app->request->get('cid')){
    $group = ArrayHelper::map(\app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>yii::$app->request->get('cid'),'status'=>'active'])->all(), 'group_id', 'title');
}else{
    $group=[];
}

?>
<div class="ref-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= (yii::$app->request->get('cid'))?$form->field($model, 'class_id')->hiddenInput(['value'=>yii::$app->request->get('cid')])->label(false):
        $form->field($model, 'class_id')->dropDownList($class, ['prompt' => 'Select Class ...','data-url'=>\yii\helpers\Url::to(['section/get-groups'])]
    )
    ?>

    <?=  $form->field($model, 'fk_group_id')->dropDownList($group, ['prompt' => 'Select Group ...'])->label('Group');

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
