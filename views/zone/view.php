<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Zone */
?>
<div class="zone-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            'title',
        ],
    ]) ?>

</div>
