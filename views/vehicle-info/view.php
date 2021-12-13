<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleInfo */
?>
<div class="vehicle-info-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Name',
            'registration_no',
            'model',
            'no_of_seats',
            'vehicle_make',
        ],
    ]) ?>

</div>
