<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeePlanType */
?>
<div class="fee-plan-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            'title',
            'description',
            'no_of_installments',
        ],
    ]) ?>

</div>
