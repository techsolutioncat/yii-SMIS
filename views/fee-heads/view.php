<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeHeads */
?>
<div class="fee-heads-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'options' => array('class' => 'table table-striped table-hover table-bordered detail-view'),
        'attributes' => [
           // 'id',
            //'fk_branch_id',
            'title',
            'description',
            [
                'attribute'=>'discount_head_status',
                'value'=>function($model){
                    if($model->discount_head_status ==1){
                        return ucfirst('Active');
                    }else{
                        return 'Inactive';
                    }
                }
            ],
            [
                'attribute'=>'fk_fee_method_id',
                'value'=>function($model){
                    if($model->fk_fee_method_id){
                        return ucfirst($model->fkFeeMethod->title);
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'extra_head',
                'value'=>function($model){
                    if($model->extra_head ==1){
                        return ucfirst('Yes');
                    }else{
                        return 'No';
                    }
                }
            ],


            'created_date:datetime',
            'updated_date',
        ],
    ]) ?>

</div>
