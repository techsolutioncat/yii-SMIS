<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HostelDetail */
?>
<div class="hostel-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fk_hostel_id',
            'fk_floor_id',
            'fk_room_id',
            'fk_bed_id',
            'is_booked',
            'fk_student_id',
            'create_date',
        ],
    ]) ?>

</div>
