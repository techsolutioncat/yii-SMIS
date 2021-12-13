<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SalaryMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salary Mains';
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="salary-main-index content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="head_btn_top col-sm-12">
  	<p class="pull-right"><?= Html::a('Create Salary Main', ['create'], ['class' => 'btn green-btn']) ?></p>
    </div>
    <div class="subjects-index shade">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
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
            'label'=>'Pay Stage',
            'value'=>function($data){
                if($data->fk_pay_stages){
                    return $data->fkPayStages->title;
                }else{
                    return "N/A";
                }
            }
            ],
            //'fk_pay_stages',
            //'fk_emp_id',
            
            'basic_salary',
            
            //'fk_allownces_id',
            // 'bonus',
            // 'fk_deduction_tpe',
            // 'deduction_amount',
            // 'fk_tax_id',
            // 'gross_salary',
            // 'salary_month',
            // 'is_paid',
            // 'payment_date',
            // 'tax_amount',

            ['class' => 'yii\grid\ActionColumn'],
            
            
        ],
    ]); ?>
</div>
</div>