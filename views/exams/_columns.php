<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;

return [
    /*[
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_subject_id',
        'filter'=>'',
       // 'filter'=>Html::activeDropDownList ($searchModel,'fk_subject_id',$subjects,['prompt' => 'Select Subject','class' => 'form-control']),
        'value'=>function($data){
            $subject = '';
            if($data->fk_subject_id){
                $subject = $data->fkSubject->title;
            }
            if($data->fk_subject_division_id !=''){
                $subject .= ' - '. $data->getFkSubjectDivision()->one()->title;
            }
            return $subject;
        }
    ],



    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fk_exam_type',
    // ],
    [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'total_marks',
        'filter'=>''
     ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'passing_marks',
         'filter'=>''
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'do_not_create',
        'filter'=>'',
        'label'=>'Do not create',
        'value'=>function($data){
            if($data->do_not_create==1){
                return "Yes";
            }else{
                return "No";
            }
        }
    ],
     
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'start_date',
        'filter'=>'',
        'value'=>function($data){
            if($data->start_date){
                return date('d-m-Y H:i:s',strtotime($data->start_date));
            }else{
                return "N/A";
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'end_date',
        'filter'=>'',
        'value'=>function($data){
            if($data->end_date){
                return date('d-m-Y H:i:s',strtotime($data->end_date));
            }else{
                return "N/A";
            }
        }
    ],
    /*[
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{view}',
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
    ],*/

];   