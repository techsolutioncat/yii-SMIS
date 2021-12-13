<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Hostel */
?>
<div class="hostel-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
           // 'fk_branch_id',
            'Name',
            'address',
            'contact_no',
            'fk_warden_id',
            'amount',
        ],
    ]) ?>

</div>
