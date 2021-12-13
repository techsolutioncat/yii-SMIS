<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VisitorAdvertisementMedium */
?>
<div class="visitor-advertisement-medium-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
        ],
    ]) ?>

</div>
