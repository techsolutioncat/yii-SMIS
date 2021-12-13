<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Groups';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>

<div class="fee-group-index kv-panel-afterd hideFooter">
    <div id="ajaxCrudDatatable">
<?php
\yii\widgets\Pjax::begin([
    'id' => 'pjax-container',
//    'timeout' => false,
//    'enablePushState' => false,
]);
?>
        <?=
        GridView::widget([
            'id' => 'crud-datatable2',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax' => true,
            'summary' => '',
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add Fee Group', ['create', 'id' => $id], ['role' => 'modal-remote', 'title' => 'Add new Fee Group', 'class' => 'btn btn-default'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'showPageSummary' => false, // at the bottom of the table
            'resizableColumns' => true,
            'panel' => [
                'type' => 'primary',
                'footer' => false,
                'heading' => '<i class="fa fa-sitemap"></i> '.ucfirst($classModel->title).' fee structure   ',
                'before' => '<em>*manage  <b>'.$classModel->title.'</b> fee structures, you can add new, update or   delete fee group.</em>',
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
                  ]). */
                '<div class="clearfix"></div>',
            ],
//            'itemLabelSingle' => 'group',
//            'itemLabelPlural' => 'groups',
        ])
        ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>


<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
