<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\RefProvince;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/normalize.css");
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/main.css");
$this->registerCssFile(Yii::getAlias('@web')."/css/wizard/jquery.steps.css");
$this->registerJsFile(Yii::getAlias('@web').'/js/jquery.steps.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/branch-step.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/previewstudent.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/timedropper.js',['depends' => [yii\web\JqueryAsset::className()]]);
//$this->registerCssFile("/bitbucket/css/timedropper.css");
$this->registerCssFile(Yii::getAlias('@web').'/css/timedropper.css',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/jquery.form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("
    $('#branch-name').keyup(function() {
        var fullUrl = $('#branch-name').val().replace(' ', '-')+'.demo-momentum.com';
        $('.branch-url').html(fullUrl);
    });
    ",\yii\web\View::POS_READY);
$this->registerCss("
.duplicate {
    border: 1px solid red;
    color: red;
}
    ");

?>

<div class="content content_col">
<div class="shade content-mini grey-form">
<?php $form = ActiveForm::begin(['id'=>'branch-form','enableClientValidation'=>false,'options' => ['enctype' => 'multipart/form-data']]); ?>
 <div id="wizard">
                <h2>Branch Info</h2>
                <section>
 <div class="row">
        <div class="col-md-6">


           <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'eg. momentum-inc','data-url'=>Url::to(['branch/create-branch'])])->label('Branch Name') ?>
            <label class="bname" style="color:red" id="bnames"></label>
            <input type="hidden" id="exisbranch" data-url=<?php echo Url::to(['branch/branch-exists'])?> />
            <p class="branch-url"></p>
           <div id="existsBranch" style="color: red;"></div>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <label class="bdescription" style="color:red"></label>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $items = ArrayHelper::map(\app\models\RefCountries::find()->all(), 'country_id', 'country_name');
            echo $form->field($model, 'fk_country_id')->widget(Select2::classname(), [
                'data' => $items,
                'options' => ['placeholder' => 'Select Country ...','class'=>'country','data-url'=>Url::to(['student/country'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <label class="bcountry" style="color:red"></label>

        </div>
        <div class="col-md-6">
            <?php $items = ArrayHelper::map(RefProvince::find()->all(), 'province_id', 'province_name');
            echo $form->field($model, 'fk_province_id')->widget(Select2::classname(), [
               // 'data' => $items,
                'options' => ['placeholder' => 'Select Province ...','class'=>'state','data-url'=>Url::to(['student/province'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <label class="bprovince" style="color:red"></label>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6"> 
            <?php $district_array = ArrayHelper::map(\app\models\RefDistrict::find()->all(), 'district_id', 'District_Name');
            echo $form->field($model, 'fk_district_id')->widget(Select2::classname(), [
                //'data' => $district_array,
                'options' => ['placeholder' => 'Select District ...','class'=>'district'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <label class="bdistrict" style="color:red"></label>

        </div>
        <div class="col-md-6">
            <?php $city = ArrayHelper::map(\app\models\RefCities::find()->all(), 'city_id', 'city_name');
            echo $form->field($model, 'fk_city_id')->widget(Select2::classname(), [
                //'data' => $city,
                'options' => ['placeholder' => 'Select District ...','class'=>'city',Url::to(['student/district'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <label class="bcity" style="color:red"></label>

        </div>
    </div><div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <?php /*echo  $form->field($model, 'logo')->textInput(['maxlength' => true]) */?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            


            <label>Phone</label>
            
    <input type="text" class="form-control" id="branch-phone" name="Branch[phone]" onkeypress='return event.charCode >= 13 && event.charCode <= 57' /> 

        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
             
            
            

            <label>Email</label>
        <input type="email" id="branch-email" class="form-control text" name="Branch[email]" value="" placeholder="someone@example.com" maxlength="255" onblur="checkEmail(this.value)">
        <label class="bemail" style="color:red"></label>
        
            <?php

            /*$form->field($model, 'email')->widget(\yii\widgets\MaskedInput::className(),
             [
            'clientOptions' => [
               'alias' =>  'email'
                    ],
            ]); */


            ?>
            
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
        <div style="height: 15px"></div>
        <label>Zip</label>
            <input type="text" class="form-control" id="branch-zip" name="Branch[zip]" onkeypress='return event.charCode >= 13 && event.charCode <= 57' /> <br />
            <label class="bzip" style="color:red"></label>

            <!-- <?//= $form->field($model, 'title')->textInput(['maxlength' => true]) ?> -->

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->hiddenInput(['value'=>1])->label(false) ?>
            <?php
            // Usage with ActiveForm and model
            echo  $form->field($model, 'logo')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'initialPreview'=>[
                        /*Html::img(\Yii::$app->urlManagerFrontEnd->baseUrl. '/uploads/branch-logos/'.$model->get('Image'), ['class'=>'file-preview-image-logo', 'alt'=>$model->get('site_logo'), 'title'=>$model->get('site_logo'),'width'=>200,'height'=>45])*/null,
                    ],
                    'overwriteInitial'=>true,
                    'showUpload' => false
                ],
            ]);
            ?>
        </div>
    </div>
 </section>  <!-- end of first step -->
    
    <!-- start of second step -->
    <h2>Class Info</h2>
    <section>
     <p>
     
     <!-- code for generation of inputs -->
     <input type="button" id="timer" value="Add Another" class="btn btn-success" style="display: none;">
     <div class="row">
     
     <div class="col-md-6">
        <label id="classLabel">Number Of Classes To Add:</label>

        <input type="text" name="rows" class="form-control" id="pasval" onkeypress='return event.charCode >= 13 && event.charCode <= 57' data-url=<?php echo Url::to(['branch/get-input'])?> />
        
    <label id="claserror" style="color:red"></label>

    </div>
     <div class="col-md-4">
    
    <input type="hidden" name="Branch[branch_name]" class="branch_input">
    <div id="sesionclass">
    <?php $session = ArrayHelper::map(\app\models\RefSession::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'session_id', 'title'); ?>
       <?= $form->field($model2, 'fk_session_id')->widget(Select2::classname(), [
        'data' => $session,
        'options' => ['placeholder' => 'Select Session ...','data-url'=>Url::to(['branch/create-class']),'class'=>'sessn'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
        

    
    <label id="sesnerror" style="color:red"></label>

    <label id="sameclass" style="color: red"></label>

    

    
    <!-- <?//= $form->field($model2, 'title')->textInput(['maxlength' => true]) ?> -->
    
    </div>
    <br />
    <div style="height: 10px"></div>
    <div class="col-md-1">
        <input type="button" id="classesCreate" class="btn btn-success" value="Create" />
    </div>
    <div class="shows"></div>
     <div class="inputcls"></div>
     <input type="hidden" name="status" value="create" id="statuscreate"  />
    </div>
    <!-- /////////////////////////new code -->
    


<br /></br>
    <div class="row">
    <div class="col-md-2">
    
     
        
    </div><br />
    </div>
    <div class="row">
    
    <div class="col-md-6">
    <br/>
      <div id="duplicater">
      </div>  
    </div>
    </div>
     
    
     <!-- /////////////////////////////end of new code -->
     
     
     
     
    <!-- end of code for generation of inputs -->
    
    </p>
    </section> <!-- end of second step -->



                <h2>Fee Plan</h2>
                <section>
                    <p>
    <div class="row">
    <div class="col-md-6">
    <!-- <?//= $form->field($FeePaymentMode, 'title')->textInput(['maxlength' => true]) ?> -->
    
     <label id="feemodeLabel">Number Of Fee Modes To Add:</label>
     <input type="text" name="row" class="form-control addplan" id="feemode" data-url=<?php echo Url::to(['branch/fee-mood'])?> />
     <input type="hidden" name="" id="sendUrl" data-urls=<?php echo Url::to(['branch/create-fee-plan'])?>>


    </div>
    <br />
    <div style="height: 10px"></div>
    <div class="col-md-1">
        <input type="button" name="" id="feemodxx" value="Create" class="btn btn-success">
    </div>
    <div class="col-md-5">

     <!-- <?/*= $form->field($FeePaymentMode, 'time_span')->dropDownList([ 1 => '1 month', 2 => '2 months', 3 => '3 months', 4 => '4 months', 5 => '5 months', 6 => '6 months', 7 => '7 months', 8 => '8 months', 9 => '9 months', 10 => '10 months', 11 => '11 months', 12 => '12 months', ],
      ['prompt' => 'Select No. of month(s)','data-url'=>Url::to(['branch/create-fee-plan'])]) */?> -->
    <label id="femonth" style="color:red"></label>

   
    </div>

    </div>
    <label for="" id="samefeeplan" style="color: red"></label>
    <div class="row">
        <div class="femode"></div>
    <div class="lastid"></div>
    <input type="hidden" name="" id="statuscreatemode" value="create">
    </div>
    

    <div class="row">
    <div class="col-md-2">
    <input type="button" id="feePlanCreate" value="Add Another" class="btn btn-success" style="display: none">
     
        
    </div><br />
    </div>
    <div class="row">
    
    <div class="col-md-6">
    <br/>
      <div id="feePlanCreateduplicater">
      </div>  
    </div>
    <div class="col-md-6">
    <br/>
      <div id="feePlanCreateduplicaterMonthly">
      </div>  
    </div>
    </div>

    <br />
    <div class="alert alert-info">
        <strong>Note!</strong> E.g If you select time span 2 from drop down, It means that title will be calcualted twice a year.
    </div>
                    </p>
                </section>

                <h2>Fee Heads</h2>
                <section>
                    <p>
                        <div class="row">
        <div class="col-md-6">
     <label id="feeheadsLabel">Number Of Fee Heads To Add:</label>
     <input type="text" name="row" class="form-control" id="feeheads" data-url=<?php echo Url::to(['branch/fee-heads'])?> />
        </div>
         <br />
    <div style="height: 10px"></div>
    <div class="col-md-1">
        <input type="button" name="" id="feeheadxx" value="Create" class="btn btn-success">
    </div>
        <div class="col-md-5">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <?php /* $arrayFeeMethods = ArrayHelper::map(\app\models\FeePaymentMode::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'id','title'); ?>
            <?= $form->field($FeeHeads, 'fk_fee_method_id')->widget(Select2::classname(), [
                //'data' => $arrayFeeMethods,
                'options' => ['placeholder' => 'Select Fee Mode ...','data-url'=>Url::to(['branch/create-fee-head','id'=>'getFeedrpdoen'])],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);*/?>
            <input type="hidden" id="pamntmod" data-url=<?php echo Url::to(['branch/create-fee-head'])?> >
            <label id="metd"></label>
        </div>
        
        <label for="" id="sameHeads" style="color:red"></label>
    </div>
    <div class="feeHeads"></div>
    <div class="lastidx"></div>
    <input type="hidden" name="" id="statuscreateheads" value="create">


    <!-- new code of create -->
    <br />
    <div class="row">
    <div class="col-md-2">
    <input style="display:none;" type="button" id="feeHeadsCreatenew" value="Add Another" class="btn btn-success" data-url="<?php echo Url::to(['branch/fee-heads-create'])?>" />
     
        
    </div><br />
    </div>
    <div class="row">
    
    <div class="col-md-6">
    <br/>
      <div id="feeHeadsCreateduplicater">
      </div>  
    </div>
    <div class="col-md-6">
    <br/>
       <div id="FeeheadsuplicaterMonthly">
      <!-- <select id="FeeheadsuplicaterMonthly">
          <option value=""></option>
      </select> -->
      </div>  
    </div>
    </div>
    <!-- end of new code of create -->


                    </p>
                </section> <!-- end of step 4 -->


                <!-- assign fee -->
                 <h2>Assign Fee</h2>
                <section>
                    <p>
                         <div class="row">
                         <?php 
$feeHeadArray = ArrayHelper::map(\app\models\FeeHeads::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'id','title');
$classArray = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'class_id','title');
               ?>
        <div class="col-md-6">
        <?= $form->field($FeeGroup, 'fk_fee_head_id')->widget(Select2::classname(), [
                //'data' => $feeHeadArray,
                'options' => ['placeholder' => 'Select Fee Head ...','class'=>'getHed'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <label id="feeError" style="color: red"></label>
            
          </div>
          <div class="col-md-6">
           <?= $form->field($FeeGroup, 'amount')->textInput(['maxlength' => true,'onkeypress'=>'return event.charCode >= 13 && event.charCode <= 57']) ?> 
           <?= $form->field($FeeGroup, 'is_active')->hiddenInput(['value'=>'yes'])->label(false)?>
           <label for="" id="amountError" style="color: red"></label>

          </div>

         </div>
         <?php $getClasses=\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all();?>
         <div class="row">
         <div class="col-sm-12">
         <div class="alert alert-success alert-dismissable fade in" id="succesAlert" style="display: none">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Fee Assign Successfully...!
  </div>
  <?= Yii::$app->session->getFlash('error'); ?>
  <div id="exists"></div>
       <div class="handleClasses"></div>
  </div>
    


         
          <!-- <div class="col-sm-4">
            <label class="checkbox-inline">
              <input type="checkbox" value="<?php // echo $classes->class_id ?>" id="class-id" class="classesVal" name="FeeGroup[fk_class_id][]"><?php // echo $classes->title?></label>
          </div> -->
        
          </div>
          




                    </p>
                </section>
    
                <!-- end of assign fee -->


                <!-- fee plan type -->
                <h2>Fee Plan Types</h2>
                <section>
                    <p>
                      <div class="row">
        <div class="col-md-6">

        <label id="studentPlanCreate">Number Of Student Plans To Create:</label>
     <input type="text" name="row" class="form-control" id="planType" data-url=<?php echo Url::to(['branch/fee-plan-type'])?> />
     <input type="hidden" id="pasfeeurl" data-url="<?php echo Url::to(['branch/create-fee-typex'])?>">
        </div>
        <div class="col-md-1">
    <br />
    <div style="height:10px"></div>
     <input type="button" id="feeplantypx" value="Create" class="btn btn-success">
            
        </div>
        <div class="col-md-5">
        
        </div>
        

    </div>
    <label for="" id="samePlan" style="color: red"></label>
    <div class="row">
        <div class="col-md-6">
            <div class="showFeeType"></div>
            <div class="lastidxPlan"></div>
            <input type="hidden" name="" id="statuscreateplanType" value="create">
        </div>
    </div>
    <br />
                <!-- new code of create -->
    <div class="row">
    <div class="col-md-2">
    <input type="button" id="assignfeeplan" value="Add Another" class="btn btn-success" style="display: none;">
     
        
    </div><br />
    </div>
    <div class="row">
    
    <div class="col-md-6">
    <br/>
      <div id="assignfeeplanTitle">
      </div>  
    </div>
    <div class="col-md-6">
    <br/>
       <div id="assignfeeplanInstallments">
      
       </div>  
    </div>
    </div>
    <!-- end of new code of create -->


                    </p>
                </section>
    
                <!-- end of fee plan type -->
                
              <h2>Settings</h2>
                <section>
                    <p>
                        <div class="row">
        <div class="col-sm-6">
        <?php 
        $days =  ['01'=>'1','02'=>'2','03'=>'3','04'=>'4','05'=>'5','06'=>'6','07'=>'7','08'=>'8','09'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'];


        ?>
            <?= $form->field($settings, 'fee_due_date')->dropDownList($days,['prompt'=>'Select due date day','data-url'=>Url::to(['branch/settings'])]) ?>
            <span id="due_date"><?php
                if(!$settings->isNewRecord) {
                    $day = $settings->fee_due_date;
                    echo 'Due Date : '.date($day.'-m-Y');
                } ?></span>
                </div>
                <label id="fees" style="color: red"></label>
        
        <div class="col-md-6">
            <?=$form->field($settings, 'school_time_in')->textInput(['class'=>'alarm form-control','id'=>'val']); ?>
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
            <?=$form->field($settings, 'school_time_out')->textInput(['class'=>'alarm form-control','id'=>'val2']);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($settings, 'theme_color')->dropDownList([ 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue', ], ['prompt' => 'Select theme color']) ?>
            <label for="" style="color: red" id="themeerror"></label>
        </div>
        </div>
    <fieldset class="scheduler-border">
        <legend>Bank Account Settings:</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($settings, 'fee_bank_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($settings, 'fee_bank_account')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($settings, 'salary_bank_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($settings, 'salary_bank_account')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </fieldset>
                    </p>
                </section>  

            </div>
  <!-- end of wizard -->

 <?php ActiveForm::end(); ?>
 </div>
 </div> <!-- end of first div -->
  <?php
$script = <<< JS
 //$( ".alarm" ).timeDropper();
 $( ".alarm" ).timeDropper({

  // custom time format
  format: 'h:mm',

  // auto changes hour-minute or minute-hour on mouseup/touchend.
  autoswitch: false,

  // sets time in 12-hour clock in which the 24 hours of the day are divided into two periods. 
  meridians: false,

  // enable mouse wheel
  mousewheel: false,

  // auto set current time
  setCurrentTime: false,

  // fadeIn(default), dropDown
  init_animation: "fadein",

  // custom CSS styles
  primaryColor: "#1977CC",
  borderColor: "#1977CC",
  backgroundColor: "#FFF",
  textColor: '#555'
  
});  
JS;
$this->registerJs($script);
?>
<?php
$script = <<< JS
//$(document.ready)

JS;
$this->registerJs($script);
?>