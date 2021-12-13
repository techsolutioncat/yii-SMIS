<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentFineDetail */
?>
<div class="student-fine-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute'=>'fk_fine_typ_id',
                'value'=>function($data){
                    return $data->fkFineTyp->title;
                }
            ],
            'remarks',
            'created_date',
            'updated_date',
            'amount',
            'is_active',
        ],
    ]) ?>

</div>
