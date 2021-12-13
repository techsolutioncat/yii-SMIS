<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="settings-index content_col grey-form"> 
	<h1 class="p_title">Branch Settings</h1>
    <div class="subjects-index shade">  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 
    <p>
        <?= Html::a('Create Settings', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fk_branch_id',
            'fee_due_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
