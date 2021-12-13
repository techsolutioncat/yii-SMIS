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
<!--subjects of calss and section-->
        <div class="tab-pane" id="class-subjects">
        	<div class="col-md-12">
            <?php Pjax::begin(['id' => 'pjax-container']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProviderSubj,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        //'attribute'=>'title',
                        'filter'=>null,
                        'label'     =>'Subject',
                        'value'     => function($data){
                            return $data->title;
                        }
                    ],
                    [
                        'filter'=>null,
                        'label'     =>'Sub subject',
                        'format'=>'raw',
                        'value'     => function($data){
                            $sub_division='';
                            if($data->is_division){
                                $subdiv= \app\models\SubjectDivision::find()->where(['fk_subject_id'=>$data->id])->all();
                                foreach ($subdiv as $item) {
                                    $sub_division .= $item->title.'<br/>';
                                }
                                return $sub_division;
                            }else{
                                return 'N/A';
                            }
                        }
                    ],
                    /*[
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{view}",
                        'buttons' => [

                            'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                            },
                        ],
                    ],*/

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            
        </div>
        </div>