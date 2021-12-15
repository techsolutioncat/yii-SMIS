<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\RefCountries;
use app\models\RefProvince;
use app\models\Profession;
use app\models\RefSession;
use app\models\RefGroup;
use app\models\RefShift;
use app\models\RefClass;      
use app\models\RefSection;
use app\models\RefCities;
use app\models\Zone;
use app\models\Stop;
use app\models\RefGardianType;
use app\models\HostelFloor;
use app\models\HostelRoom;
use app\models\HostelBed;
use app\models\RefDegreeType;
use app\models\RefInstituteType;
use app\models\Hostel;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/normalize.css");
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/main.css");
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/jquery.steps.css");
$this->registerJsFile(Yii::getAlias('@web').'/js/students/html2pdf.bundle.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/jquery.steps.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/custom-step.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/previewstudent.js',['depends' => [yii\web\JqueryAsset::className()]]);

$this->title = 'Student Admission Wizard';

/*$array_std_counter= [];
for($i = $branch_std_counter;$i <1000; $i++){
    $array_std_counter[] = ['id'=>'TMSS-ATD-'.date("Y").'-'.$i,'roll-no'=>$i];
}

$arraymap_student_counter = ArrayHelper::map($array_std_counter,'id','roll-no');*/
?>
<div class="content content_col">
<div class="shade content-mini grey-form">
	<?php $form = ActiveForm::begin(['id'=>'admission-form','enableClientValidation'=>false]); ?>
        <div id="wizard">
        <h2>Initial</h2> <!-- first step  -->
        <section>
            <div class="row">
                <div class="col-md-6">
                    <p>
                    <!-- <div style="display: none;"> -->
                         <?php
                               /* $session = ArrayHelper::map(RefSession::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'session_id', 'title');
                                  $form->field($model, 'session_id')->widget(Select2::classname(), [
                                    'data' => $session,
                                    'options' => ['data-url'=>Url::to(['student/get-class'])],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);*/

                            ?>
                        <!-- </div> -->
                        <?php 
                    $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');?>
                        <?= $form->field($model, 'class_id')
                        ->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select'.' '. Yii::t('app','Class'),'class'=>'form-control classprev'])->label(Yii::t('app','Class').' <span style="color:#a94442;">*</span>'); 
/*
                            echo $form->field($model, 'class_id')->widget(Select2::classname(), [
                    //'data' => $zone,
                    'options' => ['id'=>'class-id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);*/

                        ?>
                        
                        <?php
                        
                        if($model->isNewRecord!='1'){
                        $section = ArrayHelper::map(RefSection::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'section_id', 'title');
                        echo $form->field($model, 'section_id')->widget(Select2::classname(), [
                            'data' => $section,
                            'options' => ['placeholder' => 'Select section ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(Yii::t('app','Section').'<span style="color:#a94442;">*</span>');
                        }
                        else{
                            echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
                                'options' => ['id'=>'section-id','class'=>'form-control sectionPrev'],
                                'pluginOptions'=>[
                                    'depends'=>[
                                        'group-id','class-id'
                                    ],
                                    'prompt' => 'Select section',
                                    'url' => Url::to(['/site/get-section'])
                                ]
                            ])->label(Yii::t('app','Section').'<span style="color:#a94442;">*</span>');
                        }
                        ?>
                       
                        
                        <?= $form->field($model2, 'cnic')->widget(\yii\widgets\MaskedInput::className(), [
                            'mask' => ['99999-9999999-9', '9999-999-99999'],'options'=>['class'=>'input form-control','id'=>'input1','data-url'=>Url::to(['student/parent-cnic']),'data-branch'=>yii::$app->common->getBranch()]
                        ])->label(Yii::t('app','Father Cnic').' <span style="color:#a94442;">*</span>')?>
                        <div class="form-group radio-col"> 
                        <?= Html::label(Yii::t('app','Transport Facility'))?> <br />
                        <span>
							<?= Html::label('Yes');?>
                            <input type="radio" name="StudentInfo[is_transport_avail]" value="1" style="display: inline" class="stops inputes" id="transportYes" />
                        </span>
                        <span>
							<?= Html::label('No');?>
                            <input type="radio" name="StudentInfo[is_transport_avail]" value="0" checked="checked" style="display: inline" class="stops inputes" id="transportYes" />
                       </span>
                        </div>
                        <div class="form-group radio-col"> 
                    <?= Html::label(Yii::t('app','Hostel Facility'))?>
                    <?= $form->field($model, 'is_hostel_avail')->radioList([1 => 'Yes', 0 => 'No'], ['itemOptions' => ['class' =>'radio-inline hosteldetail inputes','id'=>'hostelInitial']])->label(false); ?>
                    </div> 
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                    
                   <?php

                if($model->isNewRecord!='1'){
                $group = ArrayHelper::map(RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'group_id', 'title');
    
                echo $form->field($model, 'group_id')->widget(Select2::classname(), [
                        'data' => $group,
                        //'options' => ['placeholder' => 'Select Shift ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }else{
                echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id','class'=>'form-control groupPrev'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                 }
                ?>
                
                <?php
                $shift = ArrayHelper::map(RefShift::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'shift_id', 'title');
                    echo $form->field($model, 'shift_id')->widget(Select2::classname(), [
                        'data' => $shift,
                        'options' => ['class' => 'form-control shiftPrev','id'=>'shift-id'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                 ?>
                 <div id="displaychild" style="display: none; font-weight: bold">Child Is:</div>
                 <div class="cnicDisplay" style="font-weight: bold"></div>
            </p>
                </div>
            </div>
        </section>
        <h2>Transport</h2> <!-- /Boarding second step -->
        <section>
            <div class="row">
                <div class="col-md-6">
                         <!-- display transport -->
                    <div class="displayRoute" style="display: none">
                   <?php
    
                $zone = ArrayHelper::map(Zone::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'title');
                echo $form->field($model, 'zone')->widget(Select2::classname(), [
                    'data' => $zone,
                    'options' => ['placeholder' => 'Select Zone ...','class'=>'zonechange zonePrev','data-url'=>\yii\helpers\Url::to(['student/get-route'])],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
    
    
                echo $form->field($model, 'route')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Route ...','class'=>'route routePrev','data-url'=>\yii\helpers\Url::to(['student/get-stop'])],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
    
                if($model->isNewRecord!='1'){
                $gtStop = ArrayHelper::map(Stop::find()->all(), 'id', 'title');
                echo $form->field($model, 'fk_stop_id')->widget(Select2::classname(), [
                     'data' => $gtStop,
                     'options' => ['prompt' => 'Select Stop ...','class'=>'stop'],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
                }else{
                 echo $form->field($model, 'fk_stop_id')->widget(Select2::classname(), [
                    //'data' => $items,
                     'options' => ['placeholder' => 'Select Stop ...','class'=>'stop stopPrev'],
                     'pluginOptions' => [
                         'allowClear' => true
                     ],
                 ]);
            }
                ?>
                </div>
                </div>
                <div class="hostel col-md-6" style="display: none;">
                    <?php
                    $hostel = ArrayHelper::map(\app\models\Hostel::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all(), 'id', 'Name');
                    $floor = ArrayHelper::map(\app\models\HostelFloor::find()->all(), 'id', 'title');
                    $bed = ArrayHelper::map(\app\models\HostelBed::find()->all(), 'id', 'title');
                    $room = ArrayHelper::map(\app\models\HostelRoom::find()->all(), 'id', 'title');
                    $student = ArrayHelper::map(\app\models\StudentInfo::find()->all(), 'stu_id', 'user_id');
    
                    echo $form->field($hostelDetailModel, 'fk_hostel_id')->widget(Select2::classname(), [
                        'data' => $hostel,
                        'options' => ['placeholder' => 'Select Hostel ...','class'=>'hostelAll hostelPrev','data-url'=>\Yii\helpers\url::to(['student/get-hostel-floor'])],
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
                            'options' => ['placeholder' => 'Select Hostel Floor ...','class'=>'floorAjax floorPrev','data-url'=>\yii\helpers\Url::to(['student/get-floor-room'])],
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
                            'options' => ['placeholder' => 'Select Hostel Room ...','class'=>'roomBed roomPrev','data-url'=>\yii\helpers\Url::to(['student/get-bed'])],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    }
    
                    ?>
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
                            'options' => ['placeholder' => 'Select Room Bed ...','class'=>'beds bedPrev','data-url'=>Url::to('check-bed-assigned')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    }
    
                    echo $form->field($hostelDetailModel, 'create_date')->widget(DatePicker::classname(), [
                        'options' => ['value' => date('Y-m-d'),'class'=>'inputes','id'=>'alomentdate'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'startDate' => '-2y',
                        ]
                    ]);
    
                    echo  $form->field($hostelDetailModel, 'is_booked')->hiddenInput(['class'=>'active'])->label(false);
    
                    ?>
                    <input type="hidden" id="overall-error" value="0"/>
                    </div>
            </div>
        </section> 
        <h2>Personnel</h2> <!-- fourth step -->
        <section>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    echo $form->field($userModel, 'Image')->fileInput();
                    if(!$userModel->isNewRecord){
                        $src=Yii::$app->request->baseUrl.'/uploads/'.$userModel->Image;
                        echo Html::img( $src, $options = ['width'=>60,'height'=>'60','alt'=>'No Image Uploaded'] );
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                        echo $form->field($model, 'dob')->widget(DatePicker::classname(), [
                                'options' => [
                                    'value' => (!$model->isNewRecord)?$model->dob:date('Y-m-d'),
                                    'class'=>'inputes','id'=>'dobdate'
                                ],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'endDate' => '-2y',
                                    //'startDate' => '-2y',
                                ]
                        ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if(Yii::$app->common->getBranchSettings()->student_reg_type == 'auto'){

                        ?>
                        <?=$form->field($userModel, 'username')->textInput(['readonly'=>true,'maxlength' => true,'value'=>Yii::$app->common->getBranchDetail()->name.'-'.date("Y").'-'.($branch_std_counter+1),'id'=>'registeration','class'=>'form-control input form-control','id'=>'registeration','data-url'=>Url::to('validate-usrname')])?>
                        <?php
                    }else{
                        ?>
                        <?=$form->field($userModel, 'username')->textInput(['maxlength' => true,'id'=>'registeration','class'=>'form-control input form-control','id'=>'registeration','data-url'=>Url::to('validate-usrname')])?>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($userModel, 'first_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase','class'=>'input form-control','id'=>'firstnamePersonnel']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($userModel, 'middle_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase','class'=>'input form-control','id'=>'middlenamePerssonel']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($userModel, 'last_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase','class'=>'input form-control','id'=>'lastnamepersonel']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($userModel, 'name_in_urdu')->textInput(['maxlength' => true,'class'=>'form-control input','id'=>'urdunamepersonnel']) ?>
                </div>
                <div class="col-md-6">
    
                    <?= $form->field($model, 'gender_type')->radioList([1 => 'Male', 0 => 'Female'], ['itemOptions' => ['class' =>'radio-inline inputes','id'=>'gendderStudent']])?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'location1')->textArea(['maxlength' => true,'class'=>'form-control input','id'=>'location1']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'withdrawl_no')->textInput(['class'=>'input form-control','id'=>'withdrawlno']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $country = ArrayHelper::map(RefCountries::find()->all(), 'country_id', 'country_name');
                    echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                        'data' => $country,
                        'options' => ['prompt'=>'Select Country','class'=>'country countryPrev','id','countryStudent','data-url'=>Url::to(['student/country']) ],
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
                            'options' => ['placeholder' => 'Select Province ...','class'=>'state provincePrev','id'=>'provinceStudent','data-url'=>Url::to(['student/province'])],
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
                            'options' => ['placeholder' => 'Select District ...','class'=>'district districtPrev','id'=>'districtStudent'],
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
    
                            'options' => ['placeholder' => 'Select City ...','class'=>'city cityPrev','id'=>'cityStudent',Url::to(['student/district'])],
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
                    <?php $religion_array = ArrayHelper::map(\app\models\RefReligion::find()->all(), 'religion_type_id', 'Title');
                    echo $form->field($model, 'religion_id')->widget(Select2::classname(), [
                        'data' => $religion_array,
                        'options' => ['class'=>'religionPrev form-control','id'=>'religionStudent'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                </div>
                <div class="col-md-6">
                    <div class="address2Show"  style="display: none">
                        <div class="col-md-6">
                            <?= $form->field($model, 'location2')->textArea(['maxlength' => true,'class'=>'permanent form-control']) ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=Yii::t('app','Country')?></label>
                            <input type="text" name="StudentInfo[fk_ref_country_id21]" class="form-control country21" value="" >
                        </div>
                        <div class="col-md-6">
                            <label><?=Yii::t('app','Province')?></label>
                            <input type="text" name="StudentInfo[fk_ref_province_id211]" id="povinces2" class="form-control provinces21" value="">
                        </div>
                        <div class="col-md-6">
                            <label><?=Yii::t('app','District')?></label>
                            <input type="text" name="StudentInfo[fk_ref_district_id23]" class="form-control district21">
                        </div>
                        <div class="col-md-6">
                            <label><?=Yii::t('app','City')?></label>
                            <input type="text" name="StudentInfo[fk_ref_city_id24]" class="form-control city21">
                        </div>
                        <!-- //get value -->
                        <input type="hidden" name="StudentInfo[fk_ref_country_id2]" class="form-control country2" value="">
                        <input type="hidden" name="StudentInfo[fk_ref_province_id3]" id="thisprovince" class="form-control getprovincesval" value="">
                        <input type="hidden" name="StudentInfo[fk_ref_district_id2]" class="form-control district2">
                        <input type="hidden" name="StudentInfo[fk_ref_city_id2]" class="form-control city2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'permanent_address')->radioList([1 => 'As Above',2=>'different'], ['itemOptions' => ['class' =>'radio-inline permanent_address']]);?>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row">
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
                <!-- =============== end of address 2 ==========!-->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!--============================= start of education ===============================!-->
                    <?php $degree_array = ArrayHelper::map(\app\models\RefDegreeType::find()->all(), 'degree_type_id', 'Title');
                    echo $form->field($StudentEducationalHistoryInfo, 'degree_type_id')->widget(Select2::classname(), [
                        'data' => $degree_array,
                        'options' => ['placeholder' => 'Select Degree ...','class'=>'degreePrev','id'=>'degreeStudent'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'Institute_name')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>"instituteStudent"]) ?>
                </div>
            </div>
            <div class="row">
    
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'grade')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>"gradeStudent"]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'marks_obtained')->textInput(['class'=>'input form-control','id'=>'marksontainedStudent']) ?>
                </div>
            </div>
            <div class="row">
    
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'total_marks')->textInput(['class'=>'input form-control','id'=>'marksStudent']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'degree_name')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>"degreenameStudent"]) ?>
                </div>
            </div>
            <div class="row">
    
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'start_date')->widget(DatePicker::classname(), [
                        'options' => ['value' => date('Y-m-d'),'class'=>'inputes','id'=>'startdateStudent'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy/mm/dd',
                            'todayHighlight' => true,
                        ]
                    ]);?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($StudentEducationalHistoryInfo, 'end_date')->widget(DatePicker::classname(), [
                        'options' => ['value' =>date('Y-m-d'),'class'=>'inputes','id'=>'enddateStudent'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy/mm/dd',
                            'todayHighlight' => true,
                        ]
                    ]);?>
                    <!--=========================================end of education =================!-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    echo $form->field($model, 'registration_date')->widget(DatePicker::classname(), [
                        'options' => [
                            'value' => (!$model->isNewRecord)?$model->registration_date:date('Y-m-d'),
                            'class'=>'inputes','id'=>'registration_date'
                        ],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <input type="hidden" id="overall-error" value="0"/>
        </section>
        <h2>Parents</h2> <!-- step five -->
        <section> 
                <p>
                    <?= $form->field($model, 'parent_status')->radioList([1 => 'Alive', 0 => 'Dead'], ['itemOptions' => ['class' =>'radio-inline parent_status' ]]) ?>
                </p>
                <!-- parents information -->
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend>Father Info</legend>
                            <?= Html::label(Yii::t('app','Full Name'))?>
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
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <legend>Mother Info</legend>
                        <?php echo Html::label(Yii::t('app','Full Name')) ?>
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
                <!--guardian details information.-->
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
                <!-- end of guardian --> 
        </section> 
        <h2>Address</h2>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <legend>Father Info</legend>
    
                        
                    <?= $form->field($model2, 'contact_no')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'fatherContact','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?>

                     <?= $form->field($model2, 'contact_no2')->textInput(['maxlength' => true,'class'=>'input form-control','id'=>'fatherContact','onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57'])->label('Emergency Contact No') ?>

                    

                        
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
        <h2>Fee Plan</h2> <!-- first step -->
        <section>
            <p>
            	<legend>Fee Plan</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'fk_fee_plan_type')->dropDownList(Yii::$app->common->getBranchFeePlan(), [
                                'id'=>'fee-plan-id',
                                'prompt' => 'Select Fee plan ...',
                                'class'=>'inputs form-control',
                                'data-url'=> Url::to(['get-fee-challan']),
                            ]); ?>
    
                        </div>
                        <div class="col-md-8" id="fee-plan-details"></div>
                    </div>
                </fieldset>
            </p>
        </section>
         <!-- Preview--> 
        <h2>Preview</h2>
        <section>
            <div class="row">
                <div id="preview">
                	<div class="mis_pre">   
                        <img class="img-prev" src="<?= Url::to('@web/img/pre1.svg') ?>" alt="MIS">
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-12">
                                <h3>Initial Information</h3>
                            </div>
                            <div class="mis_body"> 
                            	<p><?=Yii::t('app','Student Registration No')?>.: <span class="registeration"></span></p>
                                <p><?=Yii::t('app','First Name')?>: <span class="firstnamePersonnel"></span></p>
                                <p><?=Yii::t('app','Middle Name')?>: <span class="middlenamePerssonel"></span></p>
                                <p><?=Yii::t('app','Last Name')?>: <span class="lastnamepersonel"></span></p>
                                <p><?=Yii::t('app','Urdu Name')?>: <span class="urdunamepersonnel"></span></p>
                                <p><?=Yii::t('app','Class')?>: <span class="classp"></span></p>
                                <p><?=Yii::t('app','Group')?>: <span class="gid"></span></p>
                                <p><?=Yii::t('app','Section')?>: <span class="sid"></span></p>
                                <p><?=Yii::t('app','Shift')?>: <span class="shid"></span>Morning</p>
                                <p><?=Yii::t('app','Father Cnic')?>: <span class="input1"></span></p>
                                <p><?=Yii::t('app','Hostel Facility')?>: <span class="hostelInitial"></span></p>
                                <p><?=Yii::t('app','Transport Facility')?>: <span class="transportYes">0</span></p>
                            </div>
                        </div>
                        <div class="col-sm-6"> 
                        	<div class="mis_head col-sm-12">
                                <h3></h3>
                            </div>
                            <div class="mis_body">   
                                <p><?=Yii::t('app','Withdrawl No')?>: <span class="withdrawlno"></span></p>
                                <p><?=Yii::t('app','Postal Address')?>: <span class="location1"></span></p>
                                <p><?=Yii::t('app','Country')?>: <span class="countrid"></span></p>
                                <p><?=Yii::t('app','province')?>: <span class="provinceid"></span></p>
                                <p><?=Yii::t('app','District')?>: <span class="districtid"></span></p>
                                <p><?=Yii::t('app','City')?>: <span class="cityid"></span></p>
                                <p><?=Yii::t('app','Religion')?>: <span class="religionid">Islam</span></p>
                                <p><?=Yii::t('app','Gender')?>: <span class="gendderStudent">1</span></p>
                            </div>
                        </div> 
                    </div>  
                    <div class="mis_pre">  
                    	<img class="img-prev" src="<?= Url::to('@web/img/pre1.svg') ?>" alt="MIS">
                        <div class="col-sm-12">
                            <div class="mis_head col-sm-6">
                                <h3>Education Information</h3>
                            </div>
                            <div class="mis_body"> 
                                <p><?=Yii::t('app','Degree Type')?>.: <span class="degreeid"></span></p>
                                <p><?=Yii::t('app','Institute Name')?>: <span class="instituteStudent"></span></p>
                                <p><?=Yii::t('app','Grade')?>: <span class="gradeStudent"></span></p>
                                <p><?=Yii::t('app','Total marks')?>: <span class="marksStudent"></span></p>
                                <p><?=Yii::t('app','Degree Name')?>: <span class="degreenameStudent"></span></p>
                                <p><?=Yii::t('app','Start Date')?>: <span class="startdateStudent"></span></p>
                                <p><?=Yii::t('app','End Date')?>: <span class="enddateStudent"></span></p>
                                <p><?=Yii::t('app','Marks Obtained')?>: <span class="marksontainedStudent"></span></p>
                            </div>
                        </div>  
                    </div>  
                    <div class="mis_pre"> 
                    	<img class="img-prev" src="<?= Url::to('@web/img/pre2.svg') ?>" alt="MIS"> 
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3>Parents</h3>
                            </div>
                            <div class="mis_body"> 
                                <p><?=Yii::t('app','Full Name')?>: <span class="fatherName"></span></p>
                                <p><?=Yii::t('app','Profession')?>: <span class="professionid"></span></p>
                                <p><?=Yii::t('app','Designation')?>: <span class="fatherDesignation"></span></p>
                                <p><?=Yii::t('app','Organization')?>: <span class="fatherOrg"></span></p>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3>Gardian</h3>
                            </div>
                            <div class="mis_body"> 
                                <p><?=Yii::t('app','Full Name')?>: <span class="motherName"></span></p>
                                <p><?=Yii::t('app','Profession')?>: <span class="motherpid"></span></p>
                                <p><?=Yii::t('app','Designation')?>: <span class="motherDesignation"></span></p>
                                <p><?=Yii::t('app','Organization')?>: <span class="motherOrg"></span></p>
                                <p><?=Yii::t('app','Verifiedby')?>: <span class="Verifiedby"></span></p>
                            </div>
                        </div> 
                    </div> 
                    <div class="mis_pre">  
                    	<img class="img-prev" src="<?= Url::to('@web/img/pre3.svg') ?>" alt="MIS">
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3>Parents Contact</h3>
                            </div>
                            <div class="mis_body"> 
                                <p><?=Yii::t('app','Contact No')?>: <span class="fatherContact"></span></p>
                                <p><?=Yii::t('app','Office No')?>: <span class="fatherOffice"></span></p>
                                <p><?=Yii::t('app','Email')?>: <span class="fatherEmail"></span></p>
                                <p><?=Yii::t('app','Facebook ID')?>: <span class="fatherFb"></span></p>
                                <p><?=Yii::t('app','Twitter ID')?>: <span class="fatherT"></span></p>
                                <p><?=Yii::t('app','Linkdin ID')?>: <span class="fatherl"></span></p>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3>Gardian Contact</h3>
                            </div>
                            <div class="mis_body"> 
                               <p><?=Yii::t('app','Contact No')?>: <span class="motherContact"></span></p>
                                <p><?=Yii::t('app','Office No')?>: <span class="motherOffice"></span></p>
                                <p><?=Yii::t('app','Email')?>: <span class="motherEmail"></span></p>
                                <p><?=Yii::t('app','Facebook ID')?>: <span class="motherFb"></span></p>
                                <p><?=Yii::t('app','Twitter ID')?>: <span class="motherT"></span></p>
                                <p><?=Yii::t('app','Linkdin ID')?>: <span class="motherl"></span></p>
                            </div>
                        </div> 
                    </div>
                    <div class="mis_pre">  
                    	<img class="img-prev" src="<?= Url::to('@web/img/pre4.svg') ?>" alt="MIS">
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3>Transport Info</h3>
                            </div>
                            <div class="mis_body"> 
                                <p><?=Yii::t('app','Zone')?>: <span class="zoneid"></span></p>
                                <p><?=Yii::t('app','Route')?>: <span class="routeid"></span></p>
                                <p><?=Yii::t('app','Stop')?>: <span class="stopid"></span></p>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="mis_head col-sm-6">
                                <h3><?=Yii::t('app','Grade')?>Hostel Info</h3>
                            </div>
                            <div class="mis_body">
                                <p><?=Yii::t('app','Hostel')?>: <span class="hostelid"></span></p>
                                <p><?=Yii::t('app','Floor')?>: <span class="floorid"></span></p>
                                <p><?=Yii::t('app','Room')?>: <span class="roomid"></span></p>
                                <p><?=Yii::t('app','Bed')?>: <span class="bedid"></span></p>
                                <p><?=Yii::t('app','Allotment Date')?>: <span class="alomentdate"></span></p>
                            </div>
                        </div> 
                    </div>
                    <div class="mis_pre">
                    	<img class="img-prev" src="<?= Url::to('@web/img/pre5.svg') ?>" alt="MIS">
                    	<div class="col-sm-12">
                            <div class="mis_head col-sm-6">
                                <h3>Fee</h3>
                            </div>
                            <div class="mis_body"> 
                                 <div id="preview-fee"></div>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div> 
        </section>
         <!--end of preview -->  
    </div>
        <!-- end of wizard -->
    <?php ActiveForm::end(); ?>
</div>
</div>

