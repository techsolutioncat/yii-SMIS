<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Route;

/* @var $this yii\web\View */
/* @var $model app\models\Stop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stop-form">

    <?php $form = ActiveForm::begin();
    $route = Route::find()->select('title')->where(['id'=>$_GET['id']])->one();
     ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php if($model->isNewRecord != 1){
    }else{
    echo $form->field($model, 'fk_route_id')->hiddenInput(['value'=>$_GET['id']])->label(false);
    echo $form->field($model, 'route')->textInput(['value'=>$route->title,'readonly'=>'readonly']);  
    }?>

    <?= $form->field($model, 'fare')->textInput() ?>
    <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
