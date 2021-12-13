<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeePaymentMode */
?>
<div class="fee-payment-mode-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            'title',
            'time_span',
        ],
    ]) ?>

</div>
