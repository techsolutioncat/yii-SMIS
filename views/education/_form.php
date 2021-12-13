<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\RefDegreeType;
use app\models\RefInstituteType;
use app\models\EmplEducationalHistoryInfo;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\EmplEducationalHistoryInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-educational-history-info-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $getExistDegree=EmplEducationalHistoryInfo::find()->where(['emp_id'=>$_GET['id'],'fk_branch_id'=>Yii::$app->common->getBranch()])->All();?>
       
       <?php foreach($getExistDegree as $getExistDegre){?>
        <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'degree_name1')->textInput(['maxlength' => true,'value'=>$getExistDegre->degree_name,'readonly'=>'readonly'])->label('Degree Name'); ?>
           
            <?= $form->field($model, 'Institute_name1')->textInput(['maxlength' => true,'value'=>$getExistDegre->Institute_name,'readonly'=>'readonly'])->label('Institute Name'); ?>
            
            <?= $form->field($model, 'start_date1')->textInput(['maxlength' => true,'value'=>$getExistDegre->start_date,'readonly'=>'readonly'])->label('Start Date'); ?>
           
            <?= $form->field($model, 'end_date1')->textInput(['maxlength' => true,'value'=>$getExistDegre->end_date,'readonly'=>'readonly'])->label('End Date'); ?>
           
            
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'marks_obtained1')->textInput(['maxlength' => true,'value'=>$getExistDegre->marks_obtained,'readonly'=>'readonly'])->label('Marks Obtained'); ?>
           
            <?= $form->field($model, 'total_marks1')->textInput(['maxlength' => true,'value'=>$getExistDegre->total_marks,'readonly'=>'readonly'])->label('Total Marks'); ?>
            
            <?= $form->field($model, 'grade1')->textInput(['maxlength' => true,'value'=>$getExistDegre->grade,'readonly'=>'readonly'])->label('Grade'); ?>
            
            
        </div>
       
        </div>
         <br /><br />
        <?php }?>
          
    <!-- <?/*= $form->field($model, 'emp_id')->dropDownList(
ArrayHelper::map(User::find()->all(),'id','first_name')
,['options' => [$_GET['id'] => ['Selected'=>'selected']]
, 'prompt' => ' -- Select User --'])*/ ?> -->
    <div class="row">
        <div class="col-md-6">
        <?php if($model->isNewRecord !=1){
            $getEduId=EmplEducationalHistoryInfo::find()->where(['edu_history_id'=>$_GET["id"]])->one();
             
             echo $form->field($model, 'emp_id')->HiddenInput(['value'=>$getEduId->emp_id])->label(false);
        }else{
            echo $form->field($model, 'emp_id')->HiddenInput(['value'=>$_GET["id"]])->label(false);
        }  ?>
             <?= $form->field($model, 'fk_branch_id')->HiddenInput(['value'=>Yii::$app->common->getBranch()])->label(false) ?>
             <?= $form->field($model, 'degree_name')->textInput(['maxlength' => true]) ?>

             <!-- <?php /* $degree_array = ArrayHelper::map(\app\models\RefDegreeType::find()->all(), 'degree_type_id', 'Title');
                    echo $form->field($model, 'degree_type_id')->widget(Select2::classname(), [
                        'data' => $degree_array,
                        'options' => ['placeholder' => 'Select Degree ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);*/
                ?> -->
   
   
    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                     'options' => ['placeholder' => 'Enter Start date ...'],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                     ]
                 ]);?>

    <!-- <?php /* $institute_array = ArrayHelper::map(\app\models\RefInstituteType::find()->all(), 'institute_type_id', 'Title');
                    echo $form->field($model, 'institute_type_id')->widget(Select2::classname(), [
                        'data' => $institute_array,
                        'options' => ['placeholder' => 'Select Institute ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    */
                ?> -->
    <?= $form->field($model, 'marks_obtained')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    

        </div>
        <br />
        <div class="col-md-6">
            
    
     <?= $form->field($model, 'Institute_name')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                     'options' => ['placeholder' => 'Enter End date ...'],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                     ]
                 ]);?>

   
    <?= $form->field($model, 'total_marks')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
   

     
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
         <?= ($model->isNewRecord)?Html::submitButton('Add Another Degree', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn pull-right', 'value'=>'create_continue', 'name'=>'submit']):'' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
