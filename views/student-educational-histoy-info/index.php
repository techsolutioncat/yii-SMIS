<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentEducationalHistoryInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Educational History Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-educational-history-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Educational History Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'edu_history_id',
            'degree_name',
            'degree_type_id',
            'Institute_name',
            'institute_type_id',
            // 'grade',
            // 'total_marks',
            // 'start_date',
            // 'end_date',
            // 'stu_id',
            // 'marks_obtained',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
