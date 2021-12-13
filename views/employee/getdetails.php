<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
<?= GridView::widget([
        'dataProvider' => $passvalue,
        'summary'=>'', 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           // 'fk_empl_id',
            // [
            // 'attribute'=>'Checkin Date',
            // 'value'=>'date',
            // ],
            [
                                'attribute'=>'leave_type',
                                'label'=>'Date',
                                'value'     => function($data){
                                    if($data->leave_type == 'leave'){
                                        return ucfirst(date('Y-m-d',strtotime($data->date)));
                                    }else{
                                        return $data->date;
                                    }
                                }
                            ],
           'leave_type',
           'remarks',

             
        ],
    ]); ?>

    </div>
</div>