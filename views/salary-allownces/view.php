<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryAllownces */
?>
<div class="salary-allownces-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
            'label'=>'Stage',
            'value'=>function($data){
            	if($data->fk_stages_id){
            		return $data->fkStages->title;
            	}else{
            		return 'N/A';
            	}
            }
            ],
            'amount',
        ],
    ]) ?>

</div>
