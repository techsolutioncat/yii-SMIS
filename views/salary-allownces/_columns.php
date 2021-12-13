<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
      
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Group',
        'value'=>function($data){
            if($data->fk_stages_id){
            return $data->fkStages->fkPayGroups->title;
        }else{
            return "N/A";
        }
        }
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_stages_id',
        'value'=>function($data){
            if($data->fk_stages_id){
            return $data->fkStages->title;
        }else{
            return "N/A";
        }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
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