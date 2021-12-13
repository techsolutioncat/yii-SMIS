<?php
use yii\helpers\Url;

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
        'attribute'=>'fk_student_id',
        'value'=>function($data){
            if($data->fk_student_id){
                //return Yii::$app->common->getName($data->fk_student_id);
                $student = Yii::$app->common->getStudent($data->fk_student_id);
                if($student){
                    return Yii::$app->common->getName($student->user_id);
                }else{
                    return 'N/A';
                }
            }else{
                return "N/A";
            }        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_hostel_id',
        'value'=>function($data){
            if($data->fk_hostel_id){
            return $data->fkHostel->Name;
        }else{
            return "N/A";
        }
        }
    ],
     
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_floor_id',
        'value'=>function($data){
            if($data->fk_floor_id){
            return $data->fkFloor->title;
        }else{
            return "N/A";
        }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_room_id',
        'value'=>function($data){
            if($data->fk_room_id){
                return $data->fkRoom->title;
            }else{
                return "N/A";
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_bed_id',
        'value'=>function($data){
            if($data->fk_bed_id){
                return $data->fkBed->title;
            }else{
                return "N/A";
            }
        }
    ], 
       
    /**
 * [
 *         'class'=>'\kartik\grid\DataColumn',
 *         'attribute'=>'is_booked',
 *         'value'=>function($data){
 *             if($data->is_booked == 1){
 *                 return 'Yes';
 *             }else{
 *                 return 'No';
 *             }
 *             
 *         }
 *     ],
 */
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fk_student_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'create_date',
    // ],
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