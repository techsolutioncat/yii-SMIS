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
    /*[
    /*'css'=>'\kartik\grid\DataColumn',
    'attribute'=>'class_id',
],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_branch_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'vAlign'=>'middle',
        'format'=>'raw',
        'value'=>function($model, $key, $index){
            $class_groups= \app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$key,'status'=>'active'])->one();
            return Html::a($model->title,['/section','cid'=>$key,'gid'=>$class_groups['group_id']]);

            /*$class_groups= \app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$key,'status'=>'active'])->all();
            $classGroup ='';
            $count=1;
            if($class_groups){
                foreach ($class_groups as $group){
                    $classGroup.= Html::a(ucfirst($group->title),['/section','cid'=>$key,'gid'=>$group->group_id]);
                    if(count($class_groups)>1){
                        if(count($class_groups) != $count){
                            $classGroup.='-';
                        }
                    }
                    $count++;
                }
                return $classGroup;
            }else{
                return 'N/A';
            }*/
        }
    ],
    [
        'label'=>Yii::t('app','Group'),
        'format'=>'raw',
        'vAlign'=>'middle',
        'value'=>function($model, $key, $index){
            $class_groups= \app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$key,'status'=>'active'])->all();
            $classGroup ='';
            $count=1;
            if($class_groups){
                /*concatinate  multiple grops title of particular class*/
                foreach ($class_groups as $group){
                    $classGroup.= Html::a(ucfirst($group->title),['site/group-section','cid'=>$model->class_id,'gid'=>$group->group_id]);
                    if(count($class_groups)>1){
                        if(count($class_groups) != $count){
                            $classGroup.='-';
                        }
                    }
                    $count++;
                }
                return $classGroup;
            }else{
                return 'N/A';
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_session_id',
        'vAlign'=>'middle',
        'value'    =>function($data){
            if($data->fk_session_id){
                $session =  \app\models\RefSession::findOne($data->fk_session_id);
                if($session){
                    return ucfirst($session->title);
                }else{
                    return 'N/A';
                }
            }else{
                return 'N/A';
            }
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{view} {update} {delete} <br/> {createGroup} ',
        'urlCreator' => function($action, $model, $key, $index) {
            if($action=='view'){
                return Url::to([$action,'id'=>$key]);
            }else if($action=='update'){
                return Url::to([$action,'id'=>$key]);
            }else{
                return Url::to([$action,'id'=>$key]);
            }
        },
        'buttons' =>[
            'view'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-eye-open"  title="View Section"></span>', ['/class/view','id'=>$key],
                    ['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip']);
            },
            'update'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-pencil"  title="Update Section"></span>', ['/class/update','id'=>$key],
                    ['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
            },
            'delete'=>function($url, $model, $key){
                $group = \app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$key,'status'=>'active'])->count();
                $count= 0;
                if($group == 0){
                    $sections = \app\models\RefSection::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_group_id'=>null,'class_id'=>$key,'status'=>'active'])->count();
                    if($sections > 0){
                        $count++;
                    }
                }else{
                    $count++;
                }
                if($count == 0){
                    return Html::a('<span class="glyphicon glyphicon-trash" title="Delete Section"></span>', ['/class/delete','id'=>$key],
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
            'createGroup'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-plus toltip" data-placement="bottom" width="20"  title="Add Group"></span>', ['/group','id'=>$key]);
                

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