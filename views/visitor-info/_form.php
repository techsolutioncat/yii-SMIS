<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\RefCountries;
use app\models\RefProvince;
use app\models\RefCities;
use app\models\RefGroup;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use app\models\RefDesignation;

?>

<div class="visitor-info-form">

    <?php $form = ActiveForm::begin();
    $advertisement = ArrayHelper::map(\app\models\VisitorAdvertisementMedium::find()->all(), 'id', 'title');
    $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title');
     ?>
     <div class="row">
         <div class="col-md-6">
         <?php echo Html::label('Visitor Category');
     $a= ['3' => 'Admission','1' => 'Job', '2' => 'Advertisement'];
    echo Html::activeDropDownList($model, 'fk_vistor_category',$a,['prompt'=>'Select Visitor Category','class'=>'form-control categoryVisits']);
    ?>
    <br />
         </div>
         

     </div>
     <div class="row">
         <div class="admission" style="display: none">
         <div class="col-md-6">
            <?= $form->field($model, 'fk_adv_med_id')->widget(Select2::classname(), [
            'data' => $advertisement,
            'options' => ['placeholder' => 'Select Advertisement ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],]);?>

             <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>


             <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
             
            

         <div class="admisn">
         <?= $form->field($model, 'fk_class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...'])->label('Class In Which Admission Is Required');?>
            
         <?php if($model->isNewRecord !=1){
            echo $form->field($model, 'coordinator_comments')->textarea(['maxlength' => true,'rows'=>6]);
         }else{
            
         } ?>
          
          <?php
         $personelObservation= ['satisfied but confused' => 'Satisfied but Confused','seemed from some school' => 'Seemed from some school', 'were fishy' => 'Were Fishy','were arguing'=>'Were Arguing','focus was on curriculum'=>'Focus was on Curriculum','focus was on discount'=>'Focus was on Discount','focus was on extra-curricular activities'=>'Focus was on extra-curricular Activities','mother seemed not satisfied'=>'Mother seemed not Satisfied','Father seemed not Satisfied','looked needy'=>'Looked Needy','were cooperative'=>'Were Cooperative'];
        ?>
         
         <?= $form->field($model, 'admin_personel_observation')->widget(Select2::classname(), [
            'data' => $personelObservation,
            'options' => ['placeholder' => 'Select Personel Observation ...','multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],]);?>
         
         <br />
          
          <!-- start of attempt -->
          <?php 
    if($model->isNewRecord!='1'){
                  echo $form->field($model2, 'first_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-0d',
                     ]
                 ]);

                 }else{
                    
                   echo $form->field($model2, 'first_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+4 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-0d',
                         //'endDate' => '+7d',
                     ]
                 ]);
                 }
     ?>
     <?php 
    if($model->isNewRecord!='1'){
                  echo $form->field($model2, 'second_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-2y',
                     ]
                 ]);
                 }else{
                    echo $form->field($model2, 'second_attempt_date')->hiddenInput(['value'=>date("Y-m-d",strtotime('+8 days',strtotime(date('Y-m-d'))))])->label(false);
                   /*echo $form->field($model2, 'second_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+8 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-0d',

                         //'endDate' => '+7d',
                     ]
                 ]);*/
                 }

     ?>

    
     

    <?php

    if($model->isNewRecord!='1'){
                  echo $form->field($model2, 'third_attempt_date')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         
                         'startDate' => '-0d',

                         //'endDate' => '+7d',
                     ]
                 ]);
                 }else{
                    echo $form->field($model2, 'third_attempt_date')->hiddenInput(['value'=>date("Y-m-d",strtotime('+12 days',strtotime(date('Y-m-d'))))])->label(false);
                  /*echo $form->field($model2, 'third_attempt_date')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d', strtotime('+12 days', strtotime(date("Y-m-d"))))],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'startDate' => '-0d',
                         //'endDate' => '+7d',
                     ]
                 ]);*/
                 }
                  echo $form->field($model, 'date_of_visit')->hiddenInput(['value'=>date('Y:m:d H:i:s')])->label(false);
     ?>

   
          <!-- end of attempt -->


          </div>
          <!-- ============== job  ================= -->
          <div class="jobs">
          <?php $designation_array = ArrayHelper::map(\app\models\RefDesignation::find()->all(), 'designation_id', 'Title');
                    echo $form->field($model, 'designation')->widget(Select2::classname(), [
                        'data' => $designation_array,
                        'options' => ['placeholder' => 'Select Designation ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
             <?= $form->field($model, 'qualification')->textInput(['maxlength' => true]) ?>

               <?= $form->field($model, 'last_organization')->textInput(['maxlength' => true]) ?>
               
                <?= $form->field($model, 'last_degree')->textInput(['maxlength' => true]) ?>
               </div>
            <div class="advertisement">
                <!-- advertisement here -->
            <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>
            </div>
         </div>
         <div class="col-md-6">
             <?= $form->field($model, 'cnic')->textInput(['maxlength' => true]) ?>
             <!-- <?//= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?> -->
              <?= $form->field($model, 'contact_no')->textInput() ?>

             <?= $form->field($model, 'address')->textarea(['maxlength' => true,'rows'=>6]) ?>
             <div style="height: 70px"></div>
             
      <!-- <?//= $form->field($model2, 'remarks')->textInput(['maxlength' => true]) ?> -->
         



          <!-- ==================job=================== -->
          <div class="jobs">
           <?= $form->field($model, 'experiance')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="advertisement">
          <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'product_description')->textInput(['maxlength' => true]) ?>
          </div>
         </div>
         </div>
     </div>
     </div>
     
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
