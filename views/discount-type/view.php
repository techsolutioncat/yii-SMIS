<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeDiscountTypes */
?>
<div class="fee-discount-types-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'options' => array('class' => 'table table-striped table-hover table-bordered detail-view'),
        'attributes' => [
            //'id',
            //'fk_branch_id',
            'title',
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
                'label'=>'Status',
                'attribute'=>'is_active',
                'value'=>function ($data){

                    if($data->is_active==1){
                        return 'Active';
                    }else{
                        return 'Inactive';
                    }
                }
            ],
        ],
    ]) ?>

</div>
