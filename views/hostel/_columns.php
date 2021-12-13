<?php
use yii\helpers\Url;
use yii\helpers\Html;

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
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'Name',
         'vAlign'=>'middle',
        'format'=>'raw',
        'value'=>function($model, $key, $index){
            return Html::a($model->Name,['/hostel-floor','id'=>$key]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'address',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'contact_no',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_warden_id',
        'value'=>function($data){
            if($data->fk_warden_id) {
            //return $data->fkWarden->user->first_name;
            return Yii::$app->common->getName($data->fkWarden->user_id);
        }else{
            return 'N/A';
        }
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
        'value'=>function($data) {
            return 'Rs.' . $data->amount;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
         'template'=>' {update} {delete} {createFloor} ',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
     },
     'buttons' =>[
            'createFloor'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-plus toltip" data-placement="bottom" width="20"  title="Add '.$model->Name.'Floor"></span>', ['/hostel-floor','id'=>$key]);
            },
        ],


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