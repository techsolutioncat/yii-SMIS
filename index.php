<?php
// comment out the following two lines when deployed to production
error_reporting(-1);
ini_set('display_errors', true);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/components/CommonHelper.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/config/web.php');
use app\components\CommonHelper;
/*$application = new yii\web\Application($config);
$branch = CommonHelper::getBranch();
$branch_name = stristr($_SERVER['HTTP_HOST'],".",true);
if($branch){
    $application->run();
}else{
    echo "<h1><b>404!</b></h1> Branch ".$branch_name." is not exist!";
}*/
(new yii\web\Application($config))->run();

