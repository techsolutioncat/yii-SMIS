<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
/* @var $form yii\widgets\ActiveForm */

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');

?>

<div class="exam-form"> 
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
           <div class="col-sm-3"> 
           </div>
           <div class="col-sm-9">
            <div class="col-sm-4 fh_item">
            <?= $form->field($model, 'fk_class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select '.Yii::t('app','Class').'...']); ?>
        </div>
            <div class="col-sm-4 fh_item">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'fk_group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?>
    
            </div>
            <div class="col-sm-4 fh_item">
                <input type="hidden" id="subject-url" value="<?=Url::to(['/exams/all-subjects'])?>">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'fk_section_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'section-id'],
                    'pluginOptions'=>[
                        'depends'=>[
                            'group-id','class-id'
                        ],
                        'prompt' => 'Select section',
                        'url' => Url::to(['/site/get-section'])
                    ]
                ]);
                ?>
    
            </div>
           </div> 
        </div>  
   <!-- <div class="row">
        <div class="col-md-6">
            <?/*= $form->field($model, 'fk_exam_type')->textInput() */?>
        </div>
        <div class="col-md-6">
            <?/*= $form->field($model, 'total_marks')->textInput() */?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?/*= $form->field($model, 'passing_marks')->textInput() */?>
        </div>
        <div class="col-md-6">
            <?/*= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'options' => ['value' => date('Y-m-d')],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]);*/?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?/*= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                'options' => ['value' => date('Y-m-d')],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]);*/?>
        </div>
        <div class="col-md-6"></div>
    </div>--> 
  
	<?php /*if (!Yii::$app->request->isAjax){ */?><!--
	  	<div class="form-group">
	        <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) */?>
	    </div>
	--><?php /*} */?> 
    <?php ActiveForm::end(); ?> 
</div>
