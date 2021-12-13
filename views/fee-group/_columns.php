<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>


<?php

return [
    /*   [
      'class' => 'kartik\grid\CheckboxColumn',
      'width' => '20px',
      ], */
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    /* [
      'attribute'=>'fk_class_id',
      'format'=>'raw',
      'value'=>function($data, $key){
      //return ucfirst($data->fkClass->title);
      //   return Html::a($data->fkClass->title);
      return Html::a($data->fkClass->title, ['fee-group/class-details', 'id'=>$data->id]);
      }
      ], */
    [
        //'attribute'=>'fk_group_id',
        'label' => Yii::t('app', 'Group'),
        'filter' => '',
        'value' => function($data) {
            if ($data->fk_group_id) {
                return ucfirst($data->fkGroup->title);
            } else {
                return 'N/A';
            }
        }
    ],
    [
        //'attribute'=>'fk_fee_head_id',
        'label' => 'Fee Head',
        'filter' => '',
        'value' => function($data) {
            return ucfirst($data->fkFeeHead->title);
        }
    ],
    /* [
      'attribute'=>'updated_by',
      'value'=>function($data){
      if($data->updated_by){

      return ucfirst($data->updatedBy->first_name.' '.$data->updatedBy->last_name);

      }else{
      return "N/A";
      }
      }
      ], */
    // 'amount',
    [
        //'attribute'=>'fk_fee_head_id',
        'label' => 'Amount',
        'filter' => '',
        'value' => function($data) {
            return Yii::$app->common->getNumberFormat($data->amount);
        },
     'contentOptions' => ['class' => 'text-centerd'],
    ],
    //  'is_active',
    [
        //'attribute'=>'fk_fee_head_id',
        'label' => 'Status',
        'filter' => '',
        'value' => function($data) {
            return ucfirst($data->is_active);
        }
    ],
    /* [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'fk_class_id',
      ], */
    /* [
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
      ], */
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
    /* [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'amount',
      ], */
    [
        'class' => 'kartik\grid\ActionColumn',
//        'template' => '{view}{update}{remove}',
        'dropdown' => false,
        'vAlign' => 'middle',
        'contentOptions' => array('class' => 'gridv-group-btn'),
        'urlCreator' => function($action, $model, $key, $index) {
    return Url::to([$action, 'id' => $key]);
},
        'buttons' => [
            'remove' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['remove', 'id' => $model->id], [
                            'role' => 'modal-remote',
//                            'data-method' => 'post',
                            'title' => 'Add new Fee Group',
                            'class' => '']
                );

//                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['remove', 'id'=>$model->id], [
//                                 'data-method' => 'post',
//                                 'data-pjax' => '1', 
//                                'role' => 'modal-remote',
//                                'title' => 'Update', 
//                                'data-toggle' => 'tooltip',
//                                
//                            ]);
            },
//                    'delete' => function ($url) {
//                        return Html::a(Yii::t('yii', 'Delete'), '#', [
//                            'title' => Yii::t('yii', 'Delete'),
//                            'aria-label' => Yii::t('yii', 'Delete'),
//                            'data-pjax' => 'pjax-container',//pjax
//                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                            'data-method' => 'post',
//                        ]);
//                    },
//                    'delete' => function ($url) {
//                        return Html::a(Yii::t('yii', 'Delete'), '#', [
//                            'onclick' => "
//                                if (confirm('ok?')) {
//                                    $.ajax('$url', {
//                                        type: 'POST'
//                                    }).done(function(data) {
//                                    $.pjax.reload({container:'#crud-datatable2-pjax'});
//                                    });
//                                }
//                                return false;
//                            ",
//                        ]);
//                    },
                ],
                'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
                'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
                'deleteOptions' => [
                    'role' => 'modal-remote', 'title' => 'Delete',
                    'data-confirm' => false,
                    'data-method' => false, // for overide yii data api
                    'data-request-method' => 'post',
                    'data-toggle' => 'tooltip',
                    'data-confirm-title' => 'Are you sure?',
                    'data-confirm-message' => 'Are you sure want to delete this item',
//                            'class' => 'pjax-delete-link',
//                             'pjax-container' => 'pjax-container',
//                            'class'=>'deleteMe',
                    'data-pjax' => '1',
                    'data' => [
                        'success' => new \yii\web\JsExpression(
                                "function(data) {    alert('asdfasfd');  }"
                        ),
                    ],
                    'ajaxSettings' => [
                        'success' => new \yii\web\JsExpression(
                                "function(data) {if (data.success) {  alert('asdfasfd'); }}"),
                    ],
                ],
            ],
        ];
        ?>


