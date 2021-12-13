<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ExamType */
?>
<div class="exam-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'type',
            //'fk_branch_id',
        ],
    ]) ?>

</div>
