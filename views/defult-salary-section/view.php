<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DefultSalarySection */
?>
<div class="defult-salary-section-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ss_id',
            'category_name',
            'id_deducted',
        ],
    ]) ?>

</div>
