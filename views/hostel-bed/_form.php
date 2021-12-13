<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\HostelRoom;

/* @var $this yii\web\View */
/* @var $model app\models\HostelBed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hostel-bed-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $hostelRoom = HostelRoom::find()->select('title')->where(['id'=>$_GET['id']])->one(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?php if($model->isNewRecord != 1){
        }else{
            echo $form->field($model, 'fk_room_id')->hiddenInput(['value'=>$_GET['id']])->label(false);
            echo $form->field($model, 'Hostel_room')->textInput(['value'=>$hostelRoom->title,'readonly'=>'readonly']);

    } ?>
    
    <!-- <?/*=   $form->field($model, 'fk_room_id')->widget(Select2::classname(), [
        'data' => $hostelRoom,
        'options' => ['placeholder' => 'Select Hostel Room ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);*/?> -->

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']);
             ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
