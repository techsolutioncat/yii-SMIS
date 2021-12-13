<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\RefGardianType;
use app\models\RefCountries;
use app\models\RefProvince;
use app\models\RefCities;
use app\models\RefDesignation;
use app\models\RefDepartment;
use app\models\RefReligion;
use app\models\RefDistrict;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use app\models\Profession;
/* @var $this yii\web\View */
/* @var $model app\models\EmployeeInfo */
/* @var $form yii\widgets\ActiveForm */
 
?>


<div onload="myFunction()"></div>
<div class="employee-info-form">

    <?php 
    $form = ActiveForm::begin([
    'id' => 'myform',
    'class'=>'mform',
   // 'enableAjaxValidation' => true,
    ]);
     ?>


    <div class="row">
             <fieldset class="scheduler-border">
             <div class="col-sm-12"><legend>Personnel Info:</legend></div>
             <div class="col-sm-6"> 
                <?php echo Html::label('Employee Registration No.'); ?>
                <span class="required" style="color:red">*</span>
                <?= $form->field($usermodel, 'username')->textInput(['readonly' => !$usermodel->isNewRecord,'id'=>'registerationemployee','data-url'=>Url::to(['student/validate-usrname']),'style' => 'text-transform: uppercase'])->label(false) ?>
                <label for="" id="usernameEmployee"></label>
                <span class="regNo" style="color:red"></span>  
                <?php echo Html::label('First Name'); ?>
                <span class="required" style="color:red">*</span>
                <?= $form->field($usermodel, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase'])->label(false) ?> 
                
                <?= $form->field($usermodel, 'last_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?> 
                <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
                
                <?= $form->field($usermodel, 'email')->widget(\yii\widgets\MaskedInput::className(),
                 [
                 'clientOptions' => [
                 'alias' =>  'email'
                    ],
                  ]); ?>
                <?php
                if($model->isNewRecord == 1){
                  echo  $form->field($model, 'dob')->widget(DatePicker::classname(), [
                         'options' => ['value' => date('Y/m/d')],
                         'pluginOptions' => [
                             'autoclose'=>true,
                             'format' => 'yyyy/mm/dd',
                             'todayHighlight' => true,
                             'endDate' => '+0d',
                             //'startDate' => '-2y',
                         ]
                     ]);
                }else{
                    echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                         //'options' => ['value' => date('Y/m/d')],
                         'pluginOptions' => [
                             'autoclose'=>true,
                             'format' => 'yyyy/mm/dd',
                             'todayHighlight' => true,
                             'endDate' => '+0d',
                             //'startDate' => '-2y',
                         ]
                     ]);

                }
                 ?>
                    
                <?php echo Html::label('Department'); ?>
                <span class="required" style="color:red">*</span>  
                 <?php $department_array = ArrayHelper::map(\app\models\RefDepartment::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'department_type_id', 'Title');
                        echo $form->field($model, 'department_type_id')->widget(Select2::classname(), [
                            'data' => $department_array,
                            'options' => ['placeholder' => 'Select Department ...','class'=>'departmentDesignation','data-url'=>url::to(['employee/get-designation'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    ?>

                    <?=$form->field($model, 'gender_type')->radioList([1 => 'Male', 0 => 'Female'], ['itemOptions' => ['class' =>'radio-inline']])?>

                    <div class="spouse" style="display: none">
                        <?= $form->field($model2, 'spouse_name')->textInput() ?>
                        
                        
                    </div>
                     <!-- if married or divorced -->
                         <?php if($usermodel->isNewRecord!='1'){
                            if(!empty($model2->spouse_name) && !empty($model2->no_of_children)){
                             echo  $form->field($model2, 'spouse_name')->textInput();
                           
                        }else{ ?>
                        
                        
                       <?php  }

                            }else{?>

                               

                        <?php } ?>


                    <?= $form->field($usermodel, 'Image')->fileInput() ?>
    
                 <?php if($usermodel->isNewRecord!='1'){
                    if(!empty($usermodel->Image)){
                    $src=Yii::$app->request->baseUrl.'/uploads/'.$usermodel->Image;
                    echo Html::img( $src, $options = ['width'=>60,'height'=>'60'] );
                }
                  ?>
    
                 <?php } ?>
               
    
    
                
             </div>
             <div class="col-sm-6">
             <?php if($model->isNewRecord == 1){
                  echo $form->field($model, 'hire_date')->widget(DatePicker::classname(), [
                         'options' => ['value' => date('Y/m/d')],
                         'pluginOptions' => [
                             'autoclose'=>true,
                             'format' => 'yyyy/mm/dd',
                             'todayHighlight' => true,
                             //'endDate' => '+0d',
                             //'startDate' => '-0d',
                         ]
                     ]);
                     }else{
                       echo  $form->field($model, 'hire_date')->widget(DatePicker::classname(), [
                         //'options' => ['value' => date('Y/m/d')],
                         'pluginOptions' => [
                             'autoclose'=>true,
                             'format' => 'yyyy/mm/dd',
                             'todayHighlight' => true,
                             //'endDate' => '+0d',
                             //'startDate' => '-0d',
                              ]
                     ]);
                     }


                     ?>
                     <?= $form->field($usermodel, 'middle_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?> 
                     <?= $form->field($usermodel, 'name_in_urdu')->textInput(['maxlength' => true]) ?> 
                  
                  

               

                  <?= $form->field($model, 'emergency_contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
                 
                  <?= $form->field($model, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['99999-9999999-9', '9999-999-99999']]) ?>
                    

                 <?php echo Html::label('Religion'); ?>
                <span class="required" style="color:red">*</span>    
                 <?php $religion_array = ArrayHelper::map(\app\models\RefReligion::find()->all(), 'religion_type_id', 'Title');
                        echo $form->field($model, 'religion_type_id')->widget(Select2::classname(), [
                            'data' => $religion_array,
                            //'options' => ['placeholder' => 'Select Religion ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    ?>
    
                <!-- <?php /*$gardian_array = ArrayHelper::map(\app\models\RefGardianType::find()->all(), 'gardian_type_id', 'Title');
                        echo $form->field($model, 'guardian_type_id')->widget(Select2::classname(), [
                            'data' => $gardian_array,
                            'options' => ['placeholder' => 'Select Guardian ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);*/
                    ?> -->
    
                
                    <?php echo Html::label('Designation'); ?>
                <span class="required" style="color:red">*</span> 
                    <?php
                    if($model->isNewRecord == 1){
                        $designation_array = ArrayHelper::map(\app\models\RefDesignation::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'designation_id', 'Title');
                        echo $form->field($model, 'designation_id')->widget(Select2::classname(), [
                            //'data' => $designation_array,
                            'options' => ['placeholder' => 'Select Designation ...','class'=>'getDesignation'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    }else{
                         
                        $designation_array = ArrayHelper::map(\app\models\RefDesignation::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'designation_id', 'Title');
                        echo $form->field($model, 'designation_id')->widget(Select2::classname(), [
                            'data' => $designation_array,
                            'options' => ['placeholder' => 'Select Designation ...','class'=>'getDesignation'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    }
                     
                    ?>
                
                 
    
                 <?= $form->field($model, 'marital_status')->radioList([1 => 'Single', 2 => 'Married',3 =>'Divorced'], ['itemOptions' => ['class' =>'radio-inline maritial_status' ]]) ?>

                 <div class="spouse" style="display: none">
                    <?= $form->field($model2, 'no_of_children')->textInput() ?>
                 </div>

                 <?php if($usermodel->isNewRecord!='1'){
                            if(!empty($model2->spouse_name) && !empty($model2->no_of_children)){
                             echo  $form->field($model2, 'no_of_children')->textInput();
                           
                        }else{ ?>
                        
                        
                       <?php  }

                            }else{?>

                               

                        <?php } ?>

                  <?= $form->field($model, 'Nationality')->textInput(['maxlength' => true]) ?>
    
                 
            
    
    
    
                 
             </div>
             </fieldset>
         </div>

         <!-- employee parents info -->


    <div class="employee_parents_info">

    <div class="row">
    <fieldset class="scheduler-border">
    	<div class="col-sm-12"><legend>Parents Info:</legend></div> 
        <div class="col-sm-6">
            <?php echo Html::label('First Name'); ?>
            <span class="required" style="color:red">*</span>
            <?= $form->field($model2, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase'])->label(false); ?>
           
            <?= $form->field($model2, 'last_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
            
            <?= $form->field($model2, 'email')->widget(\yii\widgets\MaskedInput::className(),
                 [
                 'clientOptions' => [
                 'alias' =>  'email'
                    ],
                  ]); ?>
            <?= $form->field($model2, 'contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
            <?= $form->field($model2, 'fk_branch_id')->HiddenInput(['value'=>Yii::$app->common->getBranch()])->label(false) ?>
            <?=$form->field($model2, 'gender')->radioList([1 => 'Male', 0 => 'Female'], ['itemOptions' => ['class' =>'radio-inline']])?>

        </div>
        <div class="col-sm-6">
              <?= $form->field($model2, 'middle_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
              <?= $form->field($model2, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => ['99999-9999999-9', '9999-999-99999']
            ]) ?>
            

             <?php $Professions= ArrayHelper::map(\app\models\Profession::find()->all(),'id','title');
                            echo $form->field($model2, 'profession')->widget(Select2::classname(), [
                                'data' => $Professions,
                                'options' => ['placeholder' => 'Select Profession ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
             
             
             <?= $form->field($model2, 'contact_no2')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
             
            
            <!-- end of employee parents info -->
        </div>
    </fieldset>
    </div>
    </div>

    <div class="row">
         <fieldset class="scheduler-border">
             <div class="col-sm-12"><legend>Address Info:</legend></div>  
             <div class="col-sm-6">
                  <?= $form->field($model, 'location2')->textArea(['maxlength' => true]) ?>
                 
                  
                    <?php
                        $country_array = ArrayHelper::map(\app\models\RefCountries::find()->all(), 'country_id', 'country_name');
                        echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                            'data' => $country_array,
                            'options' => ['placeholder' => 'Select Country ...','class'=>'country','data-url'=>Url::to(['student/country'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                   ?>
               
                <?php 
    
             if(!$model->isNewRecord){
                
                 $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
                        echo $form->field($model, 'district_id')->widget(Select2::classname(), [
                            'data' => $district_array,
                            'options' => ['placeholder' => 'Select District ...','class'=>'district'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                
             }else{
                // $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
                        echo $form->field($model, 'district_id')->widget(Select2::classname(), [
                            //'data' => $district_array,
                            'options' => ['placeholder' => 'Select District ...','class'=>'district'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
             }          
                    ?>
    
                
                
    
             </div>
             <div class="col-sm-6">
             <div style="height: 90px"></div>
             <!-- <?//= $form->field($model, 'location1')->textArea(['maxlength' => true]) ?> -->
                 
                <?php 
    
                         if(!$model->isNewRecord){
                            $province_array = ArrayHelper::map(\app\models\RefProvince::find()->all(), 'province_id', 'province_name');
                        echo $form->field($model, 'province_id')->widget(Select2::classname(), [
                            'data' => $province_array,
                            'options' => ['placeholder' => 'Select Province ...','class'=>'state','data-url'=>Url::to(['student/province'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
    
                         }else{
                            //$province_array = ArrayHelper::map(\app\models\RefProvince::find()->all(), 'province_id', 'province_name');
                        echo $form->field($model, 'province_id')->widget(Select2::classname(), [
                            //'data' => $province_array,
                            'options' => ['placeholder' => 'Select Province ...','class'=>'state','data-url'=>Url::to(['student/province'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                         }
    
    
    
                    ?>
    
    
    
                <?php 
    
                        if(!$model->isNewRecord){
    
                            $city_array = ArrayHelper::map(\app\models\RefCities::find()->all(), 'city_id', 'city_name');
                        echo $form->field($model, 'city_id')->widget(Select2::classname(), [
                            'data' => $city_array,
                            'options' => ['placeholder' => 'Select City ...','class'=>'city',Url::to(['student/district'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
    
    
    
                        }else{
                            //$city_array = ArrayHelper::map(\app\models\RefCities::find()->all(), 'city_id', 'city_name');
                        echo $form->field($model, 'city_id')->widget(Select2::classname(), [
                            //'data' => $city_array,
                            'options' => ['placeholder' => 'Select City ...','class'=>'city',Url::to(['student/district'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        }
    
                    ?>
    
                 
                  
             </div>
             
          
     </div>

     <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'different_address')->radioList([1 => 'As Above',2=>'different'], ['itemOptions' => ['class' =>'radio-inline permanent_addressoother']]);?>
                </div>
                <div class="col-md-6"></div>
            </div>

    <div class="row">
                <!--=========================== address 2===================!-->
        <div class="addressother" style="display:none">   <!-- style="display:none" -->
        <div class="row">
            <div class="col-md-6">
               <?= $form->field($model, 'location1')->textArea(['maxlength' => true,'class'=>' form-control']) ?>

                <?php
                if(!$model->isNewRecord){

                $country = ArrayHelper::map(RefCountries::find()->all(), 'country_id', 'country_name');
                echo $form->field($model, 'fk_ref_country_id2')->widget(Select2::classname(), [
                    'data' => $country,
                    'options' => ['class'=>'country2','data-url'=>Url::to(['student/country']) ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

                }else{
                    $country = ArrayHelper::map(RefCountries::find()->all(), 'country_id', 'country_name');
                echo $form->field($model, 'fk_ref_country_id2')->widget(Select2::classname(), [
                    'data' => $country,
                    'options' => ['placeholder' => 'Select Country ...','class'=>'country2','data-url'=>Url::to(['student/country']) ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                }

                ?>
                <?php

                if(!$model->isNewRecord){
                    $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
                    echo $form->field($model, 'fk_ref_district_id2')->widget(Select2::classname(), [
                        'data' => $district_array,
                        'options' => ['class'=>'district2'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }else{
                    // $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
                    echo $form->field($model, 'fk_ref_district_id2')->widget(Select2::classname(), [
                        //'data' => $district_array,
                        'options' => ['placeholder' => 'Select District ...','class'=>'district2'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }



                ?>


            </div>
            <div class="col-md-6">
            <div style="height: 95px"></div>
                <?php

                if(!$model->isNewRecord){
                    $items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
                    echo $form->field($model, 'fk_ref_province_id2')->widget(Select2::classname(), [
                        'data' => $items,
                        'options' => ['class'=>'state2','data-url'=>Url::to(['student/province'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }else{
                    //$items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
                    echo $form->field($model, 'fk_ref_province_id2')->widget(Select2::classname(), [
                        //'data' => $items,
                        'options' => ['placeholder' => 'Select Province ...','class'=>'state2','data-url'=>Url::to(['student/province'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }


                ?>

                <?php

                if(!$model->isNewRecord){
                    $city = ArrayHelper::map(RefCities::find()->all(), 'city_id', 'city_name');
                    echo $form->field($model, 'fk_ref_city_id2')->widget(Select2::classname(), [
                        'data' => $city,
                        'options' => ['class'=>'city2',Url::to(['student/district'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }else{

                    echo $form->field($model, 'fk_ref_city_id2')->widget(Select2::classname(), [

                        'options' => ['placeholder' => 'Select City ...','class'=>'city2',Url::to(['student/district'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }



                ?>
            </div>

        </div>
        </div>


                 
                <!-- =============== end of address 2 ==========!-->
    </div>

    <div class="address2Show" style="display: none">

        <!-- //get value -->
        <input type="text" name="EmployeeInfo[fk_ref_country_id22]" class="form-control country2" value="">
        <input type="text" name="EmployeeInfo[fk_ref_province_id22]" id="thisprovince" class="form-control getprovincesval" value="">
        <input type="text" name="EmployeeInfo[fk_ref_district_id22]" class="form-control district2">
        <input type="text" name="EmployeeInfo[fk_ref_city_id22]" class="form-control city2">
    </div>
                
     <!-- start of salary --> 
        
    <div class="row">
         <fieldset>
         <div class="col-sm-12"><legend>Salary Info</legend></div>  
         <div class="col-sm-6">
          <?php
          if($employeesalaryselection->isNewRecord == 1){
            $groups = ArrayHelper::map(\app\models\SalaryPayGroups::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeePayroll, 'fk_group_id')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['placeholder' => 'Select Group ...','data-url'=>Url::to(['salary-allownces/get-stages']),'class'=>'groups'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                     ])->label('Group');
          }else{
            $groups = ArrayHelper::map(\app\models\SalaryPayGroups::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeePayroll, 'fk_group_id')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['placeholder' => 'Select Group ...','data-url'=>Url::to(['salary-allownces/get-stages']),'class'=>'groups'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                     ])->label('Group');
          }
           
    
          if($employeePayroll->isNewRecord == 1){
           // echo "alwnc one";
    
          $getStagePayrol= $employeePayroll->fk_pay_stages;
    
           $sl = ArrayHelper::map(\app\models\SalaryAllownces::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeesalaryselection, 'fk_allownces_id')->widget(Select2::classname(), [
                        //'data' => $sl,
                        'options' => ['prompt'=>'Select Allownce','class','gtalwnc','data-url'=>Url::to(['employee/get-allownce']),'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Allownces');
    
                     }else{
            //echo "alwnc two";
    
                        //echo '<pre>';print_r($employeePayroll);
                        //$employeesalaryselection->fk_group_id= "";
                         /*$groups = ArrayHelper::map(\app\models\SalaryPayGroups::find()->all(), 'id', 'title');
                        echo $form->field($employeesalaryselection, 'fk_group_id')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['placeholder' => 'Select Group ...','data-url'=>Url::to(['salary-allownces/get-stages']),'class'=>'groups'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],])->label('Group');*/
    
    
                      $getStagePayrol= $employeePayroll->fk_pay_stages;
                     $alwncarray = ArrayHelper::map(\app\models\SalaryAllownces::find()->where(['fk_stages_id'=>$getStagePayrol,'status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
    
                     $getAlwnc = ArrayHelper::map(\app\models\EmployeeAllowances::find()->select('fk_allownces_id')->where(['status'=>1,'fk_emp_id'=>$_GET['id'],'status'=>1])->all(), 'fk_allownces_id', 'fk_allownces_id');
    
                     $employeesalaryselection->fk_allownces_id=$getAlwnc;
                      echo $form->field($employeesalaryselection, 'fk_allownces_id')->widget(Select2::classname(), [
                        'data' => $alwncarray,
                        'options' => ['prompt'=>'Select Allownce','class','gtalwnc','data-url'=>Url::to(['employee/get-allownce']),'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                       ])->label('Allownces');
    
                     }
                    ?>
    
    
    
    <div class="alwnc alw_min col-sm-12">
        
       </div>
    
    <!--<div class="stagadiv" style="display: none">                
    <label class="getstagelabel">Stage Amount</label>
    <input type="text" name="" readonly="readonly" value="" class="getstageamount form-control">
     
    </div>   !s-->
        
         
         </div>
        <div class="col-sm-6"> 
         <input type="hidden" name="EmployeePayroll[total_allownce]" id="getTotalAlwnx">
         <input type="hidden" name="EmployeePayroll[total_deductions]" id="getTotalDedcx">
            <input type="hidden" value="" name="EmployeePayroll[total_amount]" id="payrollTotalAmount">
            
         <?php
    
            if($employeePayroll->isNewRecord == 1){
               // echo "deduction one";
          $stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeePayroll, 'fk_pay_stages')->widget(Select2::classname(), [
                        //'data' => $groups,
                        'options' => ['placeholder' => 'Select stages ...','class'=>'getstage getstageamnt','data-url'=>Url::to(['employee/get-stage-detail'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
         ])->label('Stage');
       
        $deduction = ArrayHelper::map(\app\models\SalaryDeductionType::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeesalarydeductiondetail, 'fk_deduction_id')->widget(Select2::classname(), [
                       // 'data' => $deduction,
                        'options' => ['prompt'=>'Select Deduction','class'=>'deduct','data-url'=>Url::to(['employee/get-allownce']),'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Deductions');
    
                }else{
                   // $employeesalaryselection->fk_pay_stages="";
                    $stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    echo $form->field($employeePayroll, 'fk_pay_stages')->widget(Select2::classname(), [
                        'data' => $stage,
                        'options' => ['placeholder' => 'Select stages ...','class'=>'getstage getstageamnt','data-url'=>Url::to(['employee/get-stage-detail'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                 ])->label('Stage');
                    
                   
                    $deductions = ArrayHelper::map(\app\models\EmployeeDeductions::find()->select('fk_deduction_id')->where(['fk_emp_id'=>$_GET['id'],'status'=>1,'fk_branch_id'=>yii::$app->common->getBranch()])->asArray()->all(), 'fk_deduction_id', 'fk_deduction_id');
    
    
                    $deductionss = ArrayHelper::map(\app\models\SalaryDeductionType::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                    $employeesalarydeductiondetail->fk_deduction_id=$deductions;
                   $getStagePayroll= $employeePayroll->fk_pay_stages;
    
                    $deduction = ArrayHelper::map(\app\models\SalaryDeductionType::find()->where(['fk_stages_id'=>$getStagePayroll])->all(), 'id', 'title');
    
                    //echo '<pre>';print_r($employeePayroll);
                    
    
                    echo $form->field($employeesalarydeductiondetail, 'fk_deduction_id')->widget(Select2::classname(), [
                        'data' => $deduction,
                        'options' => ['prompt'=>'Select Deduction','class'=>'deduct','data-url'=>Url::to(['employee/get-allownce']),'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Deductions');
                    ?>
                
                <?php }
                    //echo $form->field($employeesalarydeductiondetail, 'amount')->textInput()->label('Deduction Amount');
    
                    ?>
                    
                    <div style="display: none;" class="tlt">
                    <label>Net amount</label>
                    <input type="text" name="" readonly="readonly" value="" class="ttl form-control">
            
                   </div>
                   <div class="dedctns col-sm-6">
                       
                    
                   </div> 
         </div>
        </fieldset> 
         <!-- end of salary --> 
         <div class="row" id="getBasicSalary">
         
         <div class="col-sm-12">
             <table class="table table-striped calculateNet" style="display: none">
                   <tr>
                       <td id="getTotalNet">Basic Salary</td>
                       <td id="getnetamount"><input type="text" name="EmployeePayroll[basic_salary]" value="" id="getBscSalry" readonly="readonly" style="border: none"></td>
                   </tr>
                   <tr>
                       
                   </tr>
              </table>
          </div>
         <div class="col-sm-12"></div>
         </div>  
         <div class="form-group col-sm-12">
         <?= Html::a('Cancel',['employee/index'], ['class' => 'btn grey-btn pull-left']) ?>
    
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn pull-right' : 'btn green-btn pull-right', 'value'=>'create', 'name'=>'submitCreate','style'=>'margin-left:3px']) ?>
        
        
         <?= ($model->isNewRecord)?Html::submitButton('Create & Continue', ['class' => $model->isNewRecord ? 'btn green-btn pull-right' : 'btn green-btn pull-right', 'value'=>'create_continue', 'name'=>'submit']):'' ?>
    
          <!-- <input type="submit" value="submit" class="btn green-btn" id="prevw">
          -->
    
         
    </div> 
    
        <?php ActiveForm::end(); ?>
    </div> 
    <!-- <input type="text" id="uss" data-url=<?php// echo Url::to(['employee-salary-selection/get-employee']); ?>> -->
    <input type="hidden" id="uss" data-url=<?php echo Url::to(['employee/get-allownce']); ?>>
    <?php
    $id=yii::$app->request->get('id');

// $this->registerCssFile(Yii::getAlias('@web')."/css/previewForm.css");
// $this->registerJsFile(Yii::getAlias('@web').'/js/previewForm.js',['depends' => [yii\web\JqueryAsset::className()]]);
if(!empty(yii::$app->request->get('id'))){

$script= <<< JS
$(document).ready(function() {

var url=$('#uss').data('url');
var stageid= $('#employeepayroll-fk_pay_stages').val();
var alwncid=$('#employeeallowances-fk_allownces_id').val();
var deductid=$('.deduct').val();
//alert(stageid);
allownce(url,stageid,alwncid,deductid);

});

/*$(document).ready(function() {
var id=$('.deduct').val();
  var url=$('.deduct').data('url');
  var gettotalAlwnc=$('#getalownceamount').val();
  //alert(gettotalAlwnc);
  getDeduction(url,id,gettotalAlwnc);
});*/

JS;
$this->registerJs($script);
}

?>
<?php
if($model->isNewRecord !=1 && $model->different_address){
  
    //echo $model->different_address;
$script= <<< JS

$(document).ready(function() {
$('.addressother').show();
});
JS;
$this->registerJs($script);
}


?>
</div>
