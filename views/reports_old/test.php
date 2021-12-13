<?php 
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */ 

$this->title = 'Section Analysis';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title; 

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title'); 
?>  

<div class="free-generator content_col exam-form grey-form"> 
    <h1 class="p_title">Section Analysis</h1>
    <div class="form-center shade fee-gen">
         <?php $form = ActiveForm::begin(); ?> 
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...']); ?>
            </div>
            <div class="col-sm-4"> 
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-4">
                <input type="hidden" id="subject-url" value="<?=Url::to(['/analysis/get-section-analysis'])?>">
                <?php
                
                // Dependent Dropdown
                echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
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
        <?php ActiveForm::end(); ?>
    </div>  
    <div id="subject-inner"></div>
</div>