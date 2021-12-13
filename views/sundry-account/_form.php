<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SundryAmount */
/* @var $form yii\widgets\ActiveForm */

?>

<div id="calendar_div" class="fee-challan-result fee-ch-right shade">

    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" value="<?=$stu_id?>" name="SundryAccount[student_id]"/>
    <input type="hidden" value="<?=($model->isNewRecord)?1:0?>" name="SundryAccount[record_status]"/>
    <div class="col-md-12 text-center"><p><strong>Advance Amount</strong></p></div>
    <div class="col-md-12">
        <div class="col-md-6">

            <?= $form->field($model, 'fee_submission_date')->widget(DatePicker::classname(), [
                'options' => [
                    'value' => ($model->fee_submission_date)?date('Y-m-d',strtotime($model->fee_submission_date)):date('Y-m-d'),
                    /*'disabled'=>($payable <= 0)?true:false*/
                ],
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'receipt_no')->textInput(['maxlength' => true]) ?>
        </div>
            <?php
             /*if($model->isNewRecord) {
                 */?><!--
                 <?/*= $form->field($model, 'fee_submission_date')->hiddenInput(['maxlength' => true,'value'=>null])->label(false) */?>
                 <?/*= $form->field($model, 'receipt_no')->hiddenInput(['maxlength' => true,'value'=>null])->label(false) */?>
                 <?php
/*
                 }else{
                 */?>
                <div class="col-md-6">

                <?/*= $form->field($model, 'fee_submission_date')->widget(DatePicker::classname(), [
                     'options' => [
                         'value' => ($model->fee_submission_date)?date('Y-m-d',strtotime($model->fee_submission_date)):date('Y-m-d'),

                     ],
                     'type' => DatePicker::TYPE_INPUT,
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy-mm-dd',
                         'todayHighlight' => true,
                     ]
                 ]);
                 */?>
                </div>
                <div class="col-md-6">
                    <?/*= $form->field($model, 'receipt_no')->textInput(['maxlength' => true]) */?>
                </div>
                --><?php
/*             }*/
            ?>

    </div>
    <?php
    if($model->isNewRecord){
        $model->fk_branch_id = Yii::$app->common->getBranch();
        $model->stu_id = $stu_id;

    }

    foreach ($active_heads as $heads){
        $headAmount = \app\models\SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_head_id'=>$heads['id'],'stu_id'=>$stu_id,'status'=>1])->one();
        ?>

        <div class="col-md-12">
            <div class="col-md-6">
                <?= $form->field($model, 'total_advance_bal['.$heads['id'].']')->textInput(['maxlength' => true, 'type' => 'number','value'=>(count($headAmount)>0)?$headAmount->total_advance_bal:0])->label($heads['title']) ?> </div>
            <div class="col-md-6">
            </div>
        </div>

        <?php
    }
    ?>
    <div class="col-md-12">
        <div class="col-md-6">
            <?= $form->field($model, 'transport_fare')->textInput(['maxlength' => true, 'type' => 'number','value'=>(count($headAmount)>0)?$headAmount->transport_fare:0]) ?> </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <?= $form->field($model, 'hostel_fare')->textInput(['maxlength' => true, 'type' => 'number','value'=>(count($headAmount)>0)?$headAmount->hostel_fare:0]) ?> </div>
        <div class="col-md-6">
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6"></div>
        <div class="col-md-6 ">
            <div class="form-group pull-right">
                <?= Html::submitButton($model->isNewRecord ? 'Add Amount' : 'Update Amount', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    
</div>
