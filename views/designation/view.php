<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefDesignation */
?>
<div class="ref-designation-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'designation_id',
           // 'fk_branch_id',
            'Title',
            //'fk_department_id',
            [
	        'class'=>'\kartik\grid\DataColumn',
	        'attribute'=>'fk_department_id',
	        'value'=>function($data){
	            if($data->fk_department_id){
	                return $data->fkDepartment->Title;
	            }else{
	                return "N/A";
	            }
        }
        ],
        ],
    ]) ?>

</div>
