<?php

use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */ 

$this->title = 'Shuffle Students';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title; 

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title'); 
?>
<?=Alert::widget()?> 
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title">Shuffle Students</h1> 
    <div class="form-center shade fee-gen">
        <div class="exam-form filters_head"> 
        <?php $form = ActiveForm::begin(['id'=>'promote-student-list-form']); ?>
        <div class="row">
           <div class="col-sm-3"> 
           </div>
           <div class="col-sm-9">
            <div class="col-sm-4 fh_item">
                <input type="hidden" id="subject-url-class" value="<?=Url::to(['/student/shuffle-class'])?>">

                <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...','class'=>'class-shuffle form-control']); ?>
            </div>
          
        
           
            <div class="col-sm-4 fh_item">
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id','class'=>'group-sh form-control'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'loadingText' => 'Loading Groups ...',
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?> 
            </div>
            <div class="col-sm-4 fh_item">
                <input type="hidden" id="subject-urls" value="<?=Url::to(['/student/branch-student-list-shuffle'])?>">
                <?php
                
                // Dependent Dropdown
                echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'section-id-shuffle'],
                    'pluginOptions'=>[
                        'depends'=>[
                            'group-id','class-id'
    
                        ],
                        'loadingText' => 'Loading Sections ...',
                        'prompt' => 'Select section',
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