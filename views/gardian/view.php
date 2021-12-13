<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefGardianType */
?>
<div class="ref-gardian-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gardian_type_id',
            'Title',
        ],
    ]) ?>

</div>
