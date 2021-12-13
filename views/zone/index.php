<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchZoneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zones';
//$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?> 
<div class="filter_wrap content_col tabs grey-form mcm_s">  
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen pad15 remov_head">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns.php'),
                'toolbar'=> [
                    ['content'=>
                        //Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                        Html::a('Add Zone', ['create'],
                        ['role'=>'modal-remote','title'=> 'Create new Zones','class'=>'btn green-btn']),
                        /*.
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn green-btn', 'title'=>'Reset Grid']).
                        '{toggleData}'.
                        '{export}'*/
                    ],
                ],          
                'striped' => true,
                'condensed' => true,
                'responsive' => true,          
                'panel' => [
                    'type' => 'primary', 
                    //'heading' => '<i class="glyphicon glyphicon-list"></i> Zones listing',
                    //'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
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
                            ]). */                       
                            '<div class="clearfix"></div>',
                ]
            ])?>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
