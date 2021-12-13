<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\User;
use app\widgets\Alert;

$userModel = User::findOne(Yii::$app->user->identity->id);

$mId = Yii::$app->controller->module->id;
$cId = Yii::$app->controller->id;
$aId = Yii::$app->controller->action->id;


$this->beginContent('@app/views/layouts/main.php');
?>




<div class="row">
    <div class="col-lg-3 g-mb-50 g-mb-0--lg">
        <div class="u-block-hover g-pos-rel mb-2 g-brd-around g-brd-gray-light-v4">
            <figure>
                <img class="img-thumbnail" style="  width: 100% !important; margin-bottom: 5px; border-radius: 5px; padding:2px; "  src="<?php echo Yii::$app->common->getLoginUserProfilePicture(); ?>" alt="">
            </figure>
        </div>

        <div class="list-group list-group-border-0 g-mb-30">
            <?= Html::a('<span><i class="fa fa-picture-o g-pos-rel g-top-1 g-mr-8"></i> View Profile  </span>', [ '/me/view'], ['class' => 'list-group-item justify-content-between  ' . ($aId == 'view' ? "active" : "") . '']); ?>
            <?= Html::a('<span><i class="fa fa-edit g-pos-rel g-top-1 g-mr-8"></i> Edit Profile  </span>', [ '/me/edit'], ['class' => 'list-group-item justify-content-between ' . ($aId == 'edit' ? "active" : "") . '']); ?>
            <?= Html::a('<span><i class="fa fa-asterisk g-pos-rel g-top-1 g-mr-8"></i> Change Password </span>', [ '/me/changepassword'], ['class' => 'list-group-item justify-content-between ' . ($aId == 'changepassword' ? "active" : "") . '']); ?>
            <?= Html::a('<span><b><i class="fa fa-power-off g-pos-rel g-top-1 g-mr-8"></i> Logout </b>  </span>', [ '/site/logout'], ['class' => 'list-group-item justify-content-between ']); ?>
        </div> 
    </div>  


    <div class="col-lg-9">
        <?php if (Yii::$app->session->hasFlash('message')): ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= Yii::$app->session->getFlash('message') ?>
            </div>
        <?php endif; ?>
        <div class="    shade   pad15  ">
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
