<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
 
 
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Fee Groups';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?> 
<div class="row">
<div class="col-md-4">
<div class="fee-group-index">
    <div id="ajaxCrudDatatable">
         
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/get.php'),
            'summary' => '',
           /* 'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Fee Groups','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],*/          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,     
            'showPageSummary' => false, // at the bottom of the table
           
            /*'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Fee Groups listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
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
                        '<div class="clearfix"></div>',
            ]*/
//             'itemLabelSingle' => 'class',
//            'itemLabelPlural' => 'classes',
        ])?>

    </div>
</div>
</div>
<div class="col-md-8">
 <div   class="feeHeadsDetails"></div>
</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
