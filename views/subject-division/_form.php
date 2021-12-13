<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Subjects;


/* @var $this yii\web\View */
/* @var $model app\models\SubjectDivision */
/* @var $form yii\widgets\ActiveForm */

$subjects_Array = ArrayHelper::map(Subjects::find()->where(['fk_branch_id'=>'1'])->all(),'id','title');

?>

<div class="subject-division-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
        if(!empty(Yii::$app->request->get('id'))) {
            echo $form->field($model, 'fk_subject_id')->hiddenInput(['value' =>Yii::$app->request->get('id')])->label(false);
        }else {
            echo $form->field($model, 'fk_subject_id')->dropDownList($subjects_Array, ['prompt' => 'Select Subject']);
        }
    ?>

        
         <?php
    if($model->isNewRecord == 1){
        echo $form->field($model, 'status')->hiddenInput(['value'=>'Active'])->label(false);
    }else{
        echo $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => 'Select Status...']);
    }
     

      ?>



	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
