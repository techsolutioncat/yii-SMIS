<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmployeeBankInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Bank Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-bank-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee Bank Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_emp_id',
            'bank_name',
            'branch_name',
            'branch_code',
            // 'account_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
