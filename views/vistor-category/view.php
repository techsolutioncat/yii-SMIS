<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VistorCategory */
?>
<div class="vistor-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
        ],
    ]) ?>

</div>
