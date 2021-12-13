<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeTransactionDetails */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Transaction Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-transaction-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fee Transaction Details', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'challan_no',
            [
                'attribute'=>'stud_id',
                'value'=>function($data){
                    return $data->stud->user->first_name.' '.$data->stud->user->last_name;
                }
            ],
            'fk_fee_collection_particular',
            [
                'attribute'=>'transaction_date',
                'value'=>function($data){
                    return date('d-m-Y',strtotime($data->transaction_date));
                }
            ],
            // 'opening_balance',
            // 'transaction_amount',
            // 'fk_branch_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
