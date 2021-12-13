<?php
use yii\helpers\Url;

return [
    /*[
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_branch_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
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
        'class'=>'\kartik\grid\DataColumn',
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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_fee_plan_type',
        'value'=>function ($data){
            if($data->fk_fee_plan_type){
                return $data->fkFeePlanType->title;
            }else{
                return 'N/A';
            }
        }
    ],

    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'updated_date',
    ],*/
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'is_paid',
         'value'=>function ($data){
             if($data->is_paid){
                 return ucfirst($data->is_paid);
             }else{
                 return 'N/A';
             }
         }
     ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   