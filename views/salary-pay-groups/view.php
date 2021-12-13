<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryPayGroups */
?>
<div class="salary-pay-groups-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
            'created_date',
            'updated_date',
            //'fk_branch_id',
            //'status',
        ],
    ]) ?>

</div>
