<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\FeeTransactionDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fee Transaction Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-transaction-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn green-btn']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'opening_balance',
            'transaction_amount',
            //'fk_branch_id',
        ],
    ]) ?>

</div>
