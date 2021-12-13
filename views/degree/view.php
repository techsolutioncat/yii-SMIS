<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefDegreeType */
?>
<div class="ref-degree-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'degree_type_id',
            'Title',
        ],
    ]) ?>

</div>
