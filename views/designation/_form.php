<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;



/* @var $this yii\web\View */
/* @var $model app\models\RefDesignation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-designation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>Yii::$app->common->getBranch()])->label(false) ?>

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>

    <?php
    if($model->isNewRecord == 1){
    $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'fk_department_id')->widget(Select2::classname(), [
                        'data' => $department_array,
                        'options' => ['placeholder' => 'Select Department ...','class'=>'departmentTransport','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }else{
        $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'fk_department_id')->widget(Select2::classname(), [
                        'data' => $department_array,
                        'options' => ['placeholder' => 'Select Department ...','class'=>'departmentTransport','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }

     ?>



  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
