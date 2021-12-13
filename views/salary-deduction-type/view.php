<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryDeductionType */
?>
<div class="salary-deduction-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'amount',
        ],
    ]) ?>

</div>
