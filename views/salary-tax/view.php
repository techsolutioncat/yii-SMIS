<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryTax */
?>
<div class="salary-tax-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'tax_rate',
        ],
    ]) ?>

</div>
