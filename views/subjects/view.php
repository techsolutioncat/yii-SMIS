<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Subjects */
?>
<div class="subjects-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function($data){
                    if($data->is_division == 1) {
                        return Html::a(ucfirst($data->title),['/subject-division','id'=>$data->id],['title'=>'View '.$data->title.' Subject(s)']);
                    }else{
                        return ucfirst($data->title);
                    }
                }
            ],
            'code',
            [
                'attribute'=>'fk_class_id',
                'value'=>function($data){
                    return ucfirst($data->fkClass->title);
                }
            ],
            [
                'attribute'=>'fk_group_id',
                'value'=>function($data){
                    if($data->fk_group_id){
                        return ucfirst($data->fkGroup->title);
                    }else{
                        return 'N/A';
                    }
                }
            ],

            [
                'attribute'=>'is_division',
                'value'=>function($data){
                    if($data->is_division == 1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                }
            ],
            'status',
            'created_date',
        ],
    ]) ?>

</div>
