<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>


<?php
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
                //'attribute'=>'fk_class_id',
                'label'=>Yii::t('app','Class'),
                'format'=>'raw',
                'value'=>function($data){
                   if($data){
                   return '<a href="javascript:void(0)" class="classFeeGroup" data-id='.$data->class_id.' data-url='.Url::to(['/fee-group']).'>'.$data->title.'</a>';
                   ?>
                   
               <?php  }else{
                    return "Not Found";
                }
            }
            ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_class_id',
    ],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_branch_id',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fk_fee_head_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_date',
    ],*/
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'is_active',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fk_group_id',
    // ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
    ],*/
    /*[
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
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],*/


];   



?>

    
   