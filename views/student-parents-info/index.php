<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentParentsInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Parents Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-parents-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Parents Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'stu_parent_id',
            'first_name',
            'middle_name',
            'last_name',
            'cnic',
            // 'email:email',
            // 'contact_no',
            // 'profession',
            // 'contact_no2',
            // 'stu_id',
            // 'gender_type',
            // 'guardian_name',
            // 'relation',
            // 'guardian_cnic',
            // 'guardian_contact_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
