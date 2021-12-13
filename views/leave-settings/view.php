<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LeaveSettings */
?>
<div class="leave-settings-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'allowed_leaves',
            'shortleave_policy',
            'latecommer_policy',
           // 'branch_id',
           // 'status',
        ],
    ]) ?>

</div>
