<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeHeads */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Heads';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="fee-heads-index form-center shade fee-gen pad15 hideFooter">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'=>true,
             'summary' => '',
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add Fee Head ', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Fee Heads','class'=>'btn btn-default'])
                    /*.
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'*/
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,  
            'showPageSummary' => false, // at the bottom of the table
            'panel' => [
                'footer' => false,
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Fee Heads listing',
                'before'=>'<em>* manage fee heads, you can add new, update or   delete fee head.</em>',
                /*'after'=>BulkButtonWidget::widget([
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
                        ]).*/                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
