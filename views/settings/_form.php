<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->registerJsFile(Yii::getAlias('@web').'/js/timedropper.js',['depends' => [yii\web\JqueryAsset::className()]]);
//$this->registerCssFile("/bitbucket/css/timedropper.css");
$this->registerCssFile(Yii::getAlias('@web').'/css/timedropper.css',['depends' => [yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */

$days =  ['01'=>'1','02'=>'2','03'=>'3','04'=>'4','05'=>'5','06'=>'6','07'=>'7','08'=>'8','09'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'];
$no_chields =[1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'];
$no_discount =[10=>'10',20=>'20',25=>'25',30=>'30',50=>'50',75=>'75',100=>'100'];
?>

<div class="settings-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'fee_due_date')->dropDownList($days,['prompt'=>'Select due date day']) ?>
            <span id="due_date"><?php
                if(!$model->isNewRecord) {
                    $day = $model->fee_due_date;
                    echo 'Due Date : '.date($day.'-m-Y');
                } ?></span>
        </div>
        <div class="col-md-6">
            <?=$form->field($model, 'school_time_in')->textInput(['class'=>'alarm form-control','id'=>'val']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=$form->field($model, 'school_time_out')->textInput(['class'=>'alarm form-control','id'=>'val2']);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'theme_color')->dropDownList([ 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue', ], ['prompt' => 'Select theme color']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'student_reg_type')->dropDownList(['auto'=>'Auto','manual'=>'Manual'],['prompt'=>'Select Registration Type']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'challan_copies')->dropDownList([ '1' => '1 Copy', '2' => '2 Copies', '3' => '3 Copies', ], ['prompt' => 'Select no. of copies']) ?>
        </div>
    </div>
    <fieldset class="scheduler-border">
        <legend>Bank Account Settings:</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'fee_bank_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'fee_bank_account')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'salary_bank_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'salary_bank_account')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </fieldset>

    <fieldset class="scheduler-border">
        <legend>Sibling Settings:</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="input-wrap-radio-head">
                    <div class="clearfix" id="UserLogin-gender">
                        <label class="radio-head">Sibling Discount Head</label>
                        <?=
                        $form->field($model, 'sibling_discount_head')
                            ->radioList(
                                $modelHead,
                                [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        if($index ==0 ){
                                            $index++;
                                        }
                                        if($checked) {
                                            $radiochk = 'checked="checked"';
                                        }else{
                                            $radiochk = '';
                                        }
                                        $return = '<div class="col-md-6"><label>';
                                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" '.$radiochk.'>';
                                        $return .= '<i></i>';
                                        $return .= '&nbsp;<span>' . ucwords($label) . '</span>';
                                        $return .= '</label></div>';
                                        if ($index != 0) {
                                            if($index%2 == 0){
                                                $return .= '<br/>';
                                            }
                                        }

                                        return $return;
                                    }
                                ]
                            )
                            ->label(false);
                        ?>
                    </div>
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-wrap-sibling-discount">
                    <div class="clearfix" id="UserLogin-gender">
                        <label class="radio-head">Sibling Discount %</label>
                        <?php
                        echo $form->field($model, 'sibling_discount')
                            ->radioList(
                                $no_discount,
                                [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        if($checked) {
                                            $radiochk = 'checked="checked"';
                                        }else{
                                            $radiochk = '';
                                        }
                                        if($index ==0 ){
                                            $index++;
                                        }
                                        $return_sibling_discount = '<div class="col-md-6"><label>';
                                        $return_sibling_discount .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" '.$radiochk.' >';
                                        $return_sibling_discount .= '<i></i>';
                                        $return_sibling_discount .= '&nbsp;<span>' . ucwords($label) . '%</span>';
                                        $return_sibling_discount .= '</label></div>';
                                        /* if($index != 0 && $index%2 == 0){
                                             $return .= '<br/>';
                                         }*/
                                        if ($index != 0) {
                                            if($index%2 == 0){
                                                $return_sibling_discount .= '<br/>';
                                            }
                                        }

                                        return  $return_sibling_discount;
                                    }
                                ]
                            )
                            ->label(false);
                        ?>
                    </div>
                </div>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <?= $form->field($model, 'sibling_no_childs')->dropDownList($no_chields,['prompt'=>'Select No. of Child\'s']) ?>
            </div>
            <div class="col-md-6"></div>
        </div>
    </fieldset>
    <fieldset class="scheduler-border">
        <legend>Active Discount on Heads</legend>
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" id="fee_heads_url" value="<?=Url::to('fee-heads/set-discount-status')?>" />
                <div class="row">
                    <?php
                    $i=0;
                    $return = '';
                    foreach($modelFeeHeads as $key=>$head){
                        if($head->discount_head_status==1){
                            $radiochk = 'checked="checked"';
                        }else{
                            $radiochk = '';
                        }
                        $return .= '<div class="col-md-6"><label>';
                        $return .= '<input type="checkbox" name="active_head_discount" value="' . $head->id . '" tabindex="3" '.$radiochk.'>';
                        $return .= '<i></i>';
                        $return .= '&nbsp;<span>' . ucwords($head->title) . '</span>';
                        $return .= '</label></div>';

                        $i++;
                    }

                    echo  $return;
                    ?>
                </div>
                <div id="help-block-heads"  class="col-md-12"></div>
            </div>
            <div class="col-md-6"></div>
        </div>

    </fieldset>
    <fieldset class="scheduler-border">
        <legend>Admission Heads</legend>
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" id="fee_onetime_head_url" value="<?=Url::to('fee-heads/set-onetime-head')?>" />
                <div class="row">
                    <?php
                    $i=0;
                    $return = '';
                    foreach($modelFeeHeads as $key=>$head){
                        if($head->one_time_only == 1){
                            $radiochk = 'checked="checked"';
                        }else{
                            $radiochk = '';
                        }
                        $return .= '<div class="col-md-6"><label>';
                        $return .= '<input type="checkbox" name="onetime_head_only" value="' . $head->id . '" tabindex="3" '.$radiochk.'>';
                        $return .= '<i></i>';
                        $return .= '&nbsp;<span>' . ucwords($head->title) . '</span>';
                        $return .= '</label></div>';

                        $i++;
                    }

                    echo  $return;
                    ?>
                </div>
                <div id="help-block-heads"  class="col-md-12"></div>
            </div>
            <div class="col-md-6"></div>
        </div>

    </fieldset>
    <fieldset class="scheduler-border">
        <legend>Promotion Heads</legend>
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" id="fee_promotion_head_url" value="<?=Url::to('fee-heads/set-promotion-head')?>" />
                <div class="row">
                    <?php
                    $i=0;
                    $return = '';
                    foreach($modelFeeHeads as $key=>$head){
                        if($head->promotion_head == 1){
                            $radiochk = 'checked="checked"';
                        }else{
                            $radiochk = '';
                        }
                        $return .= '<div class="col-md-6"><label>';
                        $return .= '<input type="checkbox" name="promotion_only" value="' . $head->id . '" tabindex="3" '.$radiochk.'>';
                        $return .= '<i></i>';
                        $return .= '&nbsp;<span>' . ucwords($head->title) . '</span>';
                        $return .= '</label></div>';

                        $i++;
                    }

                    echo  $return;
                    ?>
                </div>
                <div id="help-block-heads"  class="col-md-12"></div>
            </div>
            <div class="col-md-6"></div>
        </div>

    </fieldset>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn pull-right' : 'btn green-btn pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
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
/*on check active inactive branch discounts*/
$(document).on('click','input[name="active_head_discount"]',function() {
  var url= $('#fee_heads_url').val();
  var headId= $(this).val();
  var thisData = $(this);
  if($(this).is(':checked')==true){ 
        status = 1;
    }else{ 
        status =0;
    } 
    if(headId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                head_id:headId,
                status:status
            },

            success: function(data)
            {
                if(data.status ==1){
                    $('#help-block-heads').html(data.message);
                }
            }
        });
    }
});
$(document).on('click','input[name="onetime_head_only"]',function() {
  var url= $('#fee_onetime_head_url').val();
  var headId= $(this).val();
  var thisData = $(this);
  if($(this).is(':checked')==true){ 
        status = 1;
    }else{ 
        status =0;
    } 
    if(headId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                head_id:headId,
                status:status
            },

            success: function(data)
            {
                if(data.status ==1){
                    $('#help-block-heads').html(data.message);
                }
            }
        });
    }
});

$(document).on('click','input[name="promotion_only"]',function() {
  var url= $('#fee_promotion_head_url').val();
  var headId= $(this).val();
  var thisData = $(this);
  if($(this).is(':checked')==true){ 
        status = 1;
    }else{ 
        status =0;
    } 
    if(headId){
        $.ajax
        ({
            type: "POST",
            dataType:"JSON",
            url: url,
            data: {
                head_id:headId,
                status:status
            },

            success: function(data)
            {
                if(data.status ==1){
                    $('#help-block-heads').html(data.message);
                }
            }
        });
    }
});
JS;
$this->registerJs($script);
?>

</div>
