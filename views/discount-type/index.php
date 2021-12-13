<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeDiscountTypes */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Discount Types';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<div class="fee-heads-index form-center shade fee-gen pad15 hideFooter">
    <div id="ajaxCrudDatatable">
        <?=
        GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add  Fee Discount Type', ['create'], ['role' => 'modal-remote', 'title' => 'Add new Fee Group', 'class' => 'btn btn-default'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'summary' => '',
            'showPageSummary' => false, // at the bottom of the table
            'panel' => [
                  'footer' => false,
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Fee Discount Types listing',
                'before' => '<em>* manage fee discount types, you can add new, update or   delete   discount type.</em>',
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
            ]
        ])
        ?>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
