<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
?>
<div class="reports_wrap ">
    <ul class="nav nav-pills">
        <li ><a data-toggle="tab" href="#Single-Examination">Single Examination</a></li>
        <li><a data-toggle="tab" href="#Multiple-Examination">Multiple Examination</a></li>
        <li><a data-toggle="tab" href="#Class-Wise-Examination">Class Wise Examination</a></li>
        <li><a data-toggle="tab" href="#Top-Position">Top 5 Postion</a></li>
    </ul>
    <div class="tab-content">
        <div id="Single-Examination" class="tab-pane fade in">

        </div>
        <div id="Multiple-Examination" class="tab-pane fade">

        </div>
        <div id="Class-Wise-Examination" class="tab-pane fade">

        </div> 
        <div id="Top-Position" class="tab-pane fade">

        </div> 
      </div>
</div>
<div class="exportdmcs" data-url="<?=Url::to('export-all-dmc')?>">
	<!--<a class="btn green-btn" href="javascript:void(0);" >Export & Print All DMC'S</a>-->
</div>
<?php

Modal::begin([
    'header'=>'<h4></h4> ',
    'id'=>'modal-type',
    'options'=>[
        'data-keyboard'=>false,
        'data-backdrop'=>"static"
    ],
    'size'=>'modal-md',
    'footer' =>'<button type="button" class=" pull-left close" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-primary pull-right" id="search-exam-dmc" data-url="'.Url::to("std-dmc").'">Search</button>',

]);

// Normal select with ActiveForm & model

?>
<?php $form = ActiveForm::begin(); ?>
    <input type="hidden" id="class_id" name="class_id" value="<?=$class_id?>">
    <input type="hidden" id="group_id" name="group_id" value="<?=$group_id?>">
    <input type="hidden" id="section_id"  name="section_id" value="<?=$section_id?>">
    <div id="single-dropdown" style="display: none;">
        <?=$form->field($examModel, 'fk_exam_type[1]')->widget(Select2::classname(), [
            'data' => $exams,
            'options' => ['placeholder' => 'Select Exam type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>
    </div>
    <div id="multiple-dropdown" style="display: none;">
        <?=$form->field($examModel, 'fk_exam_type[2]')->widget(Select2::classname(), [
            'data' => $exams,
            'options' => ['multiple' => true, 'placeholder' => 'Select Multiple Exam type ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>
    </div>
    <input type="hidden" id="tab_type" name="tab_type" value =""/>
<?php ActiveForm::end(); ?>
<?php
Modal::end();

?>