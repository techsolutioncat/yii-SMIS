<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeDiscounts */
?>
<div class="fee-discounts-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            [
                'attribute'=>'fk_fee_discounts_type_id',
                'value'=>function($data){
                    if($data->fk_fee_discounts_type_id){
                        return $data->fkFeeDiscountsType->title;
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'fk_fee_particular_id',
                'value'=>function($data){
                    if($data->fk_fee_particular_id){
                        $name = ucfirst($data->fkFeeParticular->fkStu->user->first_name). ' '.ucfirst($data->fkFeeParticular->fkStu->user->last_name);
                        if($data->fkFeeParticular->fkFeePlanType->title != null){
                            $name .= '-'.$data->fkFeeParticular->fkFeePlanType->title;
                        }
                        if($data->fkFeeParticular->fkFeeHead->title != null){
                            $name .= '-'.$data->fkFeeParticular->fkFeeHead->title;
                        }
                        return $name;
                    }else{
                        return 'N/A';
                    }
                }
            ],
            'amount',
            'is_active',
            'remarks',
        ],
    ]) ?>

</div>
