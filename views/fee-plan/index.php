<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeePlanType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Plan Types';
//$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
$pdfHeader = [
    'L' => [
        'content' => 'PDF Generated',
    ],
    'R' => [
        'content' => ' Plan  : ' . date('D, d-M-Y'),
    ],
];
$pdfFooter = [
    'L' => [
        'content' => 'PDF Generated',
    ]
];
?>
<div class="filter_wrap content_col tabs grey-form mcm_s ">  
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen pad15 remov_head hideFooter">
        <div id="ajaxCrudDatatable">
            <?=
            GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'pjax' => true,
                'columns' => require(__DIR__ . '/_columns.php'),
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i> Add  Fee Plan Type', ['create'], ['role' => 'modal-remote', 'title' => 'Add new Fee Group', 'class' => 'btn btn-default'])
                    ],
                    '{export}',
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'showPageSummary' => false, // at the bottom of the table
                'panel' => [
                    'type' => 'primary',
                    'footer' => false,
                    //'heading' => '<i class="glyphicon glyphicon-list"></i> Fee Plan Types listing',
                    'before' => '<em>* manage fee plan types, you can add new, update or   delete   plan type</em>',
                /* 'after'=>BulkButtonWidget::widget([
                  'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                  ["bulk-delete"] ,
                  [
                  "class"=>"btn btn-danger btn-xs",
                  'role'=>'modal-remote-bulk',
                  'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                  'data-request-method'=>'post',
                  'data-confirm-title'=>'Are you sure?',
                  'data-confirm-message'=>'Are you sure want to delete this item'
                  ]),
                  ]).
                  '<div class="clearfix"></div>', */
                ],
                'exportConfig' => [
                    GridView::PDF => [
                        'filename' => 'plans',
                        'label' => 'Save as PDF',
                        'showHeader' => false,
                        'showPageSummary' => false,
                        'showFooter' => false,
                        'showCaption' => false,
                        'options' => [
                            'title' => 'Plan',
                            'subject' => 'Plan PDF',
                            'keywords' => 'pdf'
                        ],
                        'methods' => [
                            'SetHeader' => [
                                ['odd' => $pdfHeader, 'even' => $pdfHeader]
                            ],
                            'SetFooter' => [
                                ['odd' => $pdfFooter, 'even' => $pdfFooter]
                            ],
                        ],
                        'contentBefore'=>'',
            'contentAfter'=>''
                    ],
                ],
            ])
            ?>
        </div>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
