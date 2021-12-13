<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Route;


$route= ArrayHelper::map(\app\models\Route::find()->all(),'id','title');
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
        'attribute'=>'title',

    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'fk_route_id',
        'label'=>'Route',
        'value'=>function($data){
            return $data->fkRoute->title;
        }
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_route_id',
        'filter'=>Html::activeDropDownList ($searchModel,'fk_route_id',$route,['prompt' => 'Select Route','class' => 'form-control']),
        'value'=>function($data){
            return $data->fkRoute->title;
        }
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fare',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{update}{delete}',
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
