<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\workingdays;

/* @var $this yii\web\View */
/* @var $model app\models\WorkingDays */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="working-days-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="pad"> <br />

    
    <?php
    $workingdays=WorkingDays::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all();
    foreach($workingdays as $wdays){?>
    <div class="row">
    <div class="col-sm-1">

    <input id="workingdaystu" type="checkbox" name="WorkingDays[is_active_stu]" data-url=<?php echo yii\helpers\Url::to(['working-days/stu-day']);?> data-get=<?php echo $wdays->id?> value="yes" <?php echo ($wdays->is_active_stu==1 ? 'checked' : '');?>>

    
    </div>
    <div class="col-md-11">
       
        <?php echo $form->field($model, 'title')->textInput(['value'=>$wdays->title,'readonly'=>'readonly'])->label(false);?>
    </div>
    </div>
    
        
    <?php }?>
    </div><br />
  
    <?php ActiveForm::end(); ?>

</div>
