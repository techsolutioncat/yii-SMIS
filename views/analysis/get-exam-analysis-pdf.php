<?php 

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use app\models\StudentParentsInfo;
?>
<style>
    table{
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        border: 1px solid black;
    }
    /*tbody{
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }*/
   /* thead{
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }*/
    tr{
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    th{
        vertical-align: bottom;
        border-bottom: 2px solid #CCCCCC;
        border: 1px solid black;
    }
    td{
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-bottom: 1px solid #CCCCCC;
        border: 1px solid black;
    }
</style>
<!-- education -->
        <div class="tab-pane" id="analysis-exams">
        	<div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProviderExams,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        //'attribute'=>'fk_exam_type',
                        'label'=>'Exam',
                        'format'=>'raw',
                        'value'=>function($data){

                           /* $link= Html::a($data->fkExamType->type,'javascript:void(0);',[
                                'id'=>'get-exam-subjects',
                                'data-class_id'     =>$data->fk_class_id,
                                'data-group_id'     =>$data->fk_group_id,
                                'data-section_id'   =>$data->fk_section_id,
                                'data-exam_type_id' =>$data->fk_exam_type,
                                'data-url' =>url::to(['/analysis/get-exam-analysis']),
                            ]);*/
                            return $data->fkExamType->type;
                        }
                    ],
                ],
            ]);
            ?>
            <div id="exam-inner"></div>
        </div>
        </div>
        <!-- end of education -->