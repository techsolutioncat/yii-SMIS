<?php 

use yii\helpers\Url;
use app\models\User;
use app\models\StudentAttendance;
use app\models\StudentInfo;
use app\models\RefClass;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
?>
<?php
$this->registerJsFile(Yii::getAlias('@web').'/js/studentCalender.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>

<?php $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['status'=>'active','fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title'); ?>
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title">Student Attendance</h1>
    <div class="shade fee-gen relative">
        <div class="exam-form filters_head"> 
        <?php $form = ActiveForm::begin(); ?> 
        <div class="row">
           <div class="col-sm-5"> 
           </div>
           <div class="col-sm-7">
            <div class="col-sm-4 fh_item">
            	<?= $form->field($model, 'fk_class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...']); ?>
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
            	<input type="hidden" id="subject-url" value="<?=Url::to(['/student/get-stu'])?>">
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
        <?php ActiveForm::end(); ?> 
        </div>
        <div  id="subject-details">
            <div id="subject-inner"></div>
        </div> 
    </div>
</div>
