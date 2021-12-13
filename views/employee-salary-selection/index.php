<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmployeeSalarySelectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Salary Selections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-salary-selection-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee Salary Selection', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_emp_id',
            'fk_group_id',
            'fk_pay_stages',
            'fk_allownces_id',
            // 'basic_salary',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
