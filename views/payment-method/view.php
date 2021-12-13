<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentMethod */
?>
<div class="payment-method-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'title',
        ],
    ]) ?>

</div>
