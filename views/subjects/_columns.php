<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$classArray = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(),'class_id','title');
$groupArray = ArrayHelper::map(\app\models\RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(),'group_id','title');
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
        'filter'=>'',
        'vAlign'=>'middle',
        'format'=>'raw',
        'value' => function($model,$key) {
            if ($model->is_division == 1) {
                return Html::a(ucfirst($model->title), ['/subject-division', 'id' => $model->id],['title'=>'View '.$model->title.' Subject(s)']);
            } else {
                return ucfirst($model->title);
            }
        }

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_class_id',
        'vAlign'=>'middle',
        'filter'=>Html::activeDropDownList ($searchModel,'fk_class_id',$classArray,['prompt' => 'Select '.Yii::t('app','Class'),'class' => 'form-control']),
        'value' => function($model,$key){
            return ucfirst($model->fkClass->title);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_group_id',
        //'filter'=>Html::activeDropDownList ($searchModel,'fk_group_id',$groupArray,['prompt' => 'Select group','class' => 'form-control']),
        'filter'=>'',
        'vAlign'=>'middle',
        'value' => function($model,$key){
            if($model->fk_group_id){
                return ucfirst($model->fkGroup->title);
            }else{
                return 'N/A';
            }
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
        'vAlign'=>'middle',
        'filter'=>''
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'is_division',
        'label'=>'Sub Division',
        'filter'=>'',
        'vAlign'=>'middle',
        'value' => function($model,$key){
           if($model->is_division==0){
               return 'No';
           }else{
               return 'Yes';
           }
        },/*
        'filter'=>[1=>'Yes',0=>'No']*/
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_date',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{addSubDevision} {update} {delete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' =>[
            'addSubDevision'=>function($url, $model, $key){
                return Html::a('<span class="glyphicon glyphicon-plus-sign toltip" data-placement="bottom" width="20"  title="Add '.$model->title.' Subjects"></span>', ['/subject-division','id'=>$key]);
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