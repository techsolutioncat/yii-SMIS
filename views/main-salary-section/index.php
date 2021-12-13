<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MainSalarySectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Main Salary Sections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-salary-section-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Main Salary Section', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mss_id',
            'value',
            'emp_id',
            'ss_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
