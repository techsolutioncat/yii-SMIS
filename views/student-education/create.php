<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentEducationalHistoryInfo */

$this->title = 'Create Student Educational History';
//$this->params['breadcrumbs'][] = ['label' => 'Student Educational History Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="student-educational-history-info-create content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="subjects-index shade padd">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
