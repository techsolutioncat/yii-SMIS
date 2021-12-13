<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryPayStages */
?>
<div class="salary-pay-stages-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
            'label'=>'Groups',
            'value'=>function($data){
            	if($data->fk_pay_groups){
            		return $data->fkPayGroups->title;
            	}else{
            		return 'N/A';
            	}
            }
            ],
            
            'amount',
        ],
    ]) ?>

</div>
