<?php
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\Html;

$class_array = \yii\helpers\ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'class_id','title');

return [
   /* [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    /*   [
       'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'section_id',
   ],
  /* [      'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'fk_branch_id',
   ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'vAlign'=>'middle',
        'format'=>'raw',
        'value'=>function($model, $key, $index){
            //return Html::a($model->title,['/student/get-students','id'=>$key,'cid'=>$_GET['cid'],'gid'=>$_GET['gid']]);
            if(empty($_GET['gid'])){
            return Html::a($model->title,['/analysis','id'=>$key,'cid'=>$_GET['cid']]);

            }else{
            return Html::a($model->title,['/analysis','id'=>$key,'gid'=>$_GET['gid'],'cid'=>$_GET['cid']]);

            }
        }
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
        'template'=>'{view} {update} {delete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' =>[
            'view'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-eye-open"  title="View Section"></span>', ['/section/view','id'=>$key],
                    ['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip']);
            },
            'update'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-pencil"  title="Update Section"></span>', ['/section/update','id'=>$key,'gid'=>(isset($_GET['gid']))?$_GET['gid']:'','cid'=>$_GET['cid']],
                    ['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
            },
            'delete'=>function($url, $model, $key){
                $students = \app\models\StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'section_id'=>$key,'is_active'=> 1])->count();
                if($students == 0){
                    return Html::a('<span class="glyphicon glyphicon-trash" title="Delete Section"></span>', ['/section/delete','id'=>$key],
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
        /*'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'
        ],*/
    ],

];   