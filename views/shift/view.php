<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefShift */
?>
<div class="ref-shift-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'shift_id',
            'fk_branch_id',
            'title',
        ],
    ]) ?>

</div>
