<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
/* @var $form yii\widgets\ActiveForm */

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');

?>
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
				'prompt' => 'Select '.Yii::t('app','Group').'...',
				'url' => Url::to(['/site/get-group'])
			]
		]);
		?>
    </div>
    <div class="col-sm-4 fh_item">
        <input type="hidden" id="subject-url" value="<?=Url::to(['/exams/get-exams'])?>">
		<?php
		// Dependent Dropdown
		echo $form->field($model, 'fk_section_id')->widget(DepDrop::classname(), [
			'options' => ['id'=>'section-id'],
			'pluginOptions'=>[
				'depends'=>[
					'group-id','class-id'
				],
				'prompt' => 'Select '.Yii::t('app','section').'...',
				'url' => Url::to(['/site/get-section'])
			]
		]);
		?> 
    </div>
   </div> 
</div>
<?php /*if (!Yii::$app->request->isAjax){ */?><!--
<div class="form-group">
    <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) */?>
</div>
--><?php /*} */?> 
<?php ActiveForm::end();

Modal::begin([
    'header'=>'<h4>Award List Details</h4><div id="message"></div>',
    'id'=>'modal-award-list',
    'options'=>[
        'data-keyboard'=>false,
        'data-backdrop'=>"static"
    ],
    'size'=>'modal-lg',
    'footer' =>'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>',

]);?>

<?php

Modal::end();?>
