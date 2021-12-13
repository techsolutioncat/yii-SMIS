<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmplEducationalHistoryInfo */

$this->title = 'Create Empl Educational History Info';
//$this->params['breadcrumbs'][] = ['label' => 'Empl Educational History Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="empl-educational-history-info-create content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>

    <div class="form-center shade fee-gen padd">    
        <?= $this->render('_form', [
            'model' => $model,
            'model2'=>$model2,
        ]) ?>
        </div>


</div>

