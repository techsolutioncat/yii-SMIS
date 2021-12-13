<?php
//echo $_SERVER['QUERY_STRING'];
//die;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryMain */

$this->title = $model->id;
$this->title = 'View Salary Mains';
//$this->params['breadcrumbs'][] = ['label' => 'Salary Mains', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->request->get('id')) {
    $this->registerJs("$('#empPdf')[0].click();",\Yii\web\View::POS_LOAD);
}
?>

<?php
        if(Yii::$app->request->get('id')) {
            ?>
            <?= Html::a('generate Salary challan.',['salary-main/create-mpdf', 'salary_id' => Yii::$app->request->get('id')],['style'=>'visibility:hidden;','id'=>'empPdf'])?>
            <?php
        }
        ?> 
<div class="salary-main-view content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="head_btn_top col-sm-12">
        <p class="pull-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn green-btn']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <div class="subjects-index shade padd">  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
           // 'fk_pay_stages',
            //'fk_emp_id',
            [
            'attribute'=>'fk_emp_id',
            'label'=>'Employee',
            'value'=>function($data){
                if($data->fk_emp_id){
                    return $data->fkEmp->user->first_name;
                }else{
                    return "N/A";
                }
            }
            ],
            [
            'attribute'=>'fk_pay_stages',
            'label'=>'Stage',
            'value'=>function($data){
                if($data->fk_pay_stages){
                    return $data->fkPayStages->title;
                }else{
                    return "N/A";
                }
            }
            ],
            
            'basic_salary',
            //'fk_allownces_id',
            
            'bonus',
            //'fk_deduction_tpe',
            
            'deduction_amount',
            [
            'label'=>'Tax',
            'value'=>function($data){
                if($data->fk_tax_id){
                    return $data->fkTax->tax_rate;
                }else{
                    return "N/A";
                }
            }
            ],
            'gross_salary',
            //'salary_month',
            [
            'attribute'=>'salary_month',
            //'label'=>'Deduction Type',
            'value'=>function($data){
                return date('Y-m-d');
            }
            ],
          //  'is_paid',
            [
            'attribute'=>'is_paid',
            //'label'=>'Deduction Type',
            'value'=>function($data){
                if($data->is_paid == 1){
                    return 'Yes';
                }else{
                    return "No";
                }
            }
            ],
            //'payment_date',
            [
            'attribute'=>'payment_date',
            //'label'=>'Deduction Type',
            'value'=>function($data){
                return date('Y-m-d');
            }
            ],
            'tax_amount',
            'salary_payable',
        ],
    ]) ?>

</div>
</div>