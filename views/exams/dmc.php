<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title'); 
$this->title = 'Exam\'s DMC';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile( Yii::getAlias('@web/css/exam/dmc.css'));
$this->registerJsFile(Yii::getAlias('@web').'/js/exam/html2pdf.bundle.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/exam/dmc.js',['depends' => [yii\web\JqueryAsset::className()]]);
?> 
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade dmc_wrapper fee-gen">
        <div class="exam-form filters_head"> 
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
                <input type="hidden" id="subject-url" value="<?=Url::to(['/exams/cgs-dmc'])?>">
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
        <?php ActiveForm::end(); ?> 
        </div>
        <div  id="subject-details">
            <div id="subject-inner"></div>
        </div> 
    </div>
</div>