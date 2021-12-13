<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefGroup */
?>
<div class="ref-group-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // [
            // 'attribute'=>'group_id',
            // 'value'=>function($data){
            // 	if($data->group_id){
            // 		return $data->group_id;
            // 	}else{
            // 		return "N/A";
            // 	}
            // }
            // ],
            //'fk_branch_id',
            'title',
        ],
    ]) ?>

</div>
