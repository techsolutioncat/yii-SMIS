<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RefDegreeTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Submission';
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->request->get('ch_id')) {
    $this->registerJs("$('#generate-challan-view')[0].click();",\Yii\web\View::POS_LOAD);
}
?>
<div class="free-generator content_col"> 
	<h1 class="p_title"><?//=$message?>Fee Submission</h1>
    <div class="mid_mini shade fee-gen">  
        <?=Alert::widget()?> 
        <div class="form-group field-search required">
            <label class="control-label" for="Search Challan/Student Name">Search Challan/Student Name</label>
            <div class="inn_pt">
            	<input type="text" id="search_chalan_stdnme" class="form-control col-sm-9" name="search_chalan_stdnme">
            	<?php  echo Html::button('Search',['class'=>'btn green-btn col-sm-3','id'=>'get-challan-details','data-url'=>Url::to(['fee/get-fee-details'])]); ?>
            </div>
            <div class="help-block"></div>
        </div>   
        <div class="alert alert-info">
        	<strong>Note!</strong> Search by student first name or by Challan No.
        </div>
	</div> 
<div class="row" id="detailed-area">

</div>
<?php
if(Yii::$app->request->get('ch_id')) {
    ?>
<?= Html::a('generate fee challan.',['student/generate-student-fee-challan', 'challan_id' => Yii::$app->request->get('ch_id'),'stu_id' =>Yii::$app->request->get('stu_id')],['style'=>'visibility:hidden;','id'=>'generate-challan-view'])?>
    <?php
	}
?>
</div>