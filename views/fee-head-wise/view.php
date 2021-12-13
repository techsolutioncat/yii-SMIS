<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeHeadWise */
?>
<div class="fee-head-wise-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fk_branch_id',
            'fk_stu_id',
            'fk_fee_particular_id',
            'payment_received',
            'is_paid',
            'fk_chalan_id',
            'created_date',
            'updated_date',
            'updated_by',
        ],
    ]) ?>

</div>
