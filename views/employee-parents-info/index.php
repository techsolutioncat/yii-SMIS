<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeParentsInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Parents Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-parents-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee Parents Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'emp_parent_id',
            'fk_branch_id',
            'first_name',
            'middle_name',
            'last_name',
            // 'cnic',
            // 'email:email',
            // 'contact_no',
            // 'profession',
            // 'contact_no2',
            // 'emp_id',
            // 'spouse_name',
            // 'no_of_children',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
