<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */ 
$this->title = 'Subjects';
//$this->params['breadcrumbs'][] = $this->title; 
CrudAsset::register($this); 
?>  
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title">Subjects listing</h1>
    <div class="form-midd action-head">
    	<a id="add_exam" class="btn green-btn show" href="#">+ Add Subject</a>
        <a id="close_exam_d" class="btn green-btn red-close hide" href="#">X Close</a>
        <div class="dropdown-menu subject-dd">  
           	<div class="sbdd_form">
            	<!-- Form Name -->
				<legend>Add New Subject</legend>
                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-12 control-label" for="">Class</label>
                  <div class="col-md-12">
                    <select id="" name="" class="form-control">
                      <option value="1">Class 1</option>
                      <option value="">Class 1</option>
                      <option value="">Class 1</option>
                      <option value="">Class 1</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 control-label" for="">Group</label>
                  <div class="col-md-12">
                    <select id="" name="" class="form-control">
                      <option value="1">Group 1</option>
                      <option value="">Group 1</option>
                      <option value="">Group 1</option>
                      <option value="">Group 1</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 control-label" for="textinput">Title</label>  
                  <div class="col-md-12">
                  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md">   
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 control-label" for="textinput">Code</label>  
                  <div class="col-md-12">
                  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md">   
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-12 control-label" for="">Status</label>
                  <div class="col-md-12">
                    <select id="" name="" class="form-control">
                      <option value="1">Status 1</option>
                      <option value="">Status 1</option>
                      <option value="">Status 1</option>
                      <option value="">Status 1</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                	 <div class="col-md-12">
                  		<input name="textinput" type="submit"class="btn green-btn" value="Save">   
                     </div>
                </div>
                
                
                
                
                
            </div>
        </div>
    </div>
    <div id="subject-wrap" class="form-midd shade fee-gen pad15 remov_head"> 
        <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Subjects','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>false, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'/*.
                    '{export}'*/
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                //'heading' => '<i class="glyphicon glyphicon-list"></i> Subjects listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',

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
