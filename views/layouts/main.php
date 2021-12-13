<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
$controller =  Yii::$app->controller->id;
$action     = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <!--<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web'); ?>/css/icon-awesome/css/font-awesome.min.css">
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head();
    if($controller =='student'){
        $this->registerJsFile(Yii::getAlias('@web').'/js/student.js',['depends' => [yii\web\JqueryAsset::className()]]); 
    }
    if($controller =='fee' || $controller == 'fee-group' ){
        $this->registerJsFile(Yii::getAlias('@web').'/js/fee.js',['depends' => [yii\web\JqueryAsset::className()]]);
    }
    if($controller =='exams'){
        $this->registerJsFile(Yii::getAlias('@web').'/js/exams.js',['depends' => [yii\web\JqueryAsset::className()]]);
    }
    if($controller =='reports'){
        $this->registerJsFile(Yii::getAlias('@web').'/js/reports.js',['depends' => [yii\web\JqueryAsset::className()]]);
    }
    if($controller =='branch'){
        if(yii::$app->user->identity->fk_role_id !=2){
            header("Location: ".Url::to(['site/login'],true));
            exit;
        }
    }
    if($controller =='branch-reports'){
        if(yii::$app->user->identity->fk_role_id !=2){
            header("Location: ".Url::to(['site/login'],true));
            exit;
        }else{
            $this->registerJsFile(Yii::getAlias('@web').'/js/branch-reports.js',['depends' => [yii\web\JqueryAsset::className()]]);
        }
    }

    ?>
</head>
<body class="<?=$controller.'-'.$action?>">
<?php $this->beginBody() ?> 
<div class="wrap">
    <?php
    if($action != 'login') {
        echo $this->render('navigation.php');
    } 
    ?> 
    <div class="container-wrap pad">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php
if($action != 'login') {
    //echo  $this->render('footer.php');
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
