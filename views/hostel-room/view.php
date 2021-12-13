<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HostelRoom */
?>
<div class="hostel-room-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'fk_FLOOR_id',
        ],
    ]) ?>

</div>
