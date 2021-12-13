<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefInstituteType */
?>
<div class="ref-institute-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'institute_type_id',
            'Title',
        ],
    ]) ?>

</div>
