<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VisitorResponseInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitor Response Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-response-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Visitor Response Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_admission_vistor_id',
            'first_attempt_date',
            'second_attempt_date',
            'third_attempt_date',
            // 'remarks',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
