<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubjectDivision */
?>
<div class="subject-division-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute'=>'fk_subject_id',
                'value'=>function($data){
                    return $data->fkSubject->title;
                }
            ],
            'title',
            'status',
            'created_date',
        ],
    ]) ?>

</div>
