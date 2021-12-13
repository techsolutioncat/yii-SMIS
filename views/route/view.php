<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Route */
?>
<div class="route-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'fk_zone_id',
        ],
    ]) ?>

</div>
