<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HostelFloor */
?>
<div class="hostel-floor-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'title',
            [
            'label'=>'Hostel',
            'value'=>function($data){
                if($data->fk_hostel_info_id){
                return $data->fkHostelInfo->Name;
                }else{
                    return "N/A";
                }
            }
            ],
        ],
    ]) ?>

</div>
