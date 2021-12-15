<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BranchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Branch', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'description:ntext',
            //'logo',
            'address',
            [  
                'attribute'=>'fk_city_id',
                'label'=>'City',
                'value'     => function($data){
                    return (!empty($data->fkCity->city_name))? ucfirst($data->fkCity->city_name): '';
                }
            ],
            [
                'attribute'=>'fk_district_id',
                'label'=>'District',
                'value'     => function($data){
                    return ucfirst($data->fkDistrict->District_Name);
                }
            ],
            // 'fk_province_id',
            // 'zip',
            // 'phone',
            // 'website',
            // 'email:email',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
