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
        'attribute'=>'title',
    ],
   
  /*  [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_date',
    ],
    */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'is_active',
        'value'=>function ($data){
            if($data->is_active==1){
                return 'Active';
            }else{
                return 'Inactive';
            }
        }
    ],
             [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => array('class' => 'gridv-group-btn'),
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