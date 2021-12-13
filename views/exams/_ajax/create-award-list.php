<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

$examtype_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'type');
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="exam-type-index">
    <?php Pjax::begin([
        'enablePushState' => false,
        'id'=>'pjax_subjects'
    ]); ?>
        <div class="col-md-6 no-padding">

            <?= GridView::widget([
                'id'=>'exam-subjects-gridview',
                'dataProvider' => $dataprovider,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'fk_subject_id',
                        'label'=>'Subjects',
                        'format'=>'raw',
                        'value'=>function($data){
                            if($data->fk_subject_division_id){
                                $subject= $data->fkSubject->title.'-'. $data->fkSubjectDivision->title;
                            }else{
                                $subject= $data->fkSubject->title;
                            }
                            $link= Html::a($subject,'javascript:void(0);',[
                                'id'=>'create-subject-awdlist',
                                'data-exam_id'     =>$data->id,
                                'data-url' =>url::to(['/exams/get-award-list']),
                            ]);
                            return $link;
                        }
                    ],
                ],
            ]);
            ?>
        </div>
    <?php Pjax::end(); ?>
</div>

