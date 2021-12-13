<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Reports:: Academics';
$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');
$exam_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()/*,'status'=>'active'*/])->all(), 'id', 'type');
?>




<div class="filter_wrap content_col tabs grey-form">
    <h1 class="p_title">Reports Academics</h1>
    <div id="reports-acadamics" class="reports_wrap form-middle">
        <!--Reports Graphs-->
        <div class="rep_graphs" id="rep_graphs">
            <img src="<?= Url::to('@web/img/graphs.png') ?>" alt="MIS">
        </div>  
        <div class="shade fee-gen none_c">  
            <!--<div class="bhoechie-tab-container">
                <div class="bhoechie-tab-menu">
                	<div class="list-group tabs_green"> 
                        <a class="active" href="#reports-classwise-result-sheet" data-toggle="tab">Class Wise Result Sheet</a>
                    </div>
                </div>
                <div class="tab-content clearfix ">
                <div class="tab-pane active" id="reports-classwise-result-sheet">

                </div>
            </div>
            </div>-->
     </div>
	</div>
</div>



<!--sfds-->
