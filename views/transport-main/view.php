<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TransportMain */
?>
<div class="transport-main-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fk_route_id',
            'fk_driver_id',
            'fk_vechicle_info_id',
        ],
    ]) ?>

</div>
