<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeeGroup */
?>
<div class="fee-group-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'options' => array('class' => 'table table-striped table-hover table-bordered detail-view'),
        'attributes' => [
            //'id',
            // 'fk_branch_id',
            [
                'attribute' => 'fk_class_id',
                'value' => function($data) {
                    return ucfirst($data->fkClass->title);
                }
            ],
            [
                'attribute' => 'fk_group_id',
                'value' => function($data) {
                    if ($data->fk_group_id) {
                        return ucfirst($data->fkGroup->title);
                    } else {
                        return 'N/A';
                    }
                }
            ],
            [
                'attribute' => 'fk_fee_head_id',
                'value' => function($data) {
                    return ucfirst($data->fkFeeHead->title);
                }
            ],
            [
                'attribute' => 'amount',
                'value' => function($data) {
                    return Yii::$app->common->getNumberFormat($data->amount);
                }
            ],
            //'created_date',
            //'updated_date',
            [
                'attribute' => 'updated_by',
                'value' => function($data) {
                    if ($data->updated_by) {
                        return ucfirst($data->updatedBy->first_name . ' ' . $data->updatedBy->last_name);
                    } else {
                        return "N/A";
                    }
                }
            ],
                    [
                'attribute' => 'is_active',
                'value' => function($data) {
                    return ucfirst($data->is_active);
                }
            ],
        ],
    ])
    ?>

</div>
