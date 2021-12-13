<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Exam */


$this->title = 'Exams List';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;


$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');

?>
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-midd action-head">
    	<a class="btn green-btn" href="<?=Yii::getAlias('@web')?>/exams/create-exam">+ Add Exam</a>
    </div>
    <div class="form-midd shade fee-gen">
        <div class="exam-form filters_head"> 
        <?php $form = ActiveForm::begin(); ?> 
            <div class="col-sm-3 fh_item">
					<?= $form->field($model, 'fk_class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select '.Yii::t('app','Class').'...']); ?>
                </div>
            <div class="col-sm-3 fh_item">
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
            <div class="col-sm-3 fh_item">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'fk_section_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'exam-section-id'],
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
            <div class="col-sm-3 exam-dropdown-list fh_item">
                <input type="hidden" id="exam-url" value="<?=Url::to(['/exams/get-exams-list'])?>">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'fk_exam_type')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'exam-type-id'],
                    'pluginOptions'=>[
                        'depends'=>[
                            'exam-section-id',
                            'group-id',
                            'class-id'
                        ],
                        'prompt' => 'Select '.Yii::t('app','Exam Type').'...',
                        'url' => Url::to(['/site/get-exams-list'])
                    ]
                ]);
                ?>
            </div> 
        <?php ActiveForm::end(); ?>
        </div>
        <div  id="subject-details">
            <div id="exams-inner"></div>
        </div> 
    </div>
</div> 