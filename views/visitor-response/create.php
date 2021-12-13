<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VisitorResponseInfo */

$this->title = 'Create Visitor Response Info';
$this->params['breadcrumbs'][] = ['label' => 'Visitor Response Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-response-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
