<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\FeeHeads */
/* @var $form yii\widgets\ActiveForm */
$arrayFeeMethods = ArrayHelper::map(\app\models\FeePaymentMode::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'id','title');
if(!$model->isNewRecord){
    if($model->extra_head ==1){
        $check = 'style="display:none;"';
    }else{
        $check = '';
    }
}else{
    $check = '';
}
if($model->isNewRecord){
    $model->extra_head =0;
    $model->one_time_only =0;
}

?>
<script type="text/javascript">
 $(document).ready(function () { 

$("#feeheads-one_time_only").click(function(){
   
    var radioValue = $('input[name="FeeHeads[one_time_only]"]:checked').val();
//     alert("hi"+radioValue);
    if(radioValue == 1){
        $('#feeMethod').hide();
    }else {
        $('#feeMethod').show();
    }
});
});

</script>
<div class="fee-heads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_branch_id')->hiddenInput(['value'=>yii::$app->common->getBranch()])->label(false); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'created_date')->hiddenInput(['maxlength' => true,'value'=>date("Y-m-d H:i:s")])->label(false) ?>
<div class="row">
    <div class="col-md-6">
         <div class="input-wrap">
        <div class="clearfix" id="UserLogin-gender">
            <label class="radio-head">Extra head</label>
            <?=
            $form->field($model, 'extra_head')
                ->radioList(
                    [1 => 'Yes', 0 => 'No'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if($checked) {
                                $radiochk = 'checked="checked"';
                            }else{
                                $radiochk = '';
                            }
                            $return = '<label class="modal-radio">';
                            $return .= '<input   type="radio" name="' . $name . '" value="' . $value . '" tabindex="3"'.$radiochk.'>';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

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
            <div id="extra_head" <?=($check)?>>
        <div class="input-wrap">
            <div class="clearfix" id="UserLogin-gender">
                <label class="radio-head">One time payment</label>
               
                <?=
                $form->field($model, 'one_time_only')
                    ->radioList(
                        [1 => 'Yes', 0 => 'No'],
                        [
                            'item' => function($index, $label, $name, $checked, $value) {
                                if($checked) {
                                    $radiochk = 'checked="checked"';
                                }else{
                                    $radiochk = '';
                                }

                                $return = '<label class="modal-radio">';
                                $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3"'.$radiochk.'>';
                                $return .= '<i></i>';
                                $return .= '<span>' . ucwords($label) . '</span>';
                                $return .= '</label>';

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
    </div>
        
</div>
      
    <div id='feeMethod' style='<?php echo (!$model->isNewRecord && $model->one_time_only==1) ? "display:none;" : "";?>'>
<?= $form->field($model, 'fk_fee_method_id')->widget(Select2::classname(), [
            'data' => $arrayFeeMethods,
            'options' => ['placeholder' => 'Select Fee Mode ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>
        </div>
   

  <!--  <div id="promotion_head" >
        <div class="input-wrap">
            <div class="clearfix" id="UserLogin-gender">
                <label class="radio-head">Promotion Head</label>
                <?/*=
                $form->field($model, 'promotion_head')
                    ->radioList(
                        [1 => 'Yes', 0 => 'No'],
                        [
                            'item' => function($index, $label, $name, $checked, $value) {
                                if($checked) {
                                    $radiochk = 'checked="checked"';
                                }else{
                                    $radiochk = '';
                                }

                                $return = '<label class="modal-radio">';
                                $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3"'.$radiochk.'>';
                                $return .= '<i></i>';
                                $return .= '<span>' . ucwords($label) . '</span>';
                                $return .= '</label>';

                                return $return;
                            }
                        ]
                    )
                    ->label(false);
                */?>
            </div>
            <div class="help-block"></div>
        </div>
    </div>-->



    <!-- <?//= $form->field($model, 'discount_head_status')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
