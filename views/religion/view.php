<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefReligion */
?>
<div class="ref-religion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'religion_type_id',
            'Title',
        ],
    ]) ?>

</div>
