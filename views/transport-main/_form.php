<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\VehicleInfo;
use app\models\Zone;


/* @var $this yii\web\View */
/* @var $model app\models\TransportMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transport-main-form">

    <?php $form = ActiveForm::begin();

    $route = ArrayHelper::map(\app\models\Route::find()->all(), 'id', 'title');

    $vehicle = ArrayHelper::map(\app\models\VehicleInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'Name');

    $zone = ArrayHelper::map(\app\models\Zone::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'title');

    $driver = ArrayHelper::map(\app\models\User::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'first_name');

       echo $form->field($model, 'zone')->widget(Select2::classname(), [
                        'data' => $zone,
                        'options' => ['placeholder' => 'Select Zone ...','class'=>'zoneDepend','data-url'=>\yii\helpers\Url::to(['transport-main/get-route'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    

    echo $form->field($model, 'fk_route_id')->widget(Select2::classname(), [
        //'data' => $route,
        'options' => ['placeholder' => 'Select Route ...','class'=>'getRout'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);


    if($model->isNewRecord == 1){
$department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'departments')->widget(Select2::classname(), [
                        'data' => $department_array,
                        'options' => ['placeholder' => 'Select Department ...','class'=>'departmentTransport','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }else{
        $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
        echo $form->field($model, 'departments')->widget(Select2::classname(), [
                        'data' => $department_array,
                        'options' => ['placeholder' => 'Select Department ...','class'=>'departmentTransport','data-url'=>\yii\helpers\Url::to(['hostel/get-warden'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }
    
    if($model->isNewRecord == 1){
        echo $form->field($model, 'fk_driver_id')->widget(Select2::classname(), [
        //'data' => $driver,
        'options' => ['placeholder' => 'Select Driver ...','id'=>'getwarden'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    }else{
        $driver = ArrayHelper::map(\app\models\User::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'id'=>$_GET['id']])->all(), 'id', 'first_name');
        echo $form->field($model, 'fk_driver_id')->widget(Select2::classname(), [
        'data' => $driver,
        'options' => ['placeholder' => 'Select Driver ...','id'=>'getwarden'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    }
    

	echo $form->field($model, 'fk_vechicle_info_id')->widget(Select2::classname(), [
        'data' => $vehicle,
        'options' => ['placeholder' => 'Select Vehicle ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

     ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
