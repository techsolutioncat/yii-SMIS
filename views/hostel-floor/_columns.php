<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Hostel;

    $hostel= ArrayHelper::map(\app\models\Hostel::find()->all(),'id','Name');
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
        'vAlign'=>'middle',
        'format'=>'raw',
        'value'=>function($model, $key, $index){
            return Html::a($model->title,['/hostel-room','id'=>$key]);
        }
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
       // 'attribute'=>'fk_hostel_info_id',
        'label'=>'Hostel',
        //'filter'=>Html::activeDropDownList ($searchModel,'fk_hostel_info_id',$hostel,['prompt' => 'Select Hostel','class' => 'form-control']),
        'value'=>function($data){
            if($data->fk_hostel_info_id) {
                return $data->fkHostelInfo->Name;
            }else{
                return 'N/A';
            }
        }

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>' {update} {delete} <br/> {hostelroom} ',
        'buttons' =>[
            'hostelroom'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-plus toltip" data-placement="bottom" width="20"  title="Add '.$model->title.' Room"></span>', ['/hostel-room','id'=>$key]);
            },
        ],
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