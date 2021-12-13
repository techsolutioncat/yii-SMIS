<?php
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */

$this->title = 'Generate Fee Challan';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
/*if ch id is coming form url than it will hid generate challan.*/

echo Yii::$app->feeHelper->getNextMonthChallan();

if(Yii::$app->request->get('ch_id')) {
    $this->registerJs("$('#generate-challan-view')[0].click();",\Yii\web\View::POS_LOAD);
} 
$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title'); 
?>
<?php
if(Yii::$app->request->get('ch_id')) {
    echo  Html::a('generate fee challan.',['student/generate-student-partial-fee-challan', 'challan_id' => Yii::$app->request->get('ch_id'),'stu_id' => Yii::$app->request->get('id')],['style'=>'visibility:hidden;','id'=>'generate-challan-view']);
}
?>
<?= Alert::widget()?>
<div class="exam-form free-generator content_col grey-form"> 
	<h1 class="p_title">Fee Generator</h1>
    <?php $form = ActiveForm::begin(['id'=>'gen-fee-challan']); ?>
    	<div class="form-center shade fee-gen"> 
        <div class="row">
            <div class="col-sm-4 col-md-6 col-lg-4 rg_item">
                <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select '.Yii::t('app','Class').'...']); ?>
            </div>
            <div class="col-sm-4 col-md-6 col-lg-4 rg_item">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select '.Yii::t('app','Group').'...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?>

                 <input type="hidden" name="" id="passClassUrl" data-url="<?=Url::to(['/fee/generate-challan-std-list-class'])?>">
    
            </div>
            <div class="col-sm-4 col-md-6 col-lg-4 rg_item">
                <input type="hidden" id="subject-url" value="<?=Url::to(['/fee/generate-challan-std-list'])?>">
                <?php
                
                // Dependent Dropdown
                echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
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
    <?php ActiveForm::end(); ?>
        <div class="row"> 
            <div id="subject-inner" class="col-md-6 table-bord"> 
            	<?php
		   $this->registerJS("$('.cscroll').mCustomScrollbar({theme:'minimal-dark'});", \yii\web\View::POS_LOAD); 
		  ?>
            </div>
            <div id="challan-form-inner"  class="col-md-6 fee-res-right table-bord">
            </div>
    
        </div>
</div>