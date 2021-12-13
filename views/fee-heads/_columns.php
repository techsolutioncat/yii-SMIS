<?php
use yii\helpers\Url;

return [
   /* [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

     [
        'label'=>'Title',
        'value'=>'title',
        
     ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_branch_id',
    ],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],*/
    
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_date',
    ],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_date',
    ],*/
    [
                //'attribute'=>'fk_fee_method_id',
               'label'=>'Fee Mode',
                'value'=>function($data){
                    if($data->fk_fee_method_id){
                        return ucfirst($data->fkFeeMethod->title);
                    }else{
                        return 'N/A';
                    }
                }
            ],
    [
        'attribute'=>'extra_head',
        'label'=>'Extra Head',
        'value'=>function($data){
            if($data->extra_head ==1){
                return ucfirst('Yes');
            }else{
                return 'No';
            }
        }
    ],
    [
        'attribute'=>'one_time_only',
        'value'=>function($model){
            if($model->one_time_only ==1){
                return ucfirst('Yes');
            }else{
                return 'No';
            }
        }
    ],
[
        'label'=>'Description',
        'value'=>'description',
        
     ],
    /*[
        'attribute'=>'one_time_only',
        'label'=>'One Time Payment',
        'value'=>function($data){
            if($data->one_time_only ==1){
                return ucfirst('Yes');
            }else{
                return 'No';
            }
        }
    ],*/
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'discount_head_status',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'contentOptions' => array('class' => 'gridv-group-btn'),
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