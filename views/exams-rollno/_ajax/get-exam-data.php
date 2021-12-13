<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

$examtype_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'type');
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="exam-type-index">
    <div class="first">
        <div class="col-md-6">
            <?= GridView::widget([
                'dataProvider' => $dataprovider,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'fk_exam_type',
                        'label'=>'Exam',
                        'format'=>'raw',
                        'value'=>function($data){

                            $link= Html::a($data->fkExamType->type,'javascript:void(0);',[
                                'id'=>'get-exam-subjects',
                                'data-class_id'     =>$data->fk_class_id,
                                'data-group_id'     =>$data->fk_group_id,
                                'data-section_id'   =>$data->fk_section_id,
                                'data-exam_type_id' =>$data->fk_exam_type,
                                'data-url' =>url::to(['/exams/get-exams-subjects']),
                            ]);
                            return $link;
                        }
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <div id="exam-inner"></div>
        </div>
    </div> 
    <div class="col-sm-12 second" id="award-list">
    </div> 
</div>

