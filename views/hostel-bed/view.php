<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HostelBed */
?>
<div class="hostel-bed-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'fk_room_id',
            [
                'label'=>'Room',
                'value'=>function($data){
                    if($data->fk_room_id){
                        return $data->fkRoom->title;
                    }else{
                        return "N/A";
                    }
                }
            ],
        ],
    ]) ?>

</div>
