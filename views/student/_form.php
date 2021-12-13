<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\RefCountries;
use app\models\RefProvince;
use app\models\RefSession;
use app\models\RefGroup;
use app\models\RefShift;
use app\models\RefClass;
use app\models\RefSection;
use app\models\RefCities;
use app\models\Zone;
use app\models\Stop;
use app\models\HostelFloor;
use app\models\HostelRoom;
use app\models\HostelBed;
use app\models\Hostel;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\StudentInfo */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="student-info-form padd">
    <?php $form = ActiveForm::begin(); ?>
    <!--student personal information-->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Personal Information</legend>
        <div class="row"> 
            <div class="col-md-6">
                <?php
                if($model->isNewRecord){
                    if(Yii::$app->common->getBranchSettings()->student_reg_type == 'auto'){
                        ?>
                        <?=$form->field($userModel, 'username')->textInput(['readonly'=>true,'maxlength' => true,'value'=>Yii::$app->common->getBranchDetail()->name.'-'.date("Y").'-'.($branch_std_counter+1),'id'=>'registeration','class'=>'form-control input form-control','id'=>'registeration','data-url'=>Url::to('validate-usrname')])?>
                        <?php
                    }
                    else{
                        ?>
                        <?=$form->field($userModel, 'username')->textInput(['maxlength' =>($model->isNewRecord)?false:true,'id'=>'registeration','class'=>'form-control input form-control','id'=>'registeration','data-url'=>Url::to('validate-usrname')])?>
                        <?php
                    }
                }
                else{
                    echo $form->field($userModel, 'username')->textInput(['maxlength' =>($model->isNewRecord)?false:true,'id'=>'registeration','class'=>'form-control input form-control','id'=>'registeration','data-url'=>Url::to('validate-usrname')/*,'disabled'=>true*/]);
                }
                ?>
                <?= $form->field($userModel, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                <?= $form->field($userModel, 'middle_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                <?= $form->field($userModel, 'last_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                <?= $form->field($userModel, 'name_in_urdu')->textInput(['maxlength' => true]) ?>
                  <?php
                $session = ArrayHelper::map(RefSession::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'session_id', 'title');
                echo $form->field($model, 'session_id')->widget(Select2::classname(), [
                    'data' => $session,
                    'options' => ['placeholder' => 'Select Session ...','data-url'=>Url::to(['student/get-class'])],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                 <?php
            // Dependent Dropdown
             /*if($model->isNewRecord!='1'){   
            $group = ArrayHelper::map(RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'group_id', 'title');

            echo $form->field($model, 'group_id')->widget(Select2::classname(), [
                    'data' => $group,
                    //'options' => ['placeholder' => 'Select Shift ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            }else{
                  echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
            }*/
            $group = ArrayHelper::map(RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$model->class_id])->all(), 'group_id', 'title');
           // echo '<pre>';print_r($model);
            echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                'data' => $group,
                    'options' => ['id'=>'group-id','class'=>'form-control groupPrev'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?>

                 <?php 
                 if($model->isNewRecord!='1'){
                  echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                      //'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'endDate' => '+0d',
                         //'startDate' => '-2y',
                     ]
                 ]);
                 }else{
                   echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                      'options' => ['value' => date('Y-m-d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                         'endDate' => '+0d',
                        // 'startDate' => '-2y',
                     ]
                 ]);
                 }

                  ?>
                <?=  $form->field($model, 'acc_no')->textInput(['class'=>'form-control input form-control','type'=>'number'])?>
                <!-- <?/*=  $form->field($model, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => ['99999-9999999-9', '9999-999-99999']
                ]) */?> -->
                
               
                
                 <?= $form->field($model, 'parent_status')->radioList([1 => 'Alive', 0 => 'Dead'], ['itemOptions' => ['class' =>'radio-inline parent_status' ]]) ?>
                
                 <?= Html::label('Transport Facility')?><br />
    <!-- //is_transport_avail -->
                 <!-- <?//= $form->field($model, 'is_transport_avail')->radioList([1 => 'Yes', 0 => 'No'], ['itemOptions' => ['class' =>'radio-inline stops' ]])->label(false); ?> -->
                
                 <input type="radio" class="radio-inline stops" name="StudentInfo[is_transport_avail]" value="1" <?php echo ($model->fk_stop_id > 0)?'checked':'' ?> />
                  <label>Yes</label>
                 
                 <input type="radio" class="radio-inline stops" name="StudentInfo[is_transport_avail]" value="0" <?php echo (empty($model->fk_stop_id))?'checked':'' ?>>
                 <label>No</label>
                 <br />

                 <?= Html::label('Hostel Facility')?>
                 <?= $form->field($model, 'is_hostel_avail')->radioList([1 => 'Yes', 0 => 'No'], ['itemOptions' => ['class' =>'radio-inline hosteldetail' ]])->label(false); ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'withdrawl_no')->textInput() ?>

                <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                <?= $form->field($model, 'emergency_contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>


                <?= $form->field($model, 'gender_type')->radioList([1 => 'Male', 0 => 'Female'], ['itemOptions' => ['class' =>'radio-inline']])?>
                <?= $form->field($userModel, 'email')->textInput() ?>
                
                <?php $religion_array = ArrayHelper::map(\app\models\RefReligion::find()->all(), 'religion_type_id', 'Title');
                echo $form->field($model, 'religion_id')->widget(Select2::classname(), [
                    'data' => $religion_array,
                    'options' => ['placeholder' => 'Select Religion ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
                <?php 
                if($model->isNewRecord!='1'){
                   echo  $form->field($model, 'registration_date')->widget(DatePicker::classname(), [
                    //'options' => ['value' => date('Y-m-d')],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'startDate' => '-2y',
                        'endDate' => '+0d',
                    ]
                ]);
                }else{

                 echo  $form->field($model, 'registration_date')->widget(DatePicker::classname(), [
                    'options' => ['value' => date('Y-m-d')],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'startDate' => '-2y',
                        'endDate' => '+0d',
                    ]
                ]);

                }


                ?>

                    


                <?php /*echo $form->field($userModel, 'status')->dropDownList(['active'=>'Active','inactive'=>'Inactive'],['prompt'=>'Select Status']);*/
                ?>

              <?php
              /*if($model->isNewRecord !='1'){
                $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title');?>
            <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...']);
                
            
             }else{
                echo $form->field($model, 'class_id')->widget(Select2::classname(), [
                        //'data' => $class_array,
                        'options' => ['placeholder' => 'Select Class ...','id'=>'class-id'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
             }*/

              $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title');?>
                        <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...','class'=>'form-control classprev'])->label('Class <span style="color:#a94442;">*</span>'); ?>
            
           
             

                 <?php
            // Dependent Dropdown
        /*if($model->isNewRecord!='1'){
            $section = ArrayHelper::map(RefSection::find()->all(), 'section_id', 'title');
           echo $form->field($model, 'section_id')->widget(Select2::classname(), [
                    'data' => $section,
                    'options' => ['placeholder' => 'Select Section ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            
        }else{
            echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
                'options' => ['id'=>'section-id'],
                'pluginOptions'=>[
                    'depends'=>[
                        'group-id','class-id'
                    ],
                    'prompt' => 'Select section',
                    'url' => Url::to(['/site/get-section'])
                ]
            ]);

        }*/
        $section = ArrayHelper::map(RefSection::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'class_id'=>$model->class_id])->all(), 'section_id', 'title');
        //echo '<pre>';print_r($model);
        echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
            'data' => $section,
                                'options' => ['id'=>'section-id','class'=>'form-control sectionPrev'],
                                'pluginOptions'=>[
                                    'depends'=>[
                                        'group-id','class-id'
                                    ],
                                    'prompt' => 'Select section',
                                    'url' => Url::to(['/site/get-section'])
                                ]
                            ])->label('Section <span style="color:#a94442;">*</span>');
            ?>


                <?php
                $shift = ArrayHelper::map(RefShift::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'shift_id', 'title');
                echo $form->field($model, 'shift_id')->widget(Select2::classname(), [
                    'data' => $shift,
                    'options' => ['placeholder' => 'Select Shift ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

              <?php if($userModel->isNewRecord!='1'){
             //  if(!empty($userModel->Image)){
                $src=Yii::$app->request->baseUrl.'/uploads/'.$userModel->Image;
                echo Html::img( $src, $options = ['width'=>60,'height'=>'60','alt'=>'No Image Uploaded'] );
                echo $form->field($userModel, 'Image')->fileInput();
            }
       // }
        else{
            echo $form->field($userModel, 'Image')->fileInput();
        }
              ?>

             

             
                 <!-- display route -->
                <div class="displayRoute" style="display: none">
                   <?php
                
               /* $zone = ArrayHelper::map(Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                echo $form->field($model, 'zone')->widget(Select2::classname(), [
                    'data' => $zone,
                    'options' => ['placeholder' => 'Select Zone ...','data-url'=>\yii\helpers\Url::to(['student/get-route'])],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);*/
        $getRout=Stop::find()->where(['id'=>$model->fk_stop_id])->one();
          
        // echo $model->fk_stop_id;
          if(empty($model->fk_stop_id)){


         ?>

        <label>Zone</label>
        <select data-url="<?= Url::to(['student/get-route'])?>" class="zonechange zonePrev form-control">

        <?php $xone=Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all()?>
        <option value="">Select Zone</option>
        <?php foreach ($xone as $xonex) { ?>
            <option value="<?= $xonex->id;?>"><?= $xonex->title;?></option>
        <?php } ?>
        
     
      </select>

      <?php }else{
         $getxoneid=$getRout->fkRoute->fkZone->id;
          $getxonetitle=$getRout->fkRoute->fkZone->title;
        ?>
       <label>Zone</label>
        <select data-url="<?= Url::to(['student/get-route'])?>" class="zonechange zonePrev form-control">

        <?php $xone=Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all()?>
        <option value="<?= $getxoneid;?>"><?= $getxonetitle;?></option>
      
        <?php foreach ($xone as $xonex) { ?>
        

            <option value="<?= $xonex->id;?>"><?= $xonex->title;?></option>
        <?php } ?>
        
     
      </select>
       <?php } ?>

     <?php    /*echo $form->field($model, 'zone')->dropdownList(ArrayHelper::map(Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title'),
                ['options' => [$getxone => ['Selected'=>'selected']]]);*/

                /*$zone = ArrayHelper::map(Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                echo $form->field($model, 'zone')->widget(Select2::classname(), [
                    'data' => $zone,
                    'options' => ['placeholder' => 'Select Zone ...','class'=>'zonechange zonePrev','data-url'=>\yii\helpers\Url::to(['student/get-route']),'selected'=>'selected'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);*/
            
                if(!empty($getRout)){
                 $RouteAlready=$getRout->fkRoute->title;
                
                echo $form->field($model, 'route')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Route ...','class'=>'route','data-url'=>\yii\helpers\Url::to(['student/get-stop']),'value'=>$RouteAlready],
                     //['options' => [$RouteAlready => ['Selected'=>'selected']]],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                     //['options' => [$RouteAlready => ['Selected'=>'selected']]],
                 ]);
            }else{

            echo $form->field($model, 'route')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Route ...','class'=>'route','data-url'=>\yii\helpers\Url::to(['student/get-stop'])],
                     //['options' => [$RouteAlready => ['Selected'=>'selected']]],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                     //['options' => [$RouteAlready => ['Selected'=>'selected']]],
                 ]);

        }

               /*  echo $form->field($model, 'route')->dropdownList(ArrayHelper::map(RefClass::find()->where([])->all(), 'class_id', 'title'),
                ['options' => [$selectedClass => ['Selected'=>'selected']]]);*/

                if($model->isNewRecord!='1'){
                $gtStop = ArrayHelper::map(Stop::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                echo $form->field($model, 'fk_stop_id')->widget(Select2::classname(), [
                     'data' => $gtStop,
                     'options' => ['placeholder' => 'Select Stop ...','class'=>'stop'],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
            }else{
                 echo $form->field($model, 'fk_stop_id')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Stop ...','class'=>'stop'],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
            }
                ?> 
                </div>
                </div>
              <!-- end of display route -->
         </div>
    </fieldset>
    <!-- hostel facility -->

    <div class="hostel" style="display: none">
                 <fieldset class="scheduler-border">
            <legend class="scheduler-border">Hostel Details</legend>
            <input type="hidden" id="bedurl" data-url="<?= Url::to(['student/check-bed'])?>">
            <div class="row">
                <div class="col-md-6">
                    <?php 
                    $hostel = ArrayHelper::map(\app\models\Hostel::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'Name');
                    if($model->is_hostel_avail == 1){
                       
                     $floor = ArrayHelper::map(\app\models\HostelFloor::find()->where(['fk_hostel_info_id'=>$hostelDetailModel->fk_hostel_id])->all(), 'id', 'title');

                     $room = ArrayHelper::map(\app\models\HostelRoom::find()->where(['fk_FLOOR_id'=>$hostelDetailModel->fk_floor_id])->all(), 'id', 'title');
                     $bed = ArrayHelper::map(\app\models\HostelBed::find()->where(['fk_room_id'=>$hostelDetailModel->fk_room_id])->all(), 'id', 'title');


                
                    }else{
                    $floor = ArrayHelper::map(\app\models\HostelFloor::find()->all(), 'id', 'title');
                    $room = ArrayHelper::map(\app\models\HostelRoom::find()->all(), 'id', 'title');
                    $bed = ArrayHelper::map(\app\models\HostelBed::find()->all(), 'id', 'title');



                    }
        $student = ArrayHelper::map(\app\models\StudentInfo::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'stu_id', 'user_id');


    
          echo $form->field($hostelDetailModel, 'fk_hostel_id')->widget(Select2::classname(), [
                'data' => $hostel,
                'options' => ['placeholder' => 'Select Hostel ...','class'=>'hostelAll','data-url'=>\Yii\helpers\url::to(['student/get-hostel-floor'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
          if($hostelDetailModel->isNewRecord != '1'){
          echo $form->field($hostelDetailModel, 'fk_floor_id')->widget(Select2::classname(), [
                'data' => $floor,
                'options' => ['placeholder' => 'Select Hostel Floor ...','class'=>'floorAjax'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
       }else{
        echo $form->field($hostelDetailModel, 'fk_floor_id')->widget(Select2::classname(), [
                //'data' => $floor,
                'options' => ['placeholder' => 'Select Hostel Floor ...','class'=>'floorAjax','data-url'=>\yii\helpers\Url::to(['student/get-floor-room'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
       }
        if($hostelDetailModel->isNewRecord != '1'){
          echo $form->field($hostelDetailModel, 'fk_room_id')->widget(Select2::classname(), [
                'data' => $room,
                'options' => ['placeholder' => 'Select Hostel Room ...','class'=>'roomBed','data-url'=>\yii\helpers\Url::to(['student/get-bed'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
      }else{
         echo $form->field($hostelDetailModel, 'fk_room_id')->widget(Select2::classname(), [
                //'data' => $room,
                'options' => ['placeholder' => 'Select Hostel Room ...','class'=>'roomBed','data-url'=>\yii\helpers\Url::to(['student/get-bed'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
      }
    
         ?>
                </div>
                <div class="col-md-6">
                     <?php 
                     if($hostelDetailModel->isNewRecord != '1'){
                     echo $form->field($hostelDetailModel, 'fk_bed_id')->widget(Select2::classname(), [
                    'data' => $bed,
                    'options' => ['placeholder' => 'Select Room Bed ...','class'=>'beds'],
                    'pluginOptions' => [
                        'allowClear' => true
                      ],
                     ]);
                 }else{
                    echo $form->field($hostelDetailModel, 'fk_bed_id')->widget(Select2::classname(), [
                    //'data' => $bed,
                    'options' => ['placeholder' => 'Select Room Bed ...','class'=>'beds'],
                    'pluginOptions' => [
                        'allowClear' => true
                      ],
                     ]);
                 }?>
                 <label for="" id="bedasign" style="color:red"></label>
    
        <?php echo $form->field($hostelDetailModel, 'create_date')->widget(DatePicker::classname(), [
                          'options' => ['value' => date('Y-m-d')],
                         'pluginOptions' => [
                             'autoclose'=>true,
                             'format' => 'yyyy-mm-dd',
                             'todayHighlight' => true,
                             'startDate' => '-2y',
                         ]
                     ]);
    
        echo  $form->field($hostelDetailModel, 'is_booked')->hiddenInput(['class'=>'active'])->label(false);
    
                     ?>
                </div>
            </div>
    
            </fieldset>
            </div>
    <!-- end of hostel facility -->
    <!-- student parents info -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Parents Information</legend>
        <!-- parents information -->
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend>Father Info</legend>
                            <?= Html::label('Full Name')?>
                            <?= $form->field($model2, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase','class'=>'input form-control','id'=>'fatherName'])->label(false) ?>
                            
                            <?php
                            $fatherProfession= ArrayHelper::map(\app\models\Profession::find()->all(),'id','title');
                            echo $form->field($model2, 'profession')->widget(Select2::classname(), [
                                'data' => $fatherProfession,
                                'options' => ['placeholder' => 'Select Profession ...','class'=>'proffessionPrev','id'=>'fatherProfession'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                            <?= $form->field($model2, 'designation')->textInput(['class'=>'input form-control','id'=>'fatherDesignation']) ?>
    
                            <?= $form->field($model2, 'organisation')->textInput(['class'=>'input form-control','id'=>'fatherOrg']) ?>
                            <?= $form->field($model2, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
                            'mask' => ['99999-9999999-9', '9999-999-99999'],'options'=>['class'=>'input form-control']
                            ])->label('Father Cnic <span style="color:#a94442;"></span>')?>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <legend>Mother Info</legend>
                        <?php echo Html::label('Full Name') ?>
                        <?= $form->field($model2, 'mother_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase','class'=>'input form-control','id'=>'motherName'])->label(false) ?>
    
                        <?php $getProfession= ArrayHelper::map(\app\models\Profession::find()->all(),'id','title');
                        echo $form->field($model2, 'mother_profession')->widget(Select2::classname(), [
                            'data' => $getProfession,
                            'options' => ['placeholder' => 'Select Profession ...','class'=>'motherProf','id'=>'motherProfession'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
    
    
                        <?= $form->field($model2, 'mother_designation')->textInput(['class'=>'input form-control','id'=>'motherDesignation']) ?>
    
                        <?= $form->field($model2, 'mother_organization')->textInput(['class'=>'input form-control','id'=>'motherOrg']) ?>
    
                        <?= $form->field($model2, 'gender_type')->radioList([1 => 'Mother', 2 => 'Father',3=>'Both'], ['itemOptions' => ['class' =>'radio-inline inputes','id'=>'Verifiedby']])->label('Verified By')?>
    
                        </p>
    
                    </div>
                </div>
                <!-- end of parents information -->
        <!-- <div class="row">
            <div class="col-md-6">
                <?php /*  echo  $form->field($model2, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                <?= $form->field($model2, 'middle_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                <?= $form->field($model2, 'last_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                
                <?= $form->field($model2, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => ['99999-9999999-9', '9999-999-99999']
                ])?>
               
            </div>
            <div class="col-md-6">
                
                <?php
                            $fatherProfession= ArrayHelper::map(\app\models\Profession::find()->all(),'id','title');
                            echo $form->field($model2, 'profession')->widget(Select2::classname(), [
                                'data' => $fatherProfession,
                                'options' => ['placeholder' => 'Select Profession ...','class'=>'proffessionPrev','id'=>'fatherProfession'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
        
        
                

                 <?= $form->field($model2, 'contact_no')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>


                
                <?= $form->field($model2, 'contact_no2')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>
                <?= $form->field($model2, 'email')->textInput(); ?>



                <?php  */?>
               
        
            </div>
        </div> -->
        <div class="deads" style="display: none">
            <div class="row">
                <legend class="scheduler-border">Guardian Details</legend>
                <div class="col-md-6">
                    <?= $form->field($model2, 'guardian_name')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model2, 'relation')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?=  $form->field($model2, 'guardian_cnic')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => ['99999-9999999-9', '9999-999-99999']
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model2, 'guardian_contact_no')->textInput() ?>
                </div>
            </div>
        </div>

        
                    



        <!--guardian details information.-->
        
    </fieldset>

    
    <!-- end of parent information -->


    <!-- address information -->
    <h2>Address</h2>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <legend>Father Info</legend>
    
                        
                    <?= $form->field($model2, 'contact_no')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'fatherContact','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                        
                         <?= $form->field($model2, 'office_no')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'fatherOffice','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                        <?= $form->field($model2, 'email')->textInput(['class'=>'input form-control','id'=>'fatherEmail']) ?>
                        <?= $form->field($model2, 'facebook_id')->textInput(['class'=>'input form-control','id'=>'fatherFb']) ?>
                        <?= $form->field($model2, 'twitter_id')->textInput(['class'=>'input form-control','id'=>'fatherT']) ?>
                        <?= $form->field($model2, 'linkdin_id')->textInput(['class'=>'input form-control','id'=>'fatherl']) ?>
    
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>
                            Mother Info
                        </legend>
                        

                        <?= $form->field($model2, 'mother_contactno')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'motherContact','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                        
                        <?= $form->field($model2, 'mother_officeno')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'motherOffice','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                        <?= $form->field($model2, 'mother_email')->textInput(['class'=>'input form-control','id'=>'motherEmail']) ?>
                        <?= $form->field($model2, 'mother_fb_id')->textInput(['class'=>'input form-control','id'=>'motherFb']) ?>
                        <?= $form->field($model2, 'mother_twitter_id')->textInput(['class'=>'input form-control','id'=>'motherT']) ?>
                        <?= $form->field($model2, 'mother_linkedin')->textInput(['class'=>'input form-control','id'=>'motherl']) ?>
    
                    </fieldset>
                </div>
            </div>
        </section>
    <!-- end of address information -->


    <!--student address information-->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Address Information</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'location1')->textArea(['maxlength' => true]) ?>
            </div>
            <!-- <div class="col-md-6">
                <?//= $form->field($model, 'location2')->textInput(['maxlength' => true]) ?>
            </div> -->
            <div class="col-md-6">
                <?php
                $country = ArrayHelper::map(RefCountries::find()->all(), 'country_id', 'country_name');
                echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                     'data' => $country,
                     'options' => ['placeholder' => 'Select a Country ...','class'=>'country','data-url'=>Url::to(['student/country']) ],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);?>
            </div>
            <div class="col-md-6">
                <?php

                 if(!$model->isNewRecord){
                     $items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
                 echo $form->field($model, 'province_id')->widget(Select2::classname(), [
                    'data' => $items,
                     'options' => ['placeholder' => 'Select Province ...','class'=>'state','data-url'=>Url::to(['student/province'])],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
                 }else{
                     //$items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
                 echo $form->field($model, 'province_id')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Province ...','class'=>'state','data-url'=>Url::to(['student/province'])],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
                 }


                 ?>
            </div>

            


            <div class="col-md-6">
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
            <div class="col-md-6">
                <?php 

                 if(!$model->isNewRecord){
                    $city = ArrayHelper::map(RefCities::find()->all(), 'city_id', 'city_name');
                 echo $form->field($model, 'city_id')->widget(Select2::classname(), [
                     'data' => $city,
                     'options' => ['placeholder' => 'Select City ...','class'=>'city',Url::to(['student/district'])],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
                 }else{

                 echo $form->field($model, 'city_id')->widget(Select2::classname(), [
                    
                     'options' => ['placeholder' => 'Select City ...','class'=>'city',Url::to(['student/district'])],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
                 }



                 ?>
            </div>
        </div>
    </fieldset>

    <!-- <div class="row">
                <div class="col-md-6">
                    <?//= $form->field($model, 'permanent_address')->radioList([1 => 'As Above',2=>'different'], ['itemOptions' => ['class' =>'radio-inline permanent_address']]);?>
                </div>
                <div class="col-md-6"></div>
            </div> -->

    <!--=========================== address 2===================!-->
    <div class="address2" style="display:none">
        <div class="col-md-6">
            <?= $form->field($model, 'location2')->textArea(['maxlength' => true,'class'=>' form-control']) ?>
        </div>
        <div class="col-md-6">
            <?php
            $country = ArrayHelper::map(RefCountries::find()->all(), 'country_id', 'country_name');
            echo $form->field($model, 'fk_ref_country_id2')->widget(Select2::classname(), [
                'data' => $country,
                'options' => ['placeholder' => 'Select a Country ...','class'=>'country2','data-url'=>Url::to(['student/country']) ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-6">
            <?php

            if(!$model->isNewRecord){
                $items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
                echo $form->field($model, 'fk_ref_province_id2')->widget(Select2::classname(), [
                    'data' => $items,
                    'options' => ['placeholder' => 'Select Province ...','class'=>'state2','data-url'=>Url::to(['student/province'])],
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
        </div>
        <div class="col-md-6">
            <?php

            if(!$model->isNewRecord){
                $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
                echo $form->field($model, 'fk_ref_district_id2')->widget(Select2::classname(), [
                    'data' => $district_array,
                    'options' => ['placeholder' => 'Select District ...','class'=>'district2'],
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
            <?php

            if(!$model->isNewRecord){
                $city = ArrayHelper::map(RefCities::find()->all(), 'city_id', 'city_name');
                echo $form->field($model, 'fk_ref_city_id2')->widget(Select2::classname(), [
                    'data' => $city,
                    'options' => ['placeholder' => 'Select City ...','class'=>'city2',Url::to(['student/district'])],
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
    </fieldset>
</div>
</div>
<div class="student-info-form form-center">
    <div class="footer_btns_outside">
    <!-- =============== end of address 2 ==========!--> 

    <div class="form-group">
         <?= Html::a('Cancel',['student/index'], ['class' => 'btn grey-btn pull-left']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn pull-right' : 'btn green-btn pull-right', 'value'=>'create', 'name'=>'submit','style'=>'margin-left:3px']) ?>
         <?= ($model->isNewRecord)?Html::submitButton('Create & Continue', ['class' => $model->isNewRecord ? 'btn green-btn pull-right' : 'btn green-btn pull-right', 'value'=>'create_continue', 'name'=>'submit']):'' ?>
        </div>
    <?php ActiveForm::end(); ?>

   </div>
</div> 




<?php
if($model->isNewRecord !=1 && $model->is_hostel_avail == 1){
  
    //echo $model->different_address;
$script= <<< JS

$(document).ready(function() {
$('.hostel').show();
});
JS;
$this->registerJs($script);
}


?>


<?php
if($model->isNewRecord !=1 && $model->fk_stop_id > 0){
  
    //echo $model->different_address;
$script= <<< JS

$(document).ready(function() {
$('.displayRoute').show();
});
JS;
$this->registerJs($script);
}


?>


