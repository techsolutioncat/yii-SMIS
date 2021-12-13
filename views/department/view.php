<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefDepartment */
?>
<div class="ref-department-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'department_type_id',
            'Title',
        ],
    ]) ?>

</div>
