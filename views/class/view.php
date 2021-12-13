<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefClass */
?>
<div class="ref-class-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            //'fk_branch_id',
            [
                'attribute'=>'fk_session_id',
                'value'=>function($data){
                    if($data->fk_session_id){
                        return $data->fkSession->title;
                    }else{
                        return 'N/A';
                    }
                }
            ]
        ],
    ]) ?>

</div>
