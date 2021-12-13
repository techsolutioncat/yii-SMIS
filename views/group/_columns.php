<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\RefSection;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'group_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_branch_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'fk_class_id',
        'label'=>'Class',
        'value' => function($data){
            return ucfirst($data->fkClass->title);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'filter'=>''
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{view} {update} {delete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' =>[
            'view'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-eye-open"  title="View Section"></span>', ['/group/view','id'=>$key],
                    ['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip']);
            },
            'update'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-pencil"  title="Update Section"></span>', ['/group/update','id'=>$key],
                    ['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
            },
            'delete'=>function($url, $model, $key){
                $sections = RefSection::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_group_id'=>$key,'status'=>'active'])->count();
                if($sections == 0){
                    return Html::a('<span class="glyphicon glyphicon-trash" title="Delete Section"></span>', ['/group/delete','id'=>$key],
                        ['role'=>'modal-remote',
                            'title'=>'Delete',
                            'data-confirm'=>false,
                            'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>'Are you sure?',
                            'data-confirm-message'=>'Are you sure want to delete this item'
                        ]);
                }else{
                    return null;
                }

            },
        ],

    ],

];   