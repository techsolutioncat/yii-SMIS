<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profession */
?>
<div class="profession-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
        ],
    ]) ?>

</div>
