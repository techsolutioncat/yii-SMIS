<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefSession */
?>
<div class="ref-session-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'session_id',
            'fk_branch_id',
            'title',
        ],
    ]) ?>

</div>
