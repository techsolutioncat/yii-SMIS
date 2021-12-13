<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Stop */
?>
<div class="stop-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
           // 'fk_route_id',
            [
            'label'=>'Route',
            'value'=>function($data){
                if($data->fk_route_id){
                    return $data->fkRoute->title;
                }else{
                    return "N/A";
                }
            }
            ],
            'fare',
        ],
    ]) ?>

</div>
