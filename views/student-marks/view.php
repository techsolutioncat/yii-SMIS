<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentMarks */
?>
<div class="student-marks-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'marks_obtained',
            'fk_exam_id',
            'fk_student_id',
            'remarks',
        ],
    ]) ?>

</div>
