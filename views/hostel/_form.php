<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\RefDepartment;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Hostel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hostel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false) ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
    
    <?php
    if($model->isNewRecord ==1){
        $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'department')->widget(Select2::classname(), [
            'data' => $department_array,
            'options' => ['placeholder' => 'Select Department ...','class'=>'department','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }
    else{
        $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'department')->widget(Select2::classname(), [
            'data' => $department_array,
            'options' => ['placeholder' => 'Select Department ...','class'=>'department','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }
    ?>
<?php
     if($model->isNewRecord ==1){
        $model->fk_warden_id="";
     //$warden = ArrayHelper::map(\app\models\User::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_role_id'=>'4'])->all(), 'id', 'first_name');
        echo $form->field($model, 'fk_warden_id')->widget(Select2::classname(), [
            //'data' => Yii::$app->common->getBranchEmployee(),
            'options' => ['placeholder' => 'Select Warden ...','id'=>'getwarden'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
     }
     else{
        //echo $model->fk_warden_id;
        
        $warden = ArrayHelper::map(\app\models\User::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_role_id'=>'4','id'=>$_GET['id']])->all(), 'id', 'first_name');
        echo $form->field($model, 'fk_warden_id')->widget(Select2::classname(), [
        // 'data' => Yii::$app->common->getBranchEmployee(),
        'data'=>$warden,
        'options' => ['placeholder' => 'Select Warden ...','id'=>'getwarden'],
        'pluginOptions' => [
        'allowClear' => true
        ],
        ]);
     }
    ?>

    <?= $form->field($model, 'amount')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
$script= <<< JS

/* ====================  get employee on base of department====*/
    $(".department").change(function()
    {
        var id=$(this).val();
        var url=$(this).data('url');
        var dataString = 'id='+ id;
        $.ajax
        ({
            type: "POST",
            data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
                $("#getwarden").html(html);
            } 
        });
        
    });

/*===================== end of get employee on base of department ======*/

JS;
$this->registerJs($script);
?>