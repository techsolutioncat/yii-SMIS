<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
?>
<div class="exam-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'fk_branch_id',
            //'fk_class_id',
            //'fk_group_id',
            //'fk_subject_id',
            //'fk_section_id',
           // 'fk_exam_type',
            //'total_marks',
            //'passing_marks',
            'start_date',
            'end_date',
            //'created_date',
        ],
    ]) ?>

</div>
