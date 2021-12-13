<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->getfullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $model->getfullName();
\yii\web\YiiAsset::register($this);
?>

<div class="row">
    <div class="col-md-9">
        <h4 class="mt-0 mb-0 "><b><i class="fa fa-user-circle"></i> <?php echo ucfirst($model->getfullName()); ?></b><small> view profile</small></h4>
    </div>
   
</div>
<hr class="  mt-4 mb-4 g-brd-gray-light-v4 g-mx-minus-20">
<?=
DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table table-stripedd table-bordered detail-view table-hover'],
    'attributes' => [
//            'id',
//            'role',
        'first_name',
        'middle_name',
        'last_name',
        'name_in_urdu',
        'email:email',
//            'username',
        [
            'attribute' => 'created_at',
            'value' => Yii::$app->common->getTimeStampFormat($model->created_at),
        ],
        [
            'attribute' => 'updated_at',
            'value' => Yii::$app->common->getTimeStampFormat($model->updated_at),
        ],
        [
            'attribute' => 'last_login',
            'value' => Yii::$app->common->getTimeStampFormat($model->last_login),
        ],
    ],
])
?>
 