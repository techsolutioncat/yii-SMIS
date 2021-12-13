<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeParticulars */
?>
<div class="fee-particulars-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            [
                'attribute'=>'fk_stu_id',
                'value'=>function ($data){
                    if($data->fk_stu_id){
                        $stu_name= ucfirst($data->fkStu->user->first_name);
                        if($data->fkStu->user->middle_name){
                            $stu_name .=  ' '.ucfirst($data->fkStu->user->middle_name);
                        }
                        if($data->fkStu->user->last_name){
                            $stu_name .=  ' '.ucfirst($data->fkStu->user->last_name);
                        }

                        return $stu_name;

                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'fk_fee_head_id',
                'value'=>function ($data){
                    if($data->fk_fee_head_id){
                        return $data->fkFeeHead->title;
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'fk_fee_plan_type',
                'value'=>function ($data){
                    if($data->fk_fee_plan_type){
                        return $data->fkFeePlanType->title;
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute'=>'is_active',
                'value'=>function ($data){
                    if($data->is_paid){
                        return ucfirst($data->is_paid);
                    }else{
                        return 'N/A';
                    }
                }
            ],
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
        ],
    ]) ?>

</div>
