<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\RefDegreeType;
use app\models\RefInstituteType;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\StudentEducationalHistoryInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-educational-history-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
             <?php $degree_array = ArrayHelper::map(\app\models\RefDegreeType::find()->all(), 'degree_type_id', 'Title');
                    echo $form->field($model, 'degree_type_id')->widget(Select2::classname(), [
                        'data' => $degree_array,
                        'options' => ['placeholder' => 'Select Degree ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>

    <?= $form->field($model, 'Institute_name')->textInput(['maxlength' => true]) ?>

    <?php $institute_array = ArrayHelper::map(\app\models\RefInstituteType::find()->all(), 'institute_type_id', 'Title');
                    echo $form->field($model, 'institute_type_id')->widget(Select2::classname(), [
                        'data' => $institute_array,
                        'options' => ['placeholder' => 'Select Institute ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_marks')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'degree_name')->textInput(['maxlength' => true]) ?>

   

     <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                     'options' => ['placeholder' => 'Enter Start date ...'],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                     ]
                 ]);?>

     <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                     'options' => ['placeholder' => 'Enter End date ...'],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                     ]
                 ]);?>

    <?= $form->field($model, 'stu_id')->HiddenInput(['value'=>$_GET['id']])->label(false) ?>

    <?= $form->field($model, 'marks_obtained')->textInput() ?>
        </div>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
