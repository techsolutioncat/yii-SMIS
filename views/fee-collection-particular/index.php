<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeeCollectionParticular */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Collection Particulars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-collection-particular-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fee Collection Particular', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'fk_branch_id',
            [
                'attribute'=>'fk_stu_id',
                'value'=>function($data){
                    return $data->fkStu->user->first_name.' '.$data->fkStu->user->last_name;
                }
            ],
            [
                'attribute'=>'total_fee_amount',
                'value'=>function($data){
                    /*return $data->fkFeeParticular->fkStu->user->first_name.' '.$data->fkFeeParticular->fkStu->user->last_name.'-'.$data->fkFeeParticular->fkFeePlanType->title.' '.$data->fkFeeParticular->fkFeeHead->title;*/
                    return $data->total_fee_amount;
                }
            ],
            [
                'attribute'=>'fk_fine_id',
                'value'=>function($data){
                    if($data->fk_fine_id){
                        return $data->fkFine->fkFineTyp->title.'-'.$data->fkFine->amount;
                    }else{
                        return 'N/A';
                    }
                }
            ],
            // 'transport_fare',
            // 'fk_fee_discount_id',
            // 'fee_payable',
            // 'is_active',
            // 'due_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
