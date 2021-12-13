<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeCollectionParticular */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Fee Collection Particulars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-collection-particular-view">

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
                   /* return $data->fkFeeParticular->fkStu->user->first_name.' '.$data->fkFeeParticular->fkStu->user->last_name.'-'.$data->fkFeeParticular->fkFeePlanType->title.' '.$data->fkFeeParticular->fkFeeHead->title;*/
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
            ],  [
                'attribute'=>'fk_fee_discount_id',
                'value'=>function($data){
                    if($data->fk_fee_discount_id){
                        return $data->fkFeeDiscount->fkFeeDiscountsType->title;
                    }else{
                        return 'N/A';
                    }

                }
            ],
            'transport_fare',
            'fee_payable',
            'is_active',
            'due_date',
        ],
    ]) ?>

</div>
