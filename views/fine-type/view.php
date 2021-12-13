<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FineType */
?>
<div class="fine-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
            //'fk_branch_id',
            'description',
            [
                'attribute'=>'created_date',
                'value'=>function ($data){
                    if($data->created_date){
                        return date('d-m-Y H:i:s',strtotime($data->created_date));
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'updated_date',
                'value'=>function ($data){
                    if($data->updated_date){
                        return date('d-m-Y H:i:s',strtotime($data->updated_date));
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'updated_by',
                'value'=>function($data){
                    return $data->updatedBy->first_name.' '.$data->updatedBy->last_name;
                }
            ],
            'status',
        ],
    ]) ?>

</div>
