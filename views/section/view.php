<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefSection */
?>
<div class="ref-section-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            /*[
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'section_id',
                'value'=>function($data){
                    return $data->title;
                }
            ],*/
            'title',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'class_id',
                'value'=>function($data){
                    return $data->class->title;
                }
            ],
        ],
    ]) ?>

</div>
