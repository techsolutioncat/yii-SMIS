<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use \app\widgets\Alert;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Alert::widget()?>
<div class="student-info-index fee-res-left cscroll ">
    <?= $this->render('_form', [
        'model'     => $model,
        'query'    => $query
    ]) ?>
</div>
