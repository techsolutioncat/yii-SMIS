<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WorkingDays */

$this->title = 'Create Working Days for Students';
/*$this->params['breadcrumbs'][] = ['label' => 'Working Days', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="working-days-create content_col exam-form grey-form">

    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
   	<div class="mid_mini shade fee-gen">  
	
    <?= $this->render('_formA', [
        'model' => $model,
    ]) ?>
    </div>

</div>
