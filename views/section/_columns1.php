<?php
use yii\helpers\Url;
use kartik\select2\Select2;

$class_array = \yii\helpers\ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>1])->all(),'class_id','title');

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
     /*  [
       'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'section_id',
   ],*/
   [      'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'fk_group_id',
   ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
         'value'=>function($data){
            return $data->class->title;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'class_id',
        'value'=>function($data){
            return $data->class->title;
        },
        'filter'=> (yii::$app->request->get('id'))?'':\yii\helpers\Html::dropDownList(
            'RefSectionSearch[class_id]',
            yii::$app->request->get('RefSectionSearch')['class_id'],
            $class_array,
            [
                'prompt'=>'select Class','class'=>'form-control'
            ]),

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
            'data-confirm-message'=>'Are you sure want to delete this item'
        ],
    ],

];   